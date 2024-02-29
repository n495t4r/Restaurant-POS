@extends('layouts.admin')

@section('title', 'Product Categories')
@section('content-header', 'Product Categories')
@section('content-actions')
<button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createCategoryModal">Create Category</button>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <!-- List of Categories -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="categoriesTable">
                                @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <!-- Edit Category Button -->
                                        <button type="button" class="btn btn-sm btn-primary edit-category" data-id="{{ $category->id }}" data-name="{{ $category->name }}">Edit</button>

                                        <!-- Delete Category Button -->
                                        <button type="button" class="btn btn-sm btn-danger delete-category" data-id="{{ $category->id }}">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Category Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" role="dialog" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCategoryModalLabel">Create New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="createCategoryForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="createCategoryName">Category Name</label>
                        <input type="text" class="form-control" id="createCategoryName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="createParentCategory">Parent Category</label>
                        <select class="form-control" id="createParentCategory" name="parent_id">
                            <option value="">Select Parent Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editCategoryForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editCategoryName">Category Name</label>
                        <input type="text" class="form-control" id="editCategoryName" name="name" required>
                        <input type="hidden" id="editCategoryId" name="id">
                    </div>
                    <div class="form-group">
                        <label for="editParentCategory">Parent Category</label>
                        <select class="form-control" id="editParentCategory" name="parent_id">
                            <option value="">Select Parent Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Create Category
        $('#createCategoryForm').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: '{{ route("product-categories.store") }}', // Adjust the route according to your application
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#createCategoryModal').modal('hide');
                    $('#categoriesTable').append('<tr><td>' + response.category.name + '</td><td><button type="button" class="btn btn-sm btn-primary edit-category" data-id="' + response.category.id + '" data-name="' + response.category.name + '">Edit</button> <button type="button" class="btn btn-sm btn-danger delete-category" data-id="' + response.category.id + '">Delete</button></td></tr>');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        // Show Edit Modal
        $(document).on('click', '.edit-category', function() {
            var categoryId = $(this).data('id');
            var categoryName = $(this).data('name');
            $('#editCategoryId').val(categoryId);
            $('#editCategoryName').val(categoryName);

            // Populate parent category dropdown
            $('#editParentCategory').empty();
            $('#editParentCategory').append('<option value="">Select Parent Category</option>');
            @foreach ($categories as $category)
                $('#editParentCategory').append('<option value="{{ $category->id }}">{{ $category->name }}</option>');
            @endforeach

            // Select the current parent category
            var parentCategoryId = $(this).closest('tr').find('.parent-category').data('id');
            $('#editParentCategory').val(parentCategoryId);

            $('#editCategoryModal').modal('show');
        });

        // Update Category
        $('#editCategoryForm').submit(function(event) {
            event.preventDefault();
            var categoryId = $('#editCategoryId').val();
            $.ajax({
                url: '/admin/product-categories/' + categoryId, // Adjust the route according to your application
                type: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    $('#editCategoryModal').modal('hide');
                    $('button[data-id="' + categoryId + '"]').closest('tr').find('td:first').text(response.category.name);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        // Delete Category
        $(document).on('click', '.delete-category', function() {
            var categoryId = $(this).data('id');
            if (confirm('Are you sure you want to delete this category?')) {
                $.ajax({
                    url: '/admin/product-categories/' + categoryId, // Adjust the route according to your application
                    type: 'DELETE',
                    success: function(response) {
                        $('button[data-id="' + categoryId + '"]').closest('tr').remove();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    });
</script>
@endsection