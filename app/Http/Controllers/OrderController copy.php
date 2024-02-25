<?php

namespace App\Http\Controllers;

use App\Events\NewOrderCreated;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:order-list', ['only' => ['index','store','update']]);
        //  $this->middleware('permission:order-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:order-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:order-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request) {
        
        $orders = Order::query();

        $customers = Order::with('customer:id,first_name,last_name')
        ->select('customer_id')
        ->distinct()
        ->get()
        ->map(function ($order) {
            return [
                'id' => $order->customer_id,
                'name' => $order->getCustomerName(),
            ];
        });
    
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

        $selectedCustomers = $request->input('selectedCustomers');
        if ($selectedCustomers) {
            $selectedCustomers = [3,1];
            $orders->where(function ($query) use ($selectedCustomers) {
                $query->whereNotIn('customer_id', $selectedCustomers)
                    ->orWhereNull('customer_id');
            });
        }

    
        // Load related items, payments, and customer
        $orders->with(['items', 'payments', 'customer']);
    
        // Retrieve and paginate the filtered orders
        $orders = $orders->latest()->paginate(200);
    
        // Calculate total and received amount
        $total = $orders->map(function($i) {
            return $i->total();
        })->sum();
        $receivedAmount =8;// $orders->map(function($i) {
        //     return $i->receivedAmount();
        // })->sum();
    
        return view('orders.index', compact('orders', 'total', 'receivedAmount','customers'));
    }
   
    public function store(OrderStoreRequest $request)
    {
        // Create the order
        $order = Order::create([
            'customer_id' => $request->customer_id,
            'user_id' => $request->user()->id,
            'commentForCook' => $request->commentForCook,
        ]);
    
        // Loop through the cart items and associate them with the order
        foreach ($request->cart as $item) {
            $order->items()->create([
                'price' => $item['price'] * $item['quantity'],
                'quantity' => $item['quantity'],
                'product_id' => $item['id'],
            ]);
            // Assuming you want to update the quantity of the product in your database,
            // you can do it here
            $product = Product::find($item['id']);
            $product->quantity -= $item['quantity'];
            $product->save();
        }
    
        // Create a payment record for the order
        $order->payments()->create([
            'amount' => $request->amount,
            'payment_methods' => json_encode($request->payment_methods),
            'user_id' => $request->user()->id,
        ]);
    
        // You can trigger events or notifications here if needed
    
        return 'success';
    }

}
