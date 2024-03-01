@extends('layouts.admin')

@section('title', 'Drinks Display')
@section('content-header', 'Drinks Display')
@section('content-actions')
    <!-- <a href="{{route('cart.index')}}" class="btn btn-success">Open POS</a> -->
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8" id="kitchen-orders">
            @if(count($kitchenOrders) > 0)
                
            @else
                <p class='no_orders'>No pending orders at the moment.</p>
            @endif
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Include SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- for the broadcast -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/laravel-echo.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pusher-js/dist/web/pusher.min.js"></script> -->


    <!-- Add this within your HTML body section -->
<script>

    // Create a muted audio element
    const audio = new Audio('{{ asset('sound/short_notification.mp3') }}');
    audio.muted = true;
    document.body.appendChild(audio);

    function updateOrderStatus(orderId, isDone) {

    if(!isDone){
    // Display a SweetAlert confirmation dialog
    Swal.fire({
        title: 'Cancel Order',
        input: 'text',
        inputPlaceholder: 'Reason for cancellation',
        showCancelButton: true,
        confirmButtonText: 'Confirm',
        cancelButtonText: 'Cancel',
        showLoaderOnConfirm: true,
        preConfirm: (reason) => {
            if (!reason) {
                Swal.showValidationMessage('Reason is required');
            } else {
                // User confirmed cancellation with reason
                return axios.patch(`/admin/kitchen/${orderId}`, {
                    is_done: isDone,
                    reason: reason
                })
                .then(response => {
                    // Order cancellation successful
                    console.log(response.data.message);
                    var orderElement = document.getElementById('order-' + orderId);
                    orderElement.remove();

                    Swal.fire(
                        response.data.message,
                        'warning'
                    );
                    return response.data;
                })
                .catch(error => {
                    // Error updating order status
                    console.error('Error updating order status:', error);
                    Swal.showValidationMessage('Failed to cancel order');
                });
            }
        }
    })
    .then(result => {
        if (result.isConfirmed) {
            // Order cancellation confirmed
            Swal.fire(
                'Cancelled!',
                'Order has been cancelled.',
                'warning'
            );
        }
    });

    }else if(isDone) {
        axios.patch(`/admin/kitchen/${orderId}`, { is_done: isDone })
            .then(response => {
                console.log(response.data.message);
                // If successful, you might want to remove the order from the view
                var orderElement = document.getElementById('order-' + orderId);
                orderElement.remove();
                Swal.fire(
                    'Ready!',
                    'Order has been completed.',
                    'success'
                );
            })
            .catch(error => {
                console.error('Error updating order status:', error);
            });
    }
}

    function getLastDisplayedOrderId() {
        const orderElements = document.querySelectorAll('[id^="order-"]');
        
        // Check if there are any orders on the page
        if (orderElements.length > 0) {
            const lastOrderElement = orderElements[0];
            const lastOrderId = lastOrderElement.id.split('-')[1]; // Extract order ID
            return parseInt(lastOrderId);
        }

        return null; // No orders on the page
    }

    // Define a set to store the IDs of orders that have been displayed
    const displayedOrderIds = new Set();

   // Function to check for new orders
