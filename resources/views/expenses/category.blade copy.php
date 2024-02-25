@extends('layouts.admin')

@section('title', 'Expense Category')
@section('content-header', 'Expense Category')
@section('content-actions')
<!-- Total Expense Amount -->
    <button id="createExpenseBtn" class="btn btn-primary">Add Expense</button>

@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Expense Categories</div>

                <div class="card-body">
                    <!-- Create Category Button -->
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createCategoryModal">Create Category</button>

                    <!-- List of Categories -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <!-- Edit Category Button -->
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editCategoryModal{{ $category->id }}">Edit</button>

                                    <!-- Delete Category Button -->
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteCategoryModal{{ $category->id }}">Delete</button>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach ($categories as $category)
<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editCategoryForm{{ $category->id }}" data-id="{{ $category->id }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editCategoryName{{ $category->id }}">Category Name</label>
                        <input type="text" class="form-control" id="editCategoryName{{ $category->id }}" name="name" value="{{ $category->name }}" required>
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

<!-- Delete Category Modal -->
<div class="modal fade" id="deleteCategoryModal{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryModalLabel{{ $category->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCategoryModalLabel{{ $category->id }}">Delete Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteCategoryForm{{ $category->id }}" data-id="{{ $category->id }}">
                <div class="modal-body">
                    <p>Are you sure you want to delete this category?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection

@section('scripts')
@section('scripts')
<script>
    // Create Category Form Submission
    $('#createCategoryForm').submit(function(e) {
        e.preventDefault();
        var name = $('#createCategoryName').val();
        $.post("{{ route('expense-categories.store') }}", { name: name, _token: '{{ csrf_token() }}' })
            .done(function(data) {
                // Add the new category to the table dynamically
                var newRow = '<tr>' +
                    '<td>' + data.name + '</td>' +
                    '<td>' +
                    '<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editCategoryModal' + data.id + '">Edit</button>' +
                    '<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteCategoryModal' + data.id + '">Delete</button>' +
                    '</td>' +
                    '</tr>';
                $('#categoriesTable tbody').append(newRow);
                
                // Reset the form fields
                $('#createCategoryName').val('');
                
                // Close the modal
                $('#createCategoryModal').modal('hide');
                
                // Show success message
                alert("Category created successfully");
            })
            .fail(function(xhr, status, error) {
                console.error(error);
                // Show error message
                alert("Failed to create category");
            });
    });

    // Edit Category Form Submission
    $('[id^=editCategoryForm]').submit(function(e) {
        e.preventDefault();
        var categoryId = $(this).data('id');
        var name = $('#editCategoryName' + categoryId).val();
        $.ajax({
            type: "PUT",
            url: "{{ route('expense-categories.update', ':id') }}".replace(':id', categoryId),
            data: { name: name, _token: '{{ csrf_token() }}' },
            success: function(data) {
                // Update the category name in the table dynamically
                $('#categoriesTable tbody td:first-child').filter(function() {
                    return $(this).text() === categoryId.toString();
                }).next().text(name);
                
                // Close the modal
                $('#editCategoryModal' + categoryId).modal('hide');
                
                // Show success message
                alert("Category updated successfully");
            },
            error: function(xhr, status, error) {
                console.error(error);
                // Show error message
                alert("Failed to update category");
            }
        });
    });

    // Delete Category Form Submission
    $('[id^=deleteCategoryForm]').submit(function(e) {
        e.preventDefault();
        var categoryId = $(this).data('id');
        if (confirm('Are you sure you want to delete this category?')) {
            $.ajax({
                type: "DELETE",
                url: "{{ route('expense-categories.destroy', ':id') }}".replace(':id', categoryId),
                data: { _token: '{{ csrf_token() }}' },
                success: function(data) {
                    // Remove the category row from the table
                    $('#categoriesTable tbody td:first-child').filter(function() {
                        return $(this).text() === categoryId.toString();
                    }).parent().remove();
                    
                    // Close the modal
                    $('#deleteCategoryModal' + categoryId).modal('hide');
                    
                    // Show success message
                    alert("Category deleted successfully");
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    // Show error message
                    alert("Failed to delete category");
                }
            });
        }
    });
</script>
@endsection



@endsection
