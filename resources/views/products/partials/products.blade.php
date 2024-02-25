@foreach($products as $product)
    <div class="col-md-3 mb-2">
        <div class="card product-card" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-product-price="{{ $product->price }}" data-product-quantity="{{ $product->quantity }}" data-product-status="{{ $product->status }}">
            <div class="card-body">
                {{ $product->name }}<br />
                {{ config('settings.currency_symbol') }}{{ $product->price }} ({{ $product->quantity }})
            </div>
        </div>
    </div>
@endforeach



