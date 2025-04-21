$(document).ready(function () {
  $('body').on('click', '#FilterBtn', function () {
    $.ajax({
      url: '/admin/product/filter',
      type: 'post',
      cache: false,
      data: $('#filterData').serialize(),
      dataType: 'json',
      beforeSend: function () {
        $('#FilterModal').modal('hide');
        $('.preloader').show();
      },
      success: function (data) {
        $('.preloader').hide();
        if (data.Error == 1) {
          Swal.fire('Error!', data.Message, 'error');
        } else if (data.Error == 0) {
          console.log(data.Message);
          location.reload();
        }
      },
      error: function () {
        $('.preloader').hide();
        Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
      }
    });
  });
});
