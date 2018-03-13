$("#login-button").click(function(event){
    event.preventDefault();

  $('form').fadeOut(500);
  $('.wrapper').addClass('form-success');
});


$(document).ready(function() {
  $(document).on('submit','.form', function(e) {
    e.preventDefault();

    var controller = $('#base_url').val() + "functions/login";
    var data       = $(this).serialize();

    $.ajax({

      type     : "POST",
      url      : controller,
      dataType : "JSON",
      data     : data,

      success  : function(data) {
          if (data.code == 1) {
            $('.error').html(data.reply);
          }else if (data.code == 2) {
            window.location.href = "admin/home";
          }
      }



    });


  })
})
