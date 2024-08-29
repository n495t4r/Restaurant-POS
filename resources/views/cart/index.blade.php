@extends('layouts.admin')

@section('title', 'PEVA POS')

@section('content')
<div id="cart">
    <div class="row">
        <!-- <div class="col-md-1 col-lg-1">
            <div class="btn-group-vertical" role="group">
                <button id="print-cart-btn" class="btn btn-primary mb-2">Print Cart</button>
                Add more buttons here as needed 
            </div>
        </div> -->

        <div class="col-md-5 col-lg-5">

            <!-- Channel dropdown -->
            <div class="row">
                <div class="col-md-4">
                    <select id="channel-dropdown" class="form-control" required>
                        <option value="">Order Channel</option>
                        @foreach($channels as $channel)
                        <option value="{{ $channel->id }}">{{ $channel->channel }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Customer dropdown -->
            <div class="row">
                <div class="col-md-4">
                    <select id="customer-dropdown" class="form-control">
                        <option value="">Customer</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="user-cart">
                <div class="card mt-0 col-md-15 col-lg-12" style="max-height: 380px; overflow-y: auto;">
                    <table class="table table-striped">
                        <thead style="position: sticky; top: 0; background-color: #ffffff;"> <!-- Set the background color for the thead -->
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th></th>
                                <th class="price-column">Price</th> <!-- Add a class to the Price column -->
                            </tr>
                        </thead>
                        <tbody id="cart-items">
                            <!-- Cart items will be dynamically added here -->
                        </tbody>
                    </table>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6 text-right mb-3">
                        <input type="text" placeholder="Insert a note" id="comment-for-cook" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex justify-content-between">
                            <div class="mr-4">Total:</div>
                            {{ config('settings.currency_symbol') }}<span id="total-amount" class="text-right">0.00</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <!-- <button id="pack-cart-btn" class="btn btn-info mr-3" style="width: 200px;">Pack</button> -->
                        <button id="empty-cart-btn" class="btn btn-danger" style="width: 150px;" disabled>Empty Cart</button>
                    </div>
                    <div class="col-md-4 text-right">
                        <button id="submit-order-btn" class="btn btn-success float-left" style="width: 150px;" disabled>Submit Order</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-md-5 col-lg=5" id="packed-items"> -->
        <!-- Packed items will be displayed here -->
        <!-- </div> -->

        <div class="mainproduct col-sm-10 col-md-5 col-lg-5">
            <div class="search-container">
                <input type="text" id="search-input" style="width: 50%;" placeholder="Search products...">
                <div id="search-results"></div>
            </div>

            <div class="order-product mt-4 row" id="product-list">
                @foreach($products as $product)
                <div class="col-md-3 col-lg-3 mb-2">
                    <div class="card product-card" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-product-price="{{ $product->price }}" data-product-quantity="{{ $product->quantity }}" data-product-status="{{ $product->status }}">
                        <div class="card-body">
                            {{ $product->name }}<br />
                            {{ config('settings.currency_symbol') }}{{ $product->price }} ({{ $product->quantity }})
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!-- Pagination Links -->
            <div class="pagination">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let cart = []; // Array to store cart items

        // Function to add product to cart
        function addToCart(productId, productName, productPrice, productQuantity) {
            // Check if the product quantity is greater than zero
            if (productQuantity > 0) {
                let existingItem = cart.find(item => item.id === productId);
                if (existingItem) {
                    existingItem.quantity++;
                } else {
                    cart.push({
                        id: productId,
                        name: productName,
                        price: productPrice,
                        quantity: 1
                    });
                }

                renderCart();

            } else {
                // alert("Product quantity must be greater than zero.");
                Swal.showValidationMessage('Out of stock' + productQuantity);
            }
        }

        // Function to render cart items
        function renderCart() {
            let cartItems = $('#cart-items');
            cartItems.empty();
            let totalAmount = 0;
            cart.forEach(item => {
                let totalPrice = item.price * item.quantity;
                totalAmount += totalPrice;
                cartItems.append(`<tr>
                        <td style="width: 40%;">${item.name}</td>
                        <td>
                            <div class="col-md-6">
                                <input type="number" min="1" value="${item.quantity}" class="form-control cart-quantity" data-product-id="${item.id}" style="width: 50px;">
                            </div>
                        </td>
                        <td>
                            
                                <button class="btn btn-sm btn-danger delete-item-btn" data-product-id="${item.id}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            
                        </td>
                        <td class="price-column"> <!-- Add a class to the Price column -->
                            {{ config('settings.currency_symbol')}}
                            ${totalPrice.toFixed(2)}
                        </td>
                    </tr>`);
            });
            $('#total-amount').text(totalAmount.toFixed(2));
            updateButtons();
        }

        // Event listener for deleting an item from the cart
        $('#cart-items').on('click', '.delete-item-btn', function() {
            let productId = $(this).data('product-id');
            removeFromCart(productId);
            renderCart();
        });

        // Function to remove an item from the cart
        function removeFromCart(productId) {
            // Find the index of the item in the cart array
            let index = cart.findIndex(item => item.id === productId);
            // If the item is found, remove it from the cart array
            if (index !== -1) {
                cart.splice(index, 1);
            }
        }

        // Function to update button states
        function updateButtons() {
            let emptyCartBtn = $('#empty-cart-btn');
            let submitOrderBtn = $('#submit-order-btn');
            if (cart.length > 0) {
                emptyCartBtn.prop('disabled', false);
                submitOrderBtn.prop('disabled', false);
            } else {
                emptyCartBtn.prop('disabled', true);
                submitOrderBtn.prop('disabled', true);
            }
        }

        // staff order selected
        // $('#channel-dropdown').on('change', function() {
        //     if ($(this).val() == 6) {
        //         // Clear selected customer
        //         $('#customer-dropdown').val('');
        //         $('#customer-dropdown').prop('disabled', true);
        //     } else {
        //         $('#customer-dropdown').prop('disabled', false);
        //     }
        // });

        // empty cart 
        function emptyCart() {
            cart = [];
            // Clear selected customer
            $('#customer-dropdown').val('');
            // Clear selected channel
            $('#channel-dropdown').val('');

            // Uncheck all payment method checkboxes
            // $('input[name="payment-method-id"]:checked').prop('checked', false);

            // Clear comment for cook input
            $('#comment-for-cook').val('');

            renderCart();
        }

        // Event listener for adding products to cart (using event delegation)
        $('.order-product').on('click', '.product-card', function() {
            let productId = $(this).data('product-id');
            let productName = $(this).data('product-name');
            let productPrice = parseFloat($(this).data('product-price'));

            let productQuantity = parseInt($(this).data('product-quantity')); // Retrieve product quantity
            let productStatus = parseInt($(this).data('product-status'));
            // Check if product quantity is valid
            if (productQuantity && productQuantity > 0) {
                if (productStatus == 1) {
                    addToCart(productId, productName, productPrice, productQuantity);
                } else {
                    Swal.fire(
                        'Not Active!',
                        'Product has been disabled',
                        'warning'
                    );
                }
            } else {
                Swal.fire(
                    'Out of Stock!',
                    'Product has ran out. Qty:' + productQuantity,
                    'warning'
                );
            }
        });

        // Event listener for changing cart item quantities
        $('#cart-items').on('change', '.cart-quantity', function() {
            let productId = $(this).data('product-id');
            let newQuantity = parseInt($(this).val());
            let cartItem = cart.find(item => item.id === productId);
            if (cartItem) {
                cartItem.quantity = newQuantity;
                renderCart();
            }
        });

        // Event listener for emptying the cart
        $('#empty-cart-btn').on('click', function() {
            emptyCart();
            // Clear selected customer
            // $('#customer-dropdown').val('');
        });

        // Handle form submission
        $('#submit-order-btn').click(function() {
            let customerId = $('#customer-dropdown').val();
            let channelId = $('#channel-dropdown').val();
            var payment_method_id;
            let commentForCook = $('#comment-for-cook').val();
            let amountText = $('#total-amount').text();
            let amount = parseFloat(amountText);
            let paidText = $('#total-paid').text();
            let paid = parseFloat(paidText);

            if (channelId == 6 && amount > 2000) {
                Swal.fire(
                    'Exceeded!',
                    'Orders should not exceed N2000',
                    'warning'
                );
            } else {
                // Create SweetAlert popup with input for the payment
                Swal.fire({
                    title: 'Confirm payment',
                    html: `
    <div class="col">
        <input type='number' id='swal-input-paid' class='swal2-input' placeholder='${amount}' value='' step='50' min='0' max='${amount}'>
        <div id='payment-method-container' class='payment_method_id'>
            <input type='radio' id='payment-method-cash' name='payment-method-id' value='1'> <label for='payment-method-cash'>Cash</label><br>
            <input type='radio' id='payment-method-pos' name='payment-method-id' value='3'> <label for='payment-method-pos'>POS</label><br>
            <input type='radio' id='payment-method-transfer' name='payment-method-id' value='2'> <label for='payment-method-transfer'>Transfer</label>
        </div>
    </div>`,
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        const amountPaid = $('#swal-input-paid').val();
                        const paymentMethodId = $('input[name="payment-method-id"]:checked').val();

                        if (amountPaid && !paymentMethodId) {
                            Swal.showValidationMessage('Please select the payment method!');
                            return false;
                        } else if (!amountPaid && paymentMethodId) {
                            Swal.showValidationMessage('Enter amount paid by customer!');
                            return false;
                        }

                        if(amountPaid > amount){
                            Swal.showValidationMessage('Overpaid!');
                            return false;
                        }

                        return {
                            paid: amountPaid,
                            payment_method_id: paymentMethodId
                        };
                    },

                }).then((result) => {
                    if (result) {
                        // Proceed with the order submission
                        var csrfToken = window.Laravel.csrfToken;
                        $.ajax({
                            url: '/admin/orders',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            data: {
                                amount: result.value.amount, // Use the amount from the SweetAlert input
                                paid: result.value.paid, // Use the amount from the SweetAlert input
                                customer_id: customerId,
                                channel_id: channelId,
                                payment_method_id: result.value.payment_method_id,
                                commentForCook: commentForCook, // Use the updated comment
                                cart: cart
                            },
                            success: function(response) {
                                console.log(response);
                                emptyCart();
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });

            }
        });

        // Initial rendering of products on page load
        // renderProducts();

        // Event listener for the "Print Cart" button
        $('#print-cart-btn').click(function() {
            let customerId = $('#customer-dropdown').val();
            let channelId = $('#channel-dropdown').val();
            let paymentMethods = [];
            $('input[type=checkbox][id^=payment-method-]').each(function() {
                if ($(this).is(':checked')) {
                    paymentMethods.push($(this).val());
                }
            });
            let commentForCook = $('#comment-for-cook').val();
            let amountText = $('#total-amount').text();
            let amount = parseFloat(amountText);
            let paidText = $('#total-paid').text();
            let paid = parseFloat(paidText);
            var csrfToken = window.Laravel.csrfToken;

            $.ajax({
                url: '/admin/print',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    page: 'cart',
                    customerId: customerId,
                    channelId: channelId,
                    paymentMethods: paymentMethods,
                    commentForCook: commentForCook,
                    amount: amount,
                    paid: paid,
                    cart: cart
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
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

    });

    //for paginate
    $(document).ready(function() {
        $('.pagination a').on('click', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                success: function(data) {
                    $('#product-list').html(data);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });

    //For product search
    $(document).ready(function() {

        $('#search-input').on('input', function() {

            $('.pagination').hide();

            var query = $(this).val();
            if (query.trim() === '') {
                $('#product-list').empty();
                return;
            }
            $.ajax({
                url: '/admin/cart',
                type: 'GET',
                data: {
                    query: query
                },
                success: function(response) {
                    // $('#search-results').html(response);
                    $('#product-list').html(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>
<!-- Include the custom JavaScript file -->
<script src="{{ asset('cart/js/packaging.js') }}"></script>


<style>
    .payment-methods input[type="checkbox"] {
        display: inline-block;
        margin-right: 10px;
        /* Adjust as needed */
    }

    /* Fixed width for product card */
    .product-card {
        transition: transform 0.3s ease;
        height: auto;
        /* Allow height to adjust based on content */
        width: 160px;
        /* Fixed width for product card */
        margin: 5;
        /* Add some margin between product cards */
    }

    /* Adjust number of columns for different screen sizes */
    @media (max-width: 2000px) {
        .col-md-3 {
            /* flex: 0 0 33.33%; Three cards per row for large screens */
            max-width: 33.33%;
        }
    }

    @media (max-width: 1405px) {
        .col-md-3 {
            /* flex: 0 0 50%; Two cards per row for medium-sized screens */
            max-width: 50%;
        }
    }

    @media (max-width: 1200px) {
        .col-md-3 {
            /* flex: 0 0 50%; Three cards per row for large screens */
            max-width: 50%;
        }
    }

    @media (max-width: 992px) {
        .col-md-3 {
            /* flex: 0 0 50%; Two cards per row for medium-sized screens */
            max-width: 50%;
        }
    }

    @media (max-width: 768px) {
        .col-md-3 {
            /* flex: 0 0 100%; One card per row for small screens */
            max-width: 100%;
        }
    }

    /* Define the width for the Price column */
    .price-column {
        width: 150px;
        /* Adjust the width as needed */
    }
</style>

@endsection