<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    function __construct()
    {
        $this->middleware('auth');
        //  $this->middleware('permission:dashboard-list|dashboard-create|dashboard-edit|dashboard-delete', ['only' => ['index','store']]);
        //  $this->middleware('permission:dashboard-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:dashboard-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:dashboard-delete', ['only' => ['destroy']]);
        // $this->middleware('permission:dashboard', ['only' => ['index']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orders = Order::with(['items', 'payments'])->get();
        $customers_count = Customer::count();
        $products_count = Product::count();

        return view('home', [
            'orders_count' => $orders->count(),
            'income' => $orders->map(function($i) {
                if($i->receivedAmount() > $i->total()) {
                    return $i->total();
                }
                return $i->receivedAmount();
            })->sum(),
            'income_today' => $orders->where('created_at', '>=', date('Y-m-d').' 00:00:00')
            ->map(function($i) {
                if($i->receivedAmount() > $i->total()) {
                    return $i->total();
                }
                return $i->receivedAmount();
            })->sum(),
            'customers_count' => $customers_count,
            'products_count' => $products_count

            
        ]);
    }
}
