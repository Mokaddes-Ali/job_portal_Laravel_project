@extends('fontend.layout.user-dashboard')

@section('dashboard')
<div class="container">
    <h3 class="mb-4 d-flex justify-content-between">
        <span>Job Types</span>
        <button id="toggleForm" class="btn btn-info btn-sm">Add Job Type</button>
    </h3>

    <!-- Form -->
    <div id="jobTypeFormBox" style="display:none;">
        <form id="jobTypeForm">
            @csrf
            <input type="hidden" name="id" id="jobTypeId">
            <div class="mb-3">
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter job type name">
                <small class="text-danger" id="nameError"></small>
            </div>

            <div class="mb-3">
                <label>Status</label><br>
                <label><input type="radio" name="status" value="1" checked> Active</label>
                <label class="ms-3"><input type="radio" name="status" value="0"> Inactive</label>
            </div>

            <button type="submit" class="btn btn-success" id="saveBtn">Save</button>
            <div id="loading" class="spinner-border spinner-border-sm text-primary ms-2" style="display:none;"></div>
        </form>
        <hr>
    </div>

    <!-- Table -->
    <div id="jobTypeTable">
        @include('fontend.job_types.table')
    </div>
</div>
@endsection

@section('customjs')
<script>
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Toggle Form
    $('#toggleForm').click(function () {
        $('#jobTypeFormBox').slideToggle();
        $(this).text(function(i, text){
            return text === "Add Job Type" ? "See All" : "Add Job Type";
        })
    });

    // Form Submit
    $('#jobTypeForm').submit(function(e){
        e.preventDefault();
        $('#loading').show();
        $('#nameError').text('');

        let formData = new FormData(this);
        let id = $('#jobTypeId').val();
        let url = id ? `/job-types/${id}` : "{{ route('job-types.store') }}";
        let method = id ? 'POST' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false,
            contentType: false,
            success: function(res){
                $('#loading').hide();
                $('#jobTypeForm')[0].reset();
                $('#jobTypeId').val('');
                $('#saveBtn').text('Save');
                $('#jobTypeFormBox').slideUp();
                $('#toggleForm').text('Add Job Type');
                loadJobTypes();
            },
            error: function(xhr){
                $('#loading').hide();
                if (xhr.responseJSON.errors.name) {
                    $('#nameError').text(xhr.responseJSON.errors.name[0]);
                }
            }
        });
    });

    // Load Table
    function loadJobTypes(){
        $.get("{{ route('job-types.index') }}", function(res){
            const html = $(res).find("#jobTypeTable").html();
            $("#jobTypeTable").html(html);
        });
    }

    // Edit
    $(document).on('click', '.editBtn', function(){
        let id = $(this).data('id');
        $.get(`/job-types/edit/${id}`, function(res){
            $('#jobTypeId').val(res.id);
            $('#name').val(res.name);
            $(`input[name="status"][value="${res.status}"]`).prop('checked', true);
            $('#saveBtn').text('Update');
            $('#jobTypeFormBox').slideDown();
            $('#toggleForm').text('See All');
        });
    });

    // Delete
    $(document).on('click', '.deleteBtn', function(){
        if(!confirm('Are you sure?')) return;
        let id = $(this).data('id');
        $.ajax({
            url: `/job-types/${id}`,
            type: 'DELETE',
            success: function(){
                loadJobTypes();
            }
        });
    });
</script>
@endsection
