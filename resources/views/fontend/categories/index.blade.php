@extends('fontend.layout.user-dashboard')

@section('dashboard')
<div class="container">
    <h3 class="mb-4 d-flex justify-content-between">
        <span>Categories</span>
        <button id="toggleForm" class="btn btn-info btn-sm">Add Category</button>
    </h3>

    <div id="categoryFormBox" style="display: none;">
        <form id="categoryForm">
            @csrf
            <input type="hidden" id="categoryId">
            <div class="mb-3">
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter Category Name">
                <small class="text-danger" id="nameError"></small>
            </div>

            <div class="mb-3">
                <label>Status:</label><br>
                <label><input type="radio" name="status" value="1" checked> Active</label>
                <label class="ms-3"><input type="radio" name="status" value="0"> Inactive</label>
            </div>

            <button type="submit" class="btn btn-success" id="saveBtn">Save</button>
            <div id="loading" class="spinner-border spinner-border-sm text-primary ms-2" style="display:none;"></div>
        </form>
        <hr>
    </div>

    <div id="categoryTable">
        @include('fontend.categories.table')
    </div>
</div>
@endsection

@section('customjs')
<script>
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    $('#toggleForm').click(function () {
        $('#categoryFormBox').slideToggle();
        $(this).text(function(i, text){
            return text === "Add Category" ? "See All" : "Add Category";
        });
    });

    $('#categoryForm').submit(function(e){
        e.preventDefault();
        $('#loading').show();
        $('#nameError').text('');

        let formData = new FormData(this);
        let id = $('#categoryId').val();
        let url = id ? `/categories/${id}` : "{{ route('categories.store') }}";

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(){
                $('#loading').hide();
                $('#categoryForm')[0].reset();
                $('#categoryId').val('');
                $('#saveBtn').text('Save');
                $('#categoryFormBox').slideUp();
                $('#toggleForm').text('Add Category');
                loadCategories();
            },
            error: function(xhr){
                $('#loading').hide();
                if (xhr.responseJSON.errors.name) {
                    $('#nameError').text(xhr.responseJSON.errors.name[0]);
                }
            }
        });
    });

    function loadCategories(){
        $.get("{{ route('categories.index') }}", function(res){
            const html = $(res).find("#categoryTable").html();
            $("#categoryTable").html(html);
        });
    }

    $(document).on('click', '.editBtn', function(){
        let id = $(this).data('id');
        $.get(`/categories/edit/${id}`, function(res){
            $('#categoryId').val(res.id);
            $('#name').val(res.name);
            $(`input[name="status"][value="${res.status}"]`).prop('checked', true);
            $('#saveBtn').text('Update');
            $('#categoryFormBox').slideDown();
            $('#toggleForm').text('See All');
        });
    });

    $(document).on('click', '.deleteBtn', function(){
        if(!confirm('Are you sure?')) return;
        let id = $(this).data('id');
        $.ajax({
            url: `/categories/${id}`,
            type: 'DELETE',
            success: function(){
                loadCategories();
            }
        });
    });
</script>
@endsection
