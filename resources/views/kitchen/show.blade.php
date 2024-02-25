extends('layouts.admin')

@section('title', 'Orders List')
@section('content-header', 'Order List')
@section('content-actions')
    <a href="{{route('cart.index')}}" class="btn btn-success">Open POS</a>
@endsection

<!-- resources/views/kitchen_orders/show.blade.php -->

@section('content')
    <div class="container">
        <h2>Kitchen Order Details</h2>

        <p>Order ID: {{ $kitchenOrder->id }}</p>
        <p>Details: {{ $kitchenOrder->details }}</p>
        <p>Status: {{ $kitchenOrder->is_done ? 'Done' : 'Pending' }}</p>
        <button class="mark-done" data-action="mark-done">Mark as Done</button>
        <button class="mark-undone" data-action="mark-undone">Mark as Undone</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.mark-done, .mark-undone').on('click', function() {
                var orderId = {{ $kitchenOrder->id }};
                var action = $(this).data('action');

                $.ajax({
                    method: 'PATCH',
                    url: '/kitchen_orders/' + orderId,
                    data: { is_done: action === 'mark-done' },
                    success: function(response) {
                        // Update the status on the page
                        $('.status').text(response.status);
                    },
                    error: function(error) {
                        console.error('Error updating order status:', error);
                    }
                });
            });
        });
    </script>
@endsection
