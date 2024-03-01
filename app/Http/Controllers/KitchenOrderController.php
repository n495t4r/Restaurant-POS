<?php

namespace App\Http\Controllers;

use App\Models\KitchenOrder;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class KitchenOrderController extends Controller
{
    // function __construct()
    // {
    //      $this->middleware('permission:kitchen-display', ['only' => ['index','store', 'show', 'update', 'getPendingOrders']]);
    //     //  $this->middleware('permission:kitchen-dispay', ['only' => ['create','store']]);
    //     //  $this->middleware('permission:order-edit', ['only' => ['edit','update']]);
    //     //  $this->middleware('permission:order-delete', ['only' => ['destroy']]);
    // }

    public function index()
{
    $kitchenOrders = Order::where('status', 'pending')
        ->with(['items.product.product_category.parent'])
        ->orderBy('created_at', 'desc')
        ->get();

    foreach ($kitchenOrders as $order) {
        $order->items = $order->items->filter(function ($item) {
            $parentCategoryName = $item->product->getParentCategoryName();
            return $parentCategoryName !== 'Drinks' && !empty($parentCategoryName);
        });
    }

    // Check if any kitchen order has no items left after filtering
    if ($kitchenOrders->isEmpty() || $kitchenOrders->every(function ($order) {
        return $order->items->isEmpty();
    })) {
        $kitchenOrders = collect(); // Set the kitchen orders to an empty collection
    }

    return view('kitchen.index', compact('kitchenOrders'));
}


    public function getPendingOrders(Request $request)
    {
        $lastDisplayedOrderId = $request->query('lastDisplayedOrderId');
        $pendingOrders = Order::where('status', 'pending')
            ->where('id', '>', $lastDisplayedOrderId)
            ->with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->get();
    
        foreach ($pendingOrders as $order) {
            $order->items = $order->items->filter(function ($item) {
                return !$item->product->getParentCategoryName() === 'Drinks';
            });
        }
    
        return $pendingOrders;
    }
    


    

    public function drinks()
{
    // die("Index controller");
    $kitchenOrders = Order::where('status', 'pending')
        ->with(['items.product'])
       
        ->orderBy('created_at', 'desc')
        // ->limit(2)
        ->get();

    return view('drinks.index', compact('kitchenOrders'));
}

    public function getPendingOrders2(Request $request)
    {
        $lastDisplayedOrderId = $request->query('lastDisplayedOrderId');
        $pendingOrders = Order::where('status', 'pending')
        ->where('id', '>', $lastDisplayedOrderId)
        ->with(['items.product'])
        ->orderBy('created_at', 'desc')
        ->get();
        return $pendingOrders;
    }
    


    public function show($id)
    {

        // die("Show controller");
        $kitchenOrder = KitchenOrder::with('order')->findOrFail($id);

        return view('kitchen.show', compact('kitchenOrder'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($request->has('customer_id')) {
            $order->customer_id = $request->customer_id;
            $order->save();
        }
        
        if ($request->has('payment_method')) {
            
            try {

                // Validate the request data
                $validator = Validator::make($request->all(), [
                    'payment_method' => 'required|array',
                    'payment_method.*' => 'required|string', // Assuming payment_methods is an array of strings
                ]);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }

                // Update payment_methods for all payments related to this order
                $affectedRows = $order->payments()->update(['payment_methods' => json_encode($request->payment_method)]);

                if ($affectedRows > 0) {
                    // return response()->json(['message' => 'Payment methods updated successfully'], 200);
                } else {
                    return response()->json(['message' => 'No payments were updated.'], 400);
                }
            } catch (QueryException $e) {
                // Log or handle the error as needed
                return response()->json(['message' => 'Database error: ' . $e->getMessage()], 500);
            } catch (\Exception $e) {
            //     // Handle other exceptions
                return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
            }
        }
        
        if($order->status === 'processed' || $order->status === 'failed') {
            return response()->json(['message' => 'Order already marked as '.$order->status]);
        }else{
            

            if(isset($request->is_done)){

                $this->validate($request, [
                    'is_done' => 'required|boolean',
                ]);

                $status = $request->is_done ? 'processed' : 'failed';
                $reason = '';
                
                if(isset($request->reason)){
                    $reason = $request->reason;
                }

                // Update the associated order status
                if ($id) {
                    $order = Order::find($id);
                    $order->status = $status;
                    $order->reason = $reason;

                    if($order->status == 'failed') {
                        foreach ($order->items as $item) {
                            $product = Product::find($item->product_id);
                            $product->quantity += $item->quantity;
                            $product->save();
                        }
                    }

                    $order->save();
                }

                return response()->json(['message' => 'Order status updated successfully']);
            }
        }
      // Retrieve customer name and payment methods for response
      $response = [];
      if ($request->filled('customer_id') || $request->filled('payment_method')) {
          $response['customer_name'] = $order->getCustomerName();
          $response['payment_method'] = $order->payment_methods();
          return response()->json($response);
      }
       
    }
}


