<?php

namespace App\Http\Controllers;

use App\Events\NewOrderCreated;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:order-list', ['only' => ['index','store']]);
        //  $this->middleware('permission:order-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:order-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:order-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request) {
        $orders = Order::query();
    
        // Apply date range filters
        if($request->start_date) {
            $orders->where('created_at', '>=', $request->start_date);
        }
        if($request->end_date) {
            $orders->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }
    
        // Get the selected statuses from the request
        $selectedStatuses = $request->input('status', []);
        
        // Apply status filters if at least one status is selected
        if (!empty($selectedStatuses)) {
            // Filter orders based on selected statuses
            $orders->whereIn('status', $selectedStatuses);
        }
    
        // Load related items, payments, and customer
        $orders->with(['items', 'payments', 'customer']);
    
        // Retrieve and paginate the filtered orders
        $orders = $orders->latest()->paginate(200);
    
        // Calculate total and received amount
        $total = $orders->map(function($i) {
            return $i->total();
        })->sum();
        $receivedAmount = $orders->map(function($i) {
            return $i->receivedAmount();
        })->sum();
    
        return view('orders.index', compact('orders', 'total', 'receivedAmount'));
    }
    


    public function index2(Request $request) {
        $orders = new Order();
        if($request->start_date) {
            $orders = $orders->where('created_at', '>=', $request->start_date);
        }
        if($request->end_date) {
            $orders = $orders->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }

        // Get the selected statuses from the request
        $selectedStatuses = $request->input('status', []);
        
        if (!empty($selectedStatuses)) {
            // Filter orders based on selected statuses
            $orders = $orders->whereIn('status', $selectedStatuses);
        }

        // if (in_array('completed', $selectedStatuses)) {
        //     $orders = $orders->whereIn('status', ['processed']);
        // }

        // if (in_array('in-kitchen', $selectedStatuses)) {
        //     $orders = $orders->whereIn('status', ['pending']);
        // }
        
        // if (in_array('failed', $selectedStatuses)) {
        //     $orders = $orders->whereIn('status', ['failed']);
        // }

        $orders = $orders->with(['items', 'payments', 'customer'])->latest()->paginate(200);

        $total = $orders->map(function($i) {
            return $i->total();
        })->sum();
        $receivedAmount = $orders->map(function($i) {
            return $i->receivedAmount();
        })->sum();

        return view('orders.index', compact('orders', 'total', 'receivedAmount'));
    }

    public function store(OrderStoreRequest $request)
    {
        // die($request->payment_methods);
        $order = Order::create([
            'customer_id' => $request->customer_id,
            'user_id' => $request->user()->id,
            'commentForCook' => $request->commentForCook,
        ]);

        $order_id = $order->id;

        $cart = $request->user()->cart()->get();
        foreach ($cart as $item) {
            $order->items()->create([
                'price' => $item->price * $item->pivot->quantity,
                'quantity' => $item->pivot->quantity,
                'product_id' => $item->id,
            ]);
            $item->quantity = $item->quantity - $item->pivot->quantity;
            $item->save();
        }

        $request->user()->cart()->detach();

        $order->payments()->create([
            'amount' => $request->amount,
            'payment_methods' => json_encode($request->payment_methods),
            'user_id' => $request->user()->id,
        ]);

        // event(new NewOrderCreated($order));
        broadcast(new NewOrderCreated($order));

        return 'success';
    }
}
