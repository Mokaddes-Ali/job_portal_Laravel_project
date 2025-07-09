<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title pb-0" id="exampleModalLabel">Change Profile Picture</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id = "profilePicForm" action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                <input type="file" class="form-control" id="image"  name="image">
                <p class="text-danger" id = "image-error"></p>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mx-3">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content bg-success text-white text-center p-4 position-relative">
      <!-- Close Button -->
      <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
      
      <h5 class="modal-title">Success!</h5>
      <p class="mt-2">Profile image updated successfully!</p>
    </div>
  </div>
</div>


<footer class="bg-dark py-3 bg-2">
<div class="container">
    <p class="text-center text-white pt-3 fw-bold fs-6">© 2023 xyz company, all right reserved</p>
</div>
</footer> 
<script src="{{ asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.5.1.3.min.js')}}"></script>
<script src="{{ asset('assets/js/instantpages.5.1.0.min.js')}}"></script>
<script src="{{ asset('assets/js/lazyload.17.6.0.min.js')}}"></script>
<script src="{{ asset('assets/js/slick.min.js')}}"></script>
<script src="{{ asset('assets/js/lightbox.min.js')}}"></script>
<script src="{{ asset('assets/js/custom.js')}}"></script>

<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

 $('#profilePicForm').submit(function(e){
    e.preventDefault();

    let formData = new FormData(this);

    $('#image-error').html('');

    $.ajax({
        url: '{{ route("ProfilePic") }}',
        type: 'POST',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(response){
            if(response.status === false){
                const errors = response.errors;
                if(errors.image){
                    $('#image-error').html(errors.image[0]);
                }
            } else {
                $('#exampleModal').modal('hide');
                $('#successModal').modal('show');
                $('#profilePicForm')[0].reset();
                
                // Reload the page after 3 seconds to show the new image
                setTimeout(() => {
                    $('#successModal').modal('hide');
                    window.location.reload();
                }, 3000);
            }
        },
        error: function(xhr, status, error) {
            $('#image-error').html('An error occurred while uploading the image.');
            console.error(error);
        }
    });
});
</script>

@yield('customjs')
</body>
</html>