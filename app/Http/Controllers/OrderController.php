<?php

namespace App\Http\Controllers;

use App\Events\NewOrderCreated;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
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

    public function index() {
        
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


    public function show(Request $request)
    {
        $query = Order::query();

        // Apply filters based on request parameters
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', Carbon::yesterday());
                    break;
                case 'last_7_days':
                    $query->whereBetween('created_at', [Carbon::now()->subDays(6), Carbon::now()]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', Carbon::now()->month);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', Carbon::now()->year);
                    break;
                case 'custom_range':
                    if ($request->has('start_date') && $request->has('end_date')) {
                        $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
                    }
                    break;
                default:
                    // If an invalid filter value is provided, return a meaningful error response
                    return response()->json(['error' => 'Invalid filter value'], 400);
                }
        }
        // Get the selected statuses from the request
        $selectedStatuses = $request->input('status', []);
        
        // Apply status filters if at least one status is selected
        if (!empty($selectedStatuses)) {
            // Filter orders based on selected statuses
            $query->whereIn('status', $selectedStatuses);
        }

        // Get the selected statuses from the request
        $paymentFilter = $request->input('payment', []);
        
        // Apply payment filters if at least one method is selected
        if (!empty($paymentFilter)) {
            // Filter orders based on selected payment method
            $query->whereHas('payments', function ($query) use ($paymentFilter) {
                $query->where(function ($query) use ($paymentFilter) {
                    foreach ($paymentFilter as $method) {
                        $query->orWhereJsonContains('payment_methods', $method);
                    }
                });
            });
        }

        $selectedCustomers = $request->input('selectedCustomers');
        if ($selectedCustomers) {
            $selectedCustomers = [3,1];
            $query->where(function ($query) use ($selectedCustomers) {
                $query->whereNotIn('customer_id', $selectedCustomers)
                    ->orWhereNull('customer_id');
            });
        }

    
        // Load related items, payments, and customer
        $query->with(['items.product', 'payments', 'customer']);
    
        // Retrieve and paginate the filtered orders
        $orders = $query->latest()->paginate(200);
    
        // Calculate total and received amount
        $total = $orders->map(function($i) {
            return $i->total();
        })->sum();
        $receivedAmount =8;// $orders->map(function($i) {
        //     return $i->receivedAmount();
        // })->sum();

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
    
        // return view('orders.index', compact('orders', 'total', 'receivedAmount','customers'));
        return response()->json([
            'orders' => $orders,
            'total' => $total,
            'receivedAmount' => $receivedAmount,
            'customers' => $customers
        ]);
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
    
        return 'success: order created';
    }

}
