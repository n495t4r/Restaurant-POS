@extends('layouts.admin')

@section('title', 'Product Management')
@section('content-header', 'Product Management')
@section('content-actions')
<a href="{{ route('products.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Add New Product</a>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('content')
<div class="card product-list">
    <div class="card-body">
        <label for="category-filter">Filter by Category:</label>
        <select id="category-filter">
            <option value="">All Categories</option>
            <option value="drink">Drinks</option>
            <option value="soup">Soups</option>
            <!-- Add more options as needed -->
        </select>
        <table class="table table-bordered table-hover" id="product-table">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td><img class="product-img img-thumbnail" src="{{ Storage::url($product->image) }}" alt=""></td>
                    <td>
                    
                    @if(!empty($product->product_category->name))    
                    {{ 
                        $product->product_category->name
                    }}
                    @endif
                    </td>
                    <td>{{ config('settings.currency_symbol') . $product->price }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>
                        <span class="right badge badge-{{ $product->status ? 'success' : 'danger' }}">
                            {{ $product->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>{{ $product->created_at }}</td>
                    <td>{{ $product->updated_at }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        <button class="btn btn-danger btn-delete" data-url="{{ route('products.destroy', $product) }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('js')


<script>
    $(document).ready(function () {
        $('#product-table').DataTable({
            searching: true,
            ordering: true,
            paging: true,
            responsive: true,
        });

          // Category filter event listener
        $('#category-filter').on('change', function () {
            var category = $(this).val();
            table.column(1).search(category).draw(); // Assuming the category column is at index 1
        });

        $(document).on('click', '.btn-delete', function () {
            $this = $(this);
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: 'Do you really want to delete this product?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.post($this.data('url'), { _method: 'DELETE', _token: '{{ csrf_token() }}' }, function (res) {
                        $this.closest('tr').fadeOut(500, function () {
                            $(this).remove();
                        });
                    });
                }
            });
        });
    });
</script>
@endsection
