    $(document).ready(function() {
        // Existing code...

        let packNumber = 1; // Initialize pack number

        $('#pack-cart-btn').on('click', function() {
            packCart();
        });

        $('#submit-order-btn').on('click', function() {
            submitOrder();
        });

        function packCart() {
            let cartItems = [];
            $('#cart-items tr').each(function() {
                let productId = $(this).find('.delete-item-btn').data('product-id');
                let quantity = $(this).find('.cart-quantity').val();
                cartItems.push({ package_number: packNumber, id: productId, quantity: quantity });
            });

            // Add pack number to each item
            cartItems.forEach(function(item) {
                item.packNumber = packNumber;
            });

            // Store packed items in session or localStorage
            let packedItems = JSON.parse(localStorage.getItem('packedItems')) || [];
            packedItems.push(cartItems);
            localStorage.setItem('packedItems', JSON.stringify(packedItems));

            // Remove cart items from view and display packed items
            $('#cart-items').empty();
            displayPackedItems();

            // Increment pack number for the next pack
            packNumber++;
        }

        function submitOrder2() {
            // Retrieve packed items from localStorage
            let packedItems = JSON.parse(localStorage.getItem('packedItems')) || [];

            // Ajax request to submit the order with pack information
            $.ajax({
                url: '/submit-order',
                type: 'POST',
                data: {
                    packedItems: packedItems
                },
                success: function(response) {
                    // Handle success response
                    console.log(response);
                    // Clear localStorage after successful submission
                    localStorage.removeItem('packedItems');
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error(xhr.responseText);
                }
            });
        }

        function displayPackedItems() {
            let packedItems = JSON.parse(localStorage.getItem('packedItems')) || [];
            let packNumber = packedItems.length;

            // Display packed items in UI
            let $packedItemsDiv = $('#packed-items');
            let html = '<div class="packed-group">';

            packedItems.forEach(function(items, index) {
                html += '<div class="pack" data-pack-number="' + (index + 1) + '">';
                html += '<span class="pack-number">Pack ' + (index + 1) + '</span>';
                html += '<ul>';

                items.forEach(function(item) {
                    html += '<li>' + item.quantity + 'x ' + item.product_name + '</li>';
                });

                html += '</ul></div>';
            });

            html += '</div>';
            $packedItemsDiv.html(html);
        }
    });
