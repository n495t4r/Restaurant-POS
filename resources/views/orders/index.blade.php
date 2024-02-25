@extends('layouts.admin')

@section('title', 'Orders List')
@section('content-header', 'Order List')
@section('content-actions')
    <a href="{{route('cart.index')}}" class="btn btn-success">Open POS</a>
@endsection

@section('content')
<div class="card"><!-- Log on to codeastro.com for more projects -->
    <div class="card-body">
        <div class="row">
            <!-- <div class="col-md-3"></div> -->
            <div class="col-md-12">
                
                <div class="row mb-3">
                    <div class="col-md-2">
                        <label for="filter">Filter:</label>
                        <select id="filter" class="form-control">
                            <option value="">Select filter</option>
                            <option value="today">Today's Order</option>
                            <option value="yesterday">Yesterday's Order</option>
                            <option value="last_7_days">Last 7 days' Order</option>
                            <option value="this_month">This Month's Order</option>
                            <option value="this_year">This Year's Order</option>
                            <option value="custom_range">Custom Range</option>
                        </select>
                    </div>
                    <div class="col-md-2" id="startDateDiv" style="display: none;">
                        <label for="start_date">Start Date:</label>
                        <input type="date" id="start_date" class="form-control">
                    </div>
                    <div class="col-md-2" id="endDateDiv" style="display: none;">
                        <label for="end_date">End Date:</label>
                        <input type="date" id="end_date" class="form-control">
                    </div>
        
                        
                    <div class="col-mr-3">
                        <label for="status">Status:</label>
                        <div>
                            <input type="checkbox" id="processed" name="status[]" value="processed" {{ in_array('processed', (array) request('status')) ? 'checked' : '' }}>
                            <label for="processed">Completed</label>
                        </div>
                        <div>
                            <input type="checkbox" id="pending" name="status[]" value="pending" {{ in_array('pending', (array) request('status')) ? 'checked' : '' }}>
                            <label for="pending">In Kitchen</label>
                        </div>
                        <div>
                            <input type="checkbox" id="failed" name="status[]" value="failed" {{ in_array('failed', (array) request('status')) ? 'checked' : '' }}>
                            <label for="failed">Failed</label>
                        </div>
                    </div>

                    <div class="col-ml-2" style="margin-left: 35px;">
                        <label for="payment">Payment:</label>
                        <div>
                            <input type="checkbox" id="POS" name="payment[]" value="POS" {{ in_array('POS', (array) request('payment')) ? 'checked' : '' }}>
                            <label for="POS">POS</label>
                        </div>
                        <div>
                            <input type="checkbox" id="Cash" name="payment[]" value="Cash" {{ in_array('Cash', (array) request('payment')) ? 'checked' : '' }}>
                            <label for="Cash">Cash</label>
                        </div>
                        <div>
                            <input type="checkbox" id="Transfer" name="payment[]" value="Transfer" {{ in_array('Transfer', (array) request('payment')) ? 'checked' : '' }}>
                            <label for="Transfer">Transfer</label>
                        </div>
                    </div>
                    
                    <div class="col-md-2" style="margin-left: 35px;">
                        <label for="remove_cng">
                            Remove ChowDeck and Glovo:
                        </label>
                        <input type="checkbox" name="selectedCustomers" id="selectedCustomers" value="remove_cng" {{ request('selectedCustomers') ? 'checked' : '' }} />
                    </div>
                    <div class="col-md-2">
                        <button id="applyFilter" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                        <button class="btn btn-secondary" type="button" id="clearSelectionButton"><i class="fas fa-times"></i> Clear Selection</button>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div id="orderHeaderRow"></div>
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <!-- <th>Received</th> -->
                    <!-- <th>Status</th> -->
                    <th>Status</th>
                    <th>Payment Method</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="orderTableBody">
            
            </tbody>
            <tfoot><!-- Log on to codeastro.com for more projects -->
                <tr id="totalOrderRow">
                    <th></th>
                    <th></th>
                    <th id="total"></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        {{ $orders->render() }}
    </div>
</div><!-- Log on to codeastro.com for more projects -->

