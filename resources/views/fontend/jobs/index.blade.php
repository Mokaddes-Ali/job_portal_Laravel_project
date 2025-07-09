@extends('fontend.layout.user-dashboard')

@section('dashboard')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4 class="fw-bold">All Jobs</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#jobModal">➕ Add Job</button>
    </div>

    <!-- Jobs List -->
    <div id="jobList">
        @include('fontend.jobs.table')
    </div>
</div>

<!-- Job Modal -->
<div class="modal fade" id="jobModal" tabindex="-1" aria-labelledby="jobModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <form id="jobForm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="jobModalLabel">Add New Job</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              @csrf
              <div class="row">
                  <div class="col-md-6 mb-3">
                      <label>Title <span class="text-danger">*</span></label>
                      <input type="text" name="title" class="form-control">
                      <small class="text-danger error-title"></small>
                  </div>
                  <div class="col-md-6 mb-3">
                      <label>Category <span class="text-danger">*</span></label>
                      <select name="category_id" class="form-select">
                          <option value="">Select</option>
                          @foreach($categories as $cat)
                              <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                          @endforeach
                      </select>
                      <small class="text-danger error-category_id"></small>
                  </div>
                  <div class="col-md-6 mb-3">
                      <label>Job Type <span class="text-danger">*</span></label>
                      <select name="job_type_id" class="form-select">
                          <option value="">Select</option>
                          @foreach($jobTypes as $type)
                              <option value="{{ $type->id }}">{{ $type->name }}</option>
                          @endforeach
                      </select>
                      <small class="text-danger error-job_type_id"></small>
                  </div>
                  <div class="col-md-6 mb-3">
                      <label>Vacancy <span class="text-danger">*</span></label>
                      <input type="number" name="vacancy" class="form-control">
                      <small class="text-danger error-vacancy"></small>
                  </div>
                  <div class="col-md-6 mb-3">
                      <label>Salary</label>
                      <input type="text" name="salary" class="form-control">
                  </div>
                  <div class="col-md-6 mb-3">
                      <label>Location <span class="text-danger">*</span></label>
                      <input type="text" name="location" class="form-control">
                      <small class="text-danger error-location"></small>
                  </div>
              </div>
              <div class="mb-3">
                  <label>Description <span class="text-danger">*</span></label>
                  <textarea name="description" class="form-control" rows="3"></textarea>
                  <small class="text-danger error-description"></small>
              </div>
              <div class="mb-3">
                  <label>Company Name <span class="text-danger">*</span></label>
                  <input type="text" name="company_name" class="form-control">
                  <small class="text-danger error-company_name"></small>
              </div>
              <div class="mb-3">
                  <label>Keywords <span class="text-danger">*</span></label>
                  <input type="text" name="keywords" class="form-control">
                  <small class="text-danger error-keywords"></small>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Save Job</button>
          </div>
        </div>
    </form>
  </div>
</div>
@endsection

@section('customjs')
<script>
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    $('#jobForm').submit(function(e){
        e.preventDefault();
        let formData = new FormData(this);
        $('.text-danger').text('');

        $.ajax({
            type: 'POST',
            url: "{{ route('jobs.store') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res){
                $('#jobModal').modal('hide');
                $('#jobForm')[0].reset();
                loadJobs();
            },
            error: function(xhr){
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, val){
                    $('.error-' + key).text(val[0]);
                });
            }
        });
    });

    function loadJobs(){
        $.get("{{ route('jobs.index') }}", function(res){
            let data = $(res).find('#jobList').html();
            $('#jobList').html(data);
        });
    }
</script>
@endsection
