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
                <form action="{{ route('orders.index') }}">
                    <div class="row">
                        <div class="col-md-2">
                            <p>Start Date</p>    
                            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" />
                        </div>
                        <div class="col-md-2">
                            <p>End Date</p>
                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" />
                        </div>
                        
                        <div class="col-md-0">
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

                        <div class="col-md-2">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-filter"></i> Filter</button>
                            <button class="btn btn-secondary" type="button" id="clearSelectionButton"><i class="fas fa-times"></i> Clear Selection</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <hr>
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <!-- <th>Received</th> -->
                    <!-- <th>Status</th> -->
                    <th>Status</th>
                    <th>Payment Method</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr class="order-row" data-order-id="{{ $order->id }}">

                    <td>{{$order->id}}</td>
                    <td>{{$order->getCustomerName()}}</td>
                    <td>{{ config('settings.currency_symbol') }} {{$order->formattedTotal()}}</td>
                    <!-- <td>{{ config('settings.currency_symbol') }} {{$order->formattedReceivedAmount()}}</td> -->
                    <!-- <td>
                        @if($order->receivedAmount() == 0)
                            <span class="badge badge-danger">Not Paid</span>
                        @elseif($order->receivedAmount() < $order->total())
                            <span class="badge badge-warning">Partial</span>
                        @elseif($order->receivedAmount() == $order->total())
                            <span class="badge badge-success">Paid</span>
                        @elseif($order->receivedAmount() > $order->total())
                            <span class="badge badge-info">Change</span>
                        @endif
                    </td> -->
                    <td>
                        @if($order->status == "failed")
                            <span class="badge badge-danger">Canceled</span>
                        @elseif($order->status == "pending")
                            <span class="badge badge-warning">In-Kitchen</span>
                        @elseif($order->status == "processed")
                            <span class="badge badge-success">Completed</span>
                        @endif
                    </td>
                    
                    <td>{{ str_replace('","', ', ', str_replace('"', '', trim($order->payment_methods(), '[]'))) }}</td>


                    <td>{{$order->created_at}}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#order-details-{{ $order->id }}">View</button>
                    </td>
                </tr>
                <tr id="order-details-{{ $order->id }}" class="collapse">
                    <td colspan="2">
                        <!-- Content to display order items -->
                        <ul>
                            @foreach ($order->items as $item)
                                <li><strong>{{ $item->quantity }}x</strong> {{ $item->product->name }} - {{ round($item->price,0) }}</li>
                            @endforeach
                        </ul>
                        <p>Total Products: {{count($order->items)}}</p>
                    </td>
                    @if($order->commentForCook != "")
                        <td colspan="3" style="width: 200px; overflow-wrap: break-word;">
                            
                        Note:   <strong> {{ $order->commentForCook }}</strong>
                        </td>
                    @endif
                    @if($order->reason != "")
                        <td colspan="2"> Reason for cancelation:    <strong> {{ $order->reason }}</strong></td>

                    @endif
                </tr>
                @endforeach
            </tbody>
            <tfoot><!-- Log on to codeastro.com for more projects -->
                <tr>
                    <th></th>
                    <th></th>
                    <th>{{ config('settings.currency_symbol') }} {{ number_format($total, 2) }}</th>
                    <!-- <th>{{ config('settings.currency_symbol') }} {{ number_format($receivedAmount, 2) }}</th> -->
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
        $('.order-row').on('click', function() {
            var orderId = $(this).data('order-id');
            $('.order-row').not(this).removeClass('active');
            $(this).toggleClass('active');
            $('.collapse').collapse('hide'); // Hide other expanded rows
            $('#order-details-' + orderId).collapse('toggle');
        });
    });

    $(document).ready(function() {
        $('#clearSelectionButton').click(function() {
            // Uncheck all checkboxes
            $('input[type="checkbox"]').prop('checked', false);
            
            // Reset date inputs
            $('input[type="date"]').val('');
        });
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

