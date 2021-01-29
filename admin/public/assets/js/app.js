"use strict";

/* +=+ [ Single Image Previewer ] +=+ */
function readURL(input) {
   if (input.files && input.files[0]) {
      var reader = new FileReader();
      var div_id = $(input).attr('set-to');
      reader.onload = function (e) {
         $('#' + div_id).attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
   }
}
$(".default").change(function () {
   readURL(this);
});


$(document).ready(function () {  

   /* +=+ [ Window Refresh ] +=+ */
   $(document).on('click', '#refreshWindow', function () {
      window.location.reload();
   });


   /* +=+ [ Hide Custom Alert ] +=+ */
   setTimeout(function () {
      $('.customAlert').hide();
   }, 7000);


   /* +=+ [ Uploaded File Name ] +=+ */
   $(document).on('change', '.imageFile', function (event) {
      let file = event.target.files[0];
      $('.fileName').html(file.name + ' <span class="text-success">is uploaded</span>');
   });

});