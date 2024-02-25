@extends('layouts.admin')

@section('title', 'Expense')
@section('content-header','Expenses')
@section('content-actions')
<!-- Total Expense Amount -->
    <button id="createExpenseBtn" class="btn btn-primary">Add Expense</button>

@endsection
@section('content')
<div class="container">
    
    <!-- Expense table, filters, and total amount section -->
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="filter">Filter:</label>
            <select id="filter" class="form-control">
                <option value="">Select filter</option>
                <option value="today">Today's Expense</option>
                <option value="yesterday">Yesterday's Expense</option>
                <option value="last_7_days">Last 7 days' Expense</option>
                <option value="this_month">This Month's Expense</option>
                <option value="this_year">This Year's Expense</option>
                <option value="custom_range">Custom Range</option>
            </select>
        </div>
        <div class="col-md-3" id="startDateDiv" style="display: none;">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" class="form-control">
        </div>
        <div class="col-md-3" id="endDateDiv" style="display: none;">
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" class="form-control">
        </div>
        <div class="col-md-3">
            <button id="applyFilter" class="btn btn-primary">Apply Filter</button>
        </div>
    </div>

    <!-- Expense table -->
    <div id="orderHeaderRow" style="font-style: italic;"></div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="expense-table">
            <thead class="thead-dark">
                <tr>
                <th>Category</th>
                    <th>Title</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Actions</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody id="expenseTableBody">
                <!-- Populate table rows dynamically -->
                
            </tbody>

        </table>
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
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="date" class="form-control" id="date" name="date" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Expense</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add this in your layout file, before the closing </body> tag -->

<script>
    // Add your JavaScript code here
    document.addEventListener('DOMContentLoaded', function() {

       // Function to reset filter fields and date input in the modal form
        function resetFilterFieldsAndDateInput() {
            // Set default value for filter select
            document.getElementById('filter').value = 'today';

            // Set default value for start date input
            document.getElementById('start_date').value = '';

            // Set maximum value for end date input to today's date
            var today = new Date().toISOString().split('T')[0];
            document.getElementById('start_date').setAttribute('max', today);
            document.getElementById('end_date').setAttribute('max', today);

            // Set default value for end date input to today's date
            document.getElementById('end_date').value = today;

            // Set maximum value for date input in modal form to today's date
            var modalDateInput = document.getElementById('date');
            modalDateInput.setAttribute('max', today);

            // Set default value for date input in modal form to today's date
            modalDateInput.value = today;

            // Optionally, trigger the click event on the Apply Filter button to reapply the filter
            document.getElementById('applyFilter').click();
        }


        //Format date
        function formatDate(exp_date){
            // Parse the date string into a Date object
            var expenseDate = new Date(exp_date);

            // Array of month names
            var months = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"];

            // Get the day of the week (e.g., Fri)
            var dayOfWeek = expenseDate.toLocaleDateString('en-US', { weekday: 'short' });
            
            // Get the day of the month (e.g., 20)
            var dayOfMonth = expenseDate.getDate();
            
            // Get the month name (e.g., October)
            var monthName = months[expenseDate.getMonth()];

            // Get the year (e.g., 2024)
            var year = expenseDate.getFullYear();

            // Construct the formatted date string
            var formattedDate = dayOfWeek + ', ' + dayOfMonth + ' ' + monthName + ' ' + year;

            return formattedDate;

        }

        //format amount
        function formatAmount(amount){
            // Convert the amount to a number
            var amount = parseFloat(amount);

            // Format the number with commas as the thousands separator
            return formattedAmount = amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        }
        
        // Function to fetch expenses based on filter
        function fetchExpenses() {
            var filter = document.getElementById('filter').value;
            var startDate = document.getElementById('start_date').value;
            var endDate = document.getElementById('end_date').value;
            
            var requestData = {
                _token: '{{ csrf_token() }}'
            };

            // Only include start_date and end_date if the filter is "custom_range"
            if (filter !== '') {
                requestData.filter = filter;
                if (filter === 'custom_range'){
                    requestData.start_date = startDate;
                    requestData.end_date = endDate;
                }
            }

            // AJAX request to fetch expenses data
            $.ajax({
                url: '{{ route("expenses.get") }}',
                type: 'GET',
                data: requestData,
                success: function(response) {
                    console.log(response);

                    if(filter === 'custom_range'){
                        filter = 'between ' + startDate +' & '+ endDate;
                    }else {
                        filter = 'for '+filter;   
                    }
                    var totalExpense = "{{ config('settings.currency_symbol') }} " + response.totalExpense
                    var headerRow = document.getElementById('orderHeaderRow');
                    headerRow.innerHTML = '<span style="font-style: italic;">Showing Expenses '+filter+': <strong>'+ totalExpense +'</strong></span>';

                    var totalOrderRow = document.getElementById('totalOrderRow');
                    //call update expense table function
                    updateExpenseTable(response.expenses);

                    // Update total expense amount
                    // document.getElementById('totalExpense').innerText = "{{ config('settings.currency_symbol') }} " + response.totalExpense;
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
        
        resetFilterFieldsAndDateInput();
        fetchExpenses();
    // });

    function updateExpenseTable(expenses){
        // Update table rows with fetched expenses
        var expenseTableBody = document.getElementById('expenseTableBody');
        expenseTableBody.innerHTML = ''; // Clear existing rows

        expenses.forEach(function(expense) {
            var row = '<tr>';
            row += '<td>' + expense.category.name + '</td>';
            row += '<td>' + expense.title + '</td>';
            row += '<td>'+ "{{ config('settings.currency_symbol') }} " + formatAmount(expense.amount) + '</td>';
            row += '<td>' + formatDate(expense.date) + '</td>';                        // Add more columns as needed
            row += '</tr>';
            expenseTableBody.innerHTML += row;
        });
    }

    // JavaScript code for handling modal and form submission
    // document.addEventListener('DOMContentLoaded', function() {
        // Show modal when create expense button is clicked
        document.getElementById('createExpenseBtn').addEventListener('click', function() {
            $('#createExpenseModal').modal('show');
        });

       

        // Handle form submission for creating new expense
        document.getElementById('createExpenseForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            var formData = new FormData(this);

              // Include the CSRF token in the request headers
            $.ajaxSetup({
                headers: {
                    // 'X-CSRF-TOKEN': csrfToken,
                    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                }
            });

            // AJAX request to submit form data and create new expense
            $.ajax({
                url: '{{ route("expenses.store") }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Close the modal after successful creation
                    $('#createExpenseModal').modal('hide');
                    // console.log(response);
                    //clear form fields
                    var form = document.getElementById('createExpenseForm');
                    // Reset the form
                    form.reset();

                    // Refresh the expenses table or update UI as needed
                    resetFilterFieldsAndDateInput();
                    fetchExpenses();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    // Handle errors or display error messages
                }
            });
        });
    });

    // Show or hide the start and end date fields based on the selected filter
    document.getElementById('filter').addEventListener('change', function() {
        var filter = this.value;
        var startDateDiv = document.getElementById('startDateDiv');
        var endDateDiv = document.getElementById('endDateDiv');

        // Show or hide the start and end date fields based on the selected filter
        if (filter === 'custom_range') {
            

            startDateDiv.style.display = 'block';
            endDateDiv.style.display = 'block';
        } else {
            startDateDiv.style.display = 'none';
            endDateDiv.style.display = 'none';
        }
    });

    

</script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

@endsection
