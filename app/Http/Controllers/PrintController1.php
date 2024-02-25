<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function printInvoice(Request $request)
    {
        // Retrieve necessary data from the request
        $customerId = $request->input('customerId');
        $paymentMethods = (array) $request->input('paymentMethods'); // Convert to array
        $commentForCook = $request->input('commentForCook');
        $amount = $request->input('amount');
       
        // Retrieve cart data as needed
        // Initialize an empty array to store item details
        $cartData = [];

        // Loop through the cart items and associate them with the order
        foreach ($request->cart as $item) {
            // Calculate the total price for the item
            $totalPrice = $item['price'] * $item['quantity'];
            $product_name = Product::find($item['id'])->name;
            
            // Push an associative array containing item details to the $itemDetails array
            $cartData[] = [
                'price' => $totalPrice,
                'quantity' => $item['quantity'],
                'name' => $product_name
            ];
        }

        $invoiceNo = rand(20, 160);

        // Generate the HTML content for the invoice
        $html = view('invoice_template', [
            'customerId' => $customerId,
            'paymentMethods' => $paymentMethods,
            'commentForCook' => $commentForCook,
            'amount' => $amount,
            'cartData' => $cartData,
            'invoiceNo' => $invoiceNo
            // Pass cart data as needed
        ])->render();

        return response()->json(['html' => $html]);
    }

}
