@extends('layouts.admin')

@section('title', 'Expense')
@section('content-header', 'Expense')
@section('content-actions')
    <button id="createExpenseBtn" class="btn btn-primary" onclick="showCreateExpenseModal()">Add Expense</button>
@endsection
@section('content')
<div class="container">
    
    <!-- Expense table, filters, and total amount section -->
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="filter">Filter:</label>
            <select id="filter" class="form-control">
                <option value="today">Today's Expense</option>
                <option value="yesterday">Yesterday's Expense</option>
                <option value="last_7_days">Last 7 days' Expense</option>
                <option value="this_month">This Month's Expense</option>
                <option value="custom_range">Custom Range</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" class="form-control">
        </div>
        <div class="col-md-3">
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" class="form-control">
        </div>
        <div class="col-md-3">
            <button id="applyFilter" class="btn btn-primary">Apply Filter</button>
        </div>
    </div>
    <!-- Expense table -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Title</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody id="expenseTableBody">
                <!-- Populate table rows dynamically -->
            </tbody>
        </table>
    </div>
    <!-- Total Expense Amount -->
    <div>
        <h3>Total Expense: <span id="totalExpense"></span></h3>
    </div>


    <!-- Modal for creating new expense -->
    <div class="modal fade" id="createExpenseModal" tabindex="-1" role="dialog" aria-labelledby="createExpenseModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createExpenseModalLabel">Add New Expense</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="createExpenseForm">
                    <div class="modal-body">
                        <!-- Form fields for expense category, title, amount, date, description -->
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select class="form-control" id="category_id" name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="createExpense()">Save Expense</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add this in your layout file, before the closing </body> tag -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->

<script>
    // Add your JavaScript code here
    document.addEventListener('DOMContentLoaded', function() {
        // Function to fetch expenses based on filter
        function fetchExpenses() {
            var filter = document.getElementById('filter').value;
            var startDate = document.getElementById('start_date').value;
            var endDate = document.getElementById('end_date').value;

            // AJAX request to fetch expenses data
            $.ajax({
                url: '{{ route("expenses.get") }}',
                type: 'GET',
                data: {
                    filter: filter,
                    start_date: startDate,
                    end_date: endDate,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Update table rows with fetched expenses
                    var expenseTableBody = document.getElementById('expenseTableBody');
                    expenseTableBody.innerHTML = ''; // Clear existing rows

                    response.expenses.forEach(function(expense) {
                        var row = '<tr>';
                        row += '<td>' + expense.category + '</td>';
                        row += '<td>' + expense.title + '</td>';
                        row += '<td>' + expense.amount + '</td>';
                        row += '<td>' + expense.date + '</td>';
                        // Add more columns as needed
                        row += '</tr>';
                        expenseTableBody.innerHTML += row;
                    });

                    // Update total expense amount
                    document.getElementById('totalExpense').innerText = response.totalExpense;
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        // Event listener for Apply Filter button click
        document.getElementById('applyFilter').addEventListener('click', function() {
            fetchExpenses();
        });

        // Fetch expenses on page load
        fetchExpenses();
    });


    function showCreateExpenseModal() {
        alert('add expense modal');
        $('#createExpenseModal').modal('show');
    }

    function createExpense() {
        var formData = $('#createExpenseForm').serialize();

        // AJAX request to submit form data and create new expense
        $.ajax({
            url: '{{ route("expenses.store") }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                // Close the modal after successful creation
                $('#createExpenseModal').modal('hide');
                // Refresh the expenses table or update UI as needed
                // For example, fetchExpenses() function can be called here to refresh the table
            },
            error: function(xhr, status, error) {
                console.error(error);
                // Handle errors or display error messages
            }
        });
    }
</script>
@endsection
