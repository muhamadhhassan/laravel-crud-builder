<div>
  <div class="image-input image-input-outline" id="kt_image_4" style="width: 100%; padding-top: 100% background-image: url(assets/media/>users/blank.png)">
    <div class="image-input-wrapper" style="width: 100%; padding-top: 100%; background-image: url('/media/svg/icons/Files/Upload.svg')"></div>
      <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
        <i class="fa fa-pen icon-sm text-muted"></i>
        <input type="file" name="image" accept=".png, .jpg, .jpeg" class="{{ $errors->get('time') ? 'is-invalid' : '' }}"/>
        <input type="hidden" name="image_remove"/>
      </label>

      <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
        <i class="ki ki-bold-close icon-xs text-muted"></i>
      </span>

      <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove avatar">
        <i class="ki ki-bold-close icon-xs text-muted"></i>
      </span>
    </div>
    @error('image')
      <span class="form-text" style="color: red">{{ $message }}</span>
    @enderror
    <span class="form-text text-muted">The maximum image size is 1MB</span>
</div>

@section('scripts')
  <script>
    var avatar4 = new KTImageInput('kt_image_4');
    avatar4.on('cancel', function(imageInput) {
      swal.fire({
        title: 'Image successfully canceled !',
        type: 'success',
        buttonsStyling: false,
        confirmButtonText: 'Awesome!',
        confirmButtonClass: 'btn btn-primary font-weight-bold'
      });
    });

    avatar4.on('change', function(imageInput) {
      swal.fire({
        title: 'Image successfully changed !',
        type: 'success',
        buttonsStyling: false,
        confirmButtonText: 'Awesome!',
        confirmButtonClass: 'btn btn-primary font-weight-bold'
      });
    });

    avatar4.on('remove', function(imageInput) {
      swal.fire({
        title: 'Image successfully removed !',
        type: 'error',
        buttonsStyling: false,
        confirmButtonText: 'Got it!',
        confirmButtonClass: 'btn btn-primary font-weight-bold'
      });
    });
  </script>
@endsection
