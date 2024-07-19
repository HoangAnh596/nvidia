<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.0.0/js/sb-admin-2.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta3/js/bootstrap-select.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<!-- <script src="https://cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script> -->

<!-- <script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script> -->
<!-- <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script> -->
<script src="{{ asset('cntt/ckeditor/ckeditor.js') }}"></script>

<script>
  var route_prefix = "{{ asset('laravel-filemanager') }}";
  $('#lfm').filemanager('image', {
    prefix: route_prefix
  });
  $('#lfm-prImages').filemanager('image', {
    prefix: route_prefix
  });

  var options = {
    extraPlugins: 'autogrow,filebrowser',
    autoGrow_minHeight: 200,
    autoGrow_maxHeight: 600,
    autoGrow_bottomSpace: 50,
    removePlugins: 'resize',
    toolbarLocation: 'top',
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
  };

  CKEDITOR.replace('my-editor', options);
  CKEDITOR.replace('des-editor', options);

  function uploadImage() {
    const fileInput = document.getElementById('image');
    const imagePreview = document.getElementById('preview');

    // Kiểm tra xem đã chọn tệp chưa
    if (fileInput.files && fileInput.files[0]) {
      const reader = new FileReader();

      reader.onload = function(e) {
        // Hiển thị ảnh trước khi upload
        const image = document.createElement('img');
        image.src = e.target.result;
        imagePreview.innerHTML = '';
        imagePreview.appendChild(image);
      }

      // Đọc tệp và hiển thị ảnh
      reader.readAsDataURL(fileInput.files[0]);
    } else {
      imagePreview.innerHTML = 'Vui lòng chọn một tệp ảnh.';
    }
  }

  $(".hiddenButton").click(function() {
    $('#preview').hide();
  });
  $('.hiddenImg').click(function() {
    $('#holder').hide();
  });
  $(".hiddenButton").click(function() {
    document.getElementById("holder").style.display = "";
  });

  // js thêm ảnh vào bảng child
  function uploadImgChild() {
    const fileInput = document.getElementById('prImages');
    const imagePreview = document.getElementById('pr');

    // Kiểm tra xem đã chọn tệp chưa
    if (fileInput.files && fileInput.files[0]) {
      const reader = new FileReader();

      reader.onload = function(e) {
        // Hiển thị ảnh trước khi upload
        const image = document.createElement('img');
        image.src = e.target.result;
        imagePreview.innerHTML = '';
        imagePreview.appendChild(image);
      }

      // Đọc tệp và hiển thị ảnh
      reader.readAsDataURL(fileInput.files[0]);
    } else {
      imagePreview.innerHTML = 'Vui lòng chọn một tệp ảnh.';
    }
  }

  $(".hiddenBtnPrImages").click(function() {
    $('#pr').hide();
  });
  $('.hiddenPrImages').click(function() {
    $('#image-holder').hide();
  });
  $(".hiddenBtnPrImages").click(function() {
    document.getElementById("image-holder").style.display = "";
  });
</script>