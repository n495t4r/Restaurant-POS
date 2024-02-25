<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    public function index()
    {
        $categories = ExpenseCategory::all(); // Fetch all expense categories from the database
     
        return view('expenses.index')->with('categories', $categories);
    }

    public function getExpenses(Request $request)
    {
        $query = Expense::query();

        // Apply filters based on request parameters
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'today':
                    $query->whereDate('date', Carbon::today());
                    break;
                case 'yesterday':
                    $query->whereDate('date', Carbon::yesterday());
                    break;
                case 'last_7_days':
                    $query->whereBetween('date', [Carbon::now()->subDays(6), Carbon::now()]);
                    break;
                case 'this_month':
                    $query->whereMonth('date', Carbon::now()->month);
                    break;
                case 'this_year':
                    $query->whereYear('date', Carbon::now()->year);
                    break;
                case 'custom_range':
                    if ($request->has('start_date') && $request->has('end_date')) {
                        $query->whereBetween('date', [$request->start_date, $request->end_date]);
                    }
                    break;
                default:
                    // If an invalid filter value is provided, return a meaningful error response
                    return response()->json(['error' => 'Invalid filter value'], 400);
                }
        }
        
        // Eager load the related category information
        $query->with('category');
        // Order expenses in descending order by their ID
        $query->latest();

        $expenses = $query->get();

        // Calculate total expense amount
        $totalExpense = number_format($expenses->sum('amount'),2);

        return response()->json([
            'expenses' => $expenses,
            'totalExpense' => $totalExpense,
        ]);
    }

    public function store(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'amount' => 'required|numeric',
                'date' => 'required|date',
                'description' => 'nullable|string',
                'category_id' => 'required|exists:expense_categories,id', // Ensure the category exists in the database
            ]);

           // Create new expense
        $expense = Expense::create($validatedData);

        return response()->json(['message' => 'Expense created successfully', 'expense' => $expense, 'cat_id' => $request->category_id], 201);
        } catch (\Exception $e) {
             // Retrieve the SQL error message and error code
            $errorMessage = $e->getMessage();
            $errorCode = $e->getCode();

            // Return a JSON response with the error message and error code
            return response()->json([
                'error' => 'Failed to create expense',
                'sql_error_message' => $errorMessage,
                'sql_error_code' => $errorCode
            ]);
        }
    }

}