function checkForNewOrders() {
    const lastDisplayedOrderId = getLastDisplayedOrderId();
    console.log('Last Displayed Order ID:', lastDisplayedOrderId);
    
    axios.get('/admin/get-pending-orders?lastDisplayedOrderId=' + lastDisplayedOrderId + '&_=' + Date.now(), {
        headers: {
            'Authorization': 'Bearer ' + window.Laravel.csrfToken, // Add your CSRF token here
        },
    })
    .then(response => {        
        console.log('Orders Received:', response.data);
        const pendingOrders = response.data;

        // Filter out only the new orders that haven't been displayed yet and sort them by ID in descending order
        const newOrders = pendingOrders
            .filter(order => !displayedOrderIds.has(order.id))
            .sort((a, b) => a.id - b.id);

            console.log('Sorted: ', newOrders);

        // Check if there are new pending orders
        if (newOrders.length > 0) {
            // Filter out items with category name "Drinks" for the new orders
            const filteredOrders = newOrders.map(order => ({
                ...order,
                items: order.items.filter(item => {
                    const category = item.product.product_category;
                    return (category && category.parent && category.parent.name === 'Drinks');
                })
            })).filter(order => order.items.length > 0);

            // Update the kitchen display with the filtered new orders
            // Check if there are new pending orders
            if (filteredOrders.length > 0) {
                // console.log('otherCat: ', otherCategory);
                updateKitchenDisplay(filteredOrders, newOrders);
            }
        }
    })
    .catch(error => {
        console.error('Error checking for new orders:', error);
    });
}

    // Check for new orders every 5 seconds (adjust the interval as needed)
    setInterval(checkForNewOrders, 5000);

    checkForNewOrders();

    setInterval(function() {
        location.reload();
    }, 60 * 60 * 1000); // 60 minutes in milliseconds

    function hasOtherCategory(orderId, newOrders) {
        for (const order of newOrders) {
            if (order.id === orderId) {
                for (const item of order.items) {
                    const category = item.product.product_category;
                    if (!category || !category.parent || category.parent.name !== 'Drinks') {
                        return true; // Return false if any item doesn't have a drinks category or is null
                    }
                }
                return false; // Return true if all items have a drinks category
            }
        }
        return false; // Return false if the order with the provided orderId is not found
    }


    // Function to play sound
    function playAlertSound() {
        audio.play().then(() => {
            // Once the audio has played, unmute it for subsequent plays
            audio.muted = false;
        });
    }

    let display = 'auto; opacity: 1;';

    function updateKitchenDisplay(orders, newOrders) {

        console.log("UpdateKitchenDisplay UI");
        // Update your UI to display the new order
        for (const order of orders) {
            if (hasOtherCategory(order.id, newOrders)){
                display = 'none; opacity: 0.5;';
                console.log('Display: ', display);
            }else{
                display = 'auto; opacity: 1;';
            }
            const commentForCookHtml = (order.commentForCook !== null && order.commentForCook !== "") ? `<strong>Note: ${order.commentForCook}</strong>` : "";
            var created_at = new Date(order.created_at);
            // Formatting time in 12-hour format with AM/PM
            var time = created_at.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });

            // Formatting date to get the day name (e.g., Mon, Tue, etc.)
            var date = created_at.toLocaleDateString('en-US', { weekday: 'short' });

            const newOrderHtml = `
                <div class="card mb-3" id="order-${order.id}">
                    <div class="card-header">
                        <h5 class="card-title">Order ID: ${order.id} <span class="badge badge-warning"> ${date}, ${time}  </span></h5>
                    </div>
                    <div class="card-body">
                        ${order.items.map((item) => `
                            <h6>
                                <ul>
                                    <strong>${item.quantity}x</strong> ${item.product.name} -${parseInt(item.price)}
                                </ul>
                            </h6>
                        `).join('')}
                        <p>Total Products: ${order.items.length}</p>
                        ${commentForCookHtml}
                    </div>
                    <div class="card-footer">
                        <tr>
                            <td>
                        <button class="btn btn-danger mr-5 md-3" style="min-width: 100px; pointer-events:${display};" onclick="updateOrderStatus(${order.id }, 0)">Cancel</button>
                            </td>
                            <td><span width="900px;"></span></td>
                            <td>
                        <button class="btn btn-success ml-5" style="min-width: 100px; pointer-events:${display};" onclick="updateOrderStatus(${order.id}, 1)">Ready</button>
                            </td>
                        </tr>
                    </div>
                </div>
            `;

            // Append the new order to the existing list
            document.getElementById('kitchen-orders').insertAdjacentHTML('afterbegin', newOrderHtml);
            
            // Add the order ID to the set of displayed order IDs
            displayedOrderIds.add(order.id);

            // Play an alert sound
            playAlertSound();

        }
    }

</script>

@endsection
