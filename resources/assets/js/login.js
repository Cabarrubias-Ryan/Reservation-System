$(document).ready(function () {
  $('body').on('click', '#loginBtn', function () {
    $.ajax({
      type: 'POST',
      url: '/login/process',
      cache: false,
      data: $('#formAuthentication').serialize(),
      dataType: 'json',
      beforeSend: function () {
        $('.preloader').show();
      },
      success: function (data) {
        $('.preloader').hide();
        if (data.Error == 1) {
          Swal.fire('Error!', data.Message, 'error');
        } else if (data.Error == 0) {
          window.location.href = data.Redirect;
        }
      },
      error: function () {
        $('.preloader').hide();
        Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
      }
    });
  });
});