<!-- Add these scripts to your view -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {

        resetFilterFieldsAndDateInput();
        fetchOrders();


        // Click event for order rows (delegated to the document)
        $(document).on('click', '.order-row', function() {
            var orderId = $(this).data('order-id');
            $('.order-row').not(this).removeClass('active');
            $(this).toggleClass('active');
            $('.collapse').collapse('hide');
            $('#order-details-' + orderId).collapse('toggle');
            resetEditMode();
        });

        // Click event for clear selection button (delegated to the document)
        $(document).on('click', '#clearSelectionButton', function() {
            $('input[type="checkbox"]').prop('checked', false);
            $('input[type="date"]').val('');
        });

        // Click event for edit button (delegated to the document)
        $(document).on('click', '.edit-btn', function(e) {
            resetEditMode();
            e.stopPropagation();
            var $row = $(this).closest('.order-row');
            $row.addClass('edit-mode');
            $row.find('.edit-btn').hide();
            $row.find('.cancel-btn').show();
            $row.find('.save-btn').show();

            // Find the current customer name and value
            var currentCustomerName = $row.find('.current-customer').text();
            var currentCustomerId = $row.find('.customer-dropdown option').filter(function () {
                return $(this).text() === currentCustomerName;
            }).val();

            $row.find('.current-customer').hide();
            $row.find('.customer-dropdown').show().val(currentCustomerId);
            $row.find('.current-payment-method').hide();
            $row.find('.payment-method-dropdown').show().val($row.find('.current-payment-method').text().split(','));
        });

        // Click event for cancel button (delegated to the document)
        $(document).on('click', '.cancel-btn', function(e) {
            e.stopPropagation();
            resetEditMode();
        });


         // Click event for save button (delegated to the document)
        $(document).on('click', '.save-btn', function(e) {
            e.stopPropagation();
            var $row = $(this).closest('.order-row');
            var orderId = $row.data('order-id');
            var customerId = $row.find('.customer-dropdown').val();
            var paymentMethod = [].concat($row.find('.payment-method-dropdown').val());
            var csrfToken = window.Laravel.csrfToken;
            $.ajax({
                url: '/admin/kitchen/' + orderId,
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    customer_id: customerId,
                    payment_method: paymentMethod
                },
                success: function(response) {
                    console.log(response);
                    $row.removeClass('edit-mode');
                    $row.find('.edit-btn').show();
                    $row.find('.save-btn').hide();
                    $row.find('.cancel-btn').hide();
                    $row.find('.customer-dropdown').hide();
                    $row.find('.current-customer').show().text(response.customer_name);
                    $row.find('.payment-method-dropdown').hide();
                    $row.find('.current-payment-method').show().text(response.payment_method);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });

        // Click event to prevent propagation from dropdowns (delegated to the document)
        $(document).on('click', '.customer-dropdown, .payment-method-dropdown', function(e) {
            e.stopPropagation();
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

        function resetEditMode() {
            // var $row = $(this).closest('.order-row');
            $('.edit-btn').not(this).show();
            $('.save-btn').not(this).hide();
            $('.cancel-btn').not(this).hide();
            $('.customer-dropdown').not(this).hide();
            $('.current-customer').not(this).show();
            $('.payment-method-dropdown').not(this).hide();
            $('.current-payment-method').not(this).show();
        }


        // Event listener for Apply Filter button click
        document.getElementById('applyFilter').addEventListener('click', function() {
            fetchOrders();
        });
    
        // Function to fetch orders based on filter
        function fetchOrders() {
            var filter = document.getElementById('filter').value;
            var startDate = document.getElementById('start_date').value;
            var endDate = document.getElementById('end_date').value;
            
            var requestData = {
                _token: '{{ csrf_token() }}'
            };

            // Only include start_date and end_date if the filter is "custom_range"
            if (filter !== '') {
                requestData.filter = filter;
                if(filter === 'custom_range'){
                    requestData.start_date = startDate;
                    requestData.end_date = endDate;
                }
            }

            var selectedCustomers = [];
            var paymentFilters = [];
            var statusFilters = [];

            // Collect selected customer IDs
            if ($('#selectedCustomers').is(':checked')) {
                requestData.selectedCustomers = selectedCustomers.push('remove_cng');
            }

            // Collect status filter values
            $('input[name="status[]"]:checked').each(function() {
                statusFilters.push($(this).val());
            });

            // Collect status filter values
            $('input[name="payment[]"]:checked').each(function() {
                paymentFilters.push($(this).val());
            });
            
                requestData.status = statusFilters;
                requestData.payment = paymentFilters;
            // AJAX request to fetch expenses data
            $.ajax({
                url: '{{ route("orders.filter") }}',
                type: 'GET',
                data: requestData,
                success: function(response) {
                    console.log(response.orders.data );
                    // Update table rows with fetched expenses
                    // response.data.orders;
                    if(filter === 'custom_range'){
                        filter = 'between ' + startDate +' & '+ endDate;
                    }else {
                        filter = 'for '+filter;   
                    }
                    var headerRow = document.getElementById('orderHeaderRow');
                    headerRow.innerHTML = '<span style="font-style: italic;">Showing Orders '+filter+'</span>';

                    var totalOrderRow = document.getElementById('totalOrderRow');
                    
                    if(response.orders.data.length > 0) {
                        generateOrderRows(response.orders.data, response.customers);
                        var msg = 'Total income '+filter;
                        // Update total expense amount
                        totalOrderRow.innerHTML 
                        = '<td colspan=7 style="font-size: 14px; font-style: italic;">' + msg +': '+ "<strong>{{ config('settings.currency_symbol') }}" + formatAmount(response.total) + '</strong></td>';
                    }else{
                        generateOrderRows(response.orders.data, response.customers);
                        totalOrderRow.innerHTML = '<td colspan=7 style="font-size: 18px; font-style: italic;"> No order(s) '+ filter + '</td>'; // Clear existing rows 
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        //generates the HTML dynamically for the orders table
        function generateOrderRows(orders, customers) {
            var html = '';
            var paymentMethods = ['POS', 'Transfer', 'Cash'];
            var orderTableBody = document.getElementById('orderTableBody');
                orderTableBody.innerHTML = ''; // Clear existing rows

            orders.forEach(function(order) {
                html += '<tr class="order-row" data-order-id="' + order.id + '">';
                html += '<td>' + order.id + '</td>';
                html += '<td>';
                if(order.customer_id){
                    html += '<span class="current-customer">' + order.customer.first_name +' '+ order.customer.last_name+ '</span>';
                }else{
                    html += '<span class="current-customer">' + 'null' + '</span>';
                }
                html += '<select class="form-control customer-dropdown" style="display: none;">';
                customers.forEach(function(customer) {
                    html += '<option value="' + customer.id + '">' + customer.name + '</option>';
                });
                html += '</select>';
                html += '</td>';
                
                html += '<td>' + "{{ config('settings.currency_symbol') }} " + formatAmount(order.payments[0].amount) + '</td>';
            
                html += '<td>';
                if (order.status == "failed") {
                    html += '<span class="badge badge-danger">Canceled</span>';
                } else if (order.status == "pending") {
                    html += '<span class="badge badge-warning">In-Kitchen</span>';
                } else if (order.status == "processed") {
                    html += '<span class="badge badge-success">Completed</span>';
                }
                html += '</td>';
                html += '<td>';
                var paymentMethodsArray = JSON.parse(order.payments[0].payment_methods);
                if(paymentMethodsArray){
                    html += '<span class="current-payment-method">' + paymentMethodsArray.join(', ') + '</span>';
                }else{
                    html += '<span class="current-payment-method">' + 'null' + '</span>';
                }
                html += '<select class="form-control payment-method-dropdown" multiple style="display: none;">';
                paymentMethods.forEach(function(paymentMethod) {
                    html += '<option value="' + paymentMethod + '">' + paymentMethod + '</option>';
                });
                html += '</select>';
                html += '</td>';
                html += '<td>' + formatDate(order.created_at) + '</td>';
                html += '<td>';
                html += '<button class="btn btn-primary btn-sm edit-btn">Edit</button>';
                html += '<button class="btn btn-danger btn-sm cancel-btn fas fa-times" style="display: none;"></button>';
                html += '<button class="btn btn-success btn-sm save-btn" style="display: none;">Save</button>';
                html += '</td>';
                html += '</tr>';
                html += '<tr id="order-details-' + order.id + '" class="collapse">';
                html += '<td colspan="2">';
                html += '<ul>';
                order.items.forEach(function(item) {
                    html += '<li><strong>' + item.quantity + 'x</strong> ' + item.product.name + ' - ' + formatAmount(item.price) + '</li>';
                });
                html += '</ul>';
                html += '<p>Total Products: ' + order.items.length + '</p>';
                html += '<button id="print-cart-btn" data-order-id='+ order.id + ' class="btn btn-warning mb-2 fas fa-print"></button>';
                html += '</td>';
                if (order.commentForCook) {
                    html += '<td colspan="3" style="width: 200px; overflow-wrap: break-word;">';
                    html += 'Note: <strong>' + order.commentForCook + '</strong>';
                    html += '</td>';
                }
                if (order.reason) {
                    html += '<td colspan="2"> Reason for cancelation: <strong>' + order.reason + '</strong></td>';
                }
                html += '</tr>';
                orderTableBody.innerHTML = html;
            });

            // return html;
        }

         // Event listener for the "Print Cart" button
        //  $(document).on('click', '.save-btn', function(e) {
        $(document).on('click', '#print-cart-btn', function(e) {
                
                // var $row = $(this).closest('.order-row');
                // var orderId = $row.attr('data-order-id');
                var orderId = $(this).data('order-id');
                // alert('Clicked- '+ orderId);

                var csrfToken = window.Laravel.csrfToken;

                $.ajax({
                    url: '/admin/print',
                    type: 'POST',
                    headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                    data: {
                        page:'orders',
                        orderId: orderId
                    },
                    success: function(response) {
                        // Open a new window with reduced size
                        let printWindow = window.open('', '_blank', 'width=600,height=400');

                        // Write the content to the new window
                        printWindow.document.open();
                        printWindow.document.write(response.html);
                        printWindow.document.close();

                        // Print the content
                        printWindow.print();

                        // Close the window after printing
                        // setTimeout(function() {
                        //     printWindow.close();
                        // }, 3000); // Adjust the delay as needed

                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

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

            var formattedTime = expenseDate.toLocaleTimeString('en-US', {hour: 'numeric', minute: '2-digit', hour12: true});
            formattedTime = ' <span class="badge badge-info">'+ formattedTime +'</span>'
            // Construct the formatted date string
            var formattedDate = dayOfWeek + ', ' + dayOfMonth + ' ' + monthName + ' ' + year + formattedTime;

            return formattedDate;

        }

        //format amount
        function formatAmount(amount){
            // Convert the amount to a number
            var amount = parseFloat(amount);

            // Format the number with commas as the thousands separator
            return formattedAmount = amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        }

    });

    

</script>

<!-- Add this style to your view -->
<style>
    .order-row.active {
        background-color: #f8f9fa;
    }

    .collapse {
        background-color: #f8f9fa;
    }
</style>

@endsection

