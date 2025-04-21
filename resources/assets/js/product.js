// error trapping
function validateForm(fields) {
  let valid = true;

  // Loop through all fields to check if any are empty
  fields.forEach(field => {
    const input = document.getElementById(field.id);
    const value = input.value.trim();
    const errorMessages = [];

    // Check for empty fields
    if (!value) {
      valid = false;
      errorMessages.push(`${field.label} is required.`);
    }

    if (errorMessages.length > 0) {
      input.classList.add('is-invalid'); // Add Bootstrap 'is-invalid' class
      let errorMessageContainer = input.parentNode.querySelector('.invalid-feedback');
      if (!errorMessageContainer) {
        errorMessageContainer = document.createElement('div');
        errorMessageContainer.classList.add('invalid-feedback');
        input.parentNode.appendChild(errorMessageContainer);
      }
      errorMessageContainer.innerHTML = errorMessages.join('<br>'); // Display all errors for this field
    } else {
      input.classList.remove('is-invalid'); // Remove 'is-invalid' class if valid
      let errorMessageContainer = input.parentNode.querySelector('.invalid-feedback');
      if (errorMessageContainer) {
        errorMessageContainer.remove(); // Remove error messages
      }
    }
  });

  return valid;
}
//add
$(document).ready(function () {
  $('body').on('click', '#SaveProduct', function () {
    const fields = [
      { id: 'DataImages', label: 'Images' },
      { id: 'name', label: 'Name' },
      { id: 'price', label: 'Price' },
      { id: 'code', label: 'Code' },
      { id: 'category', label: 'Category' },
      { id: 'description', label: 'Description' }
    ];

    const isValid = validateForm(fields);

    if (!isValid) {
      event.preventDefault();
      return;
    }
    var formData = new FormData($('#ProductData')[0]);
    $.ajax({
      type: 'POST',
      url: '/admin/product/add',
      cache: false,
      contentType: false,
      processData: false,
      data: formData,
      dataType: 'json',
      beforeSend: function () {
        $('#AddProduct').modal('hide');
        $('.preloader').show();
      },
      success: function (data) {
        $('.preloader').hide();
        if (data.Error == 1) {
          Swal.fire('Error!', data.Message, 'error');
        } else if (data.Error == 0) {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Saved!',
            text: data.Message,
            showConfirmButton: true,
            confirmButtonText: 'OK'
          }).then(result => {
            location.reload();
          });
        }
      },
      error: function () {
        $('.preloader').hide();
        Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
      }
    });
  });
});
// filter
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
// update
$(document).ready(function () {
  $('body').on('click', '#UpdateProduct', function () {
    const fields = [
      { id: 'Edit_DataImages', label: 'Images' },
      { id: 'Edit_name', label: 'Name' },
      { id: 'Edit_price', label: 'Price' },
      { id: 'Edit_code', label: 'Code' },
      { id: 'Edit_category', label: 'Category' },
      { id: 'Edit_description', label: 'Description' }
    ];

    const isValid = validateForm(fields);

    if (!isValid) {
      event.preventDefault();
      return;
    }
    var formData = new FormData($('#ProductDataUpdate')[0]);

    $.ajax({
      type: 'POST',
      url: '/admin/product/update',
      cache: false,
      contentType: false,
      processData: false,
      data: formData,
      dataType: 'json',
      beforeSend: function () {
        $('#EditProduct').modal('hide');
        $('.preloader').show();
      },
      success: function (data) {
        $('.preloader').hide();
        if (data.Error == 1) {
          Swal.fire('Error!', data.Message, 'error');
        } else if (data.Error == 0) {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Saved!',
            text: data.Message,
            showConfirmButton: true,
            confirmButtonText: 'OK'
          }).then(result => {
            location.reload();
          });
        }
      },
      error: function () {
        $('.preloader').hide();
        Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
      }
    });

    //
  });
});

//delete
$(document).ready(function () {
  $('body').on('click', '.DeleteBtn', function () {
    const id = $(this).data('id');
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
      reverseButtons: true
    }).then(result => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'POST',
          url: '/admin/product/delete',
          cache: false,
          data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: id
          },
          dataType: 'json',
          beforeSend: function () {
            $('.preloader').show();
          },
          success: function (data) {
            $('.preloader').hide();
            if (data.Error == 1) {
              Swal.fire('Error!', data.Message, 'error');
            } else if (data.Error == 0) {
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Saved!',
                text: data.Message,
                showConfirmButton: true,
                confirmButtonText: 'OK'
              }).then(result => {
                location.reload();
              });
            }
          },
          error: function () {
            $('.preloader').hide();
            Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
          }
        });
      }
    });
  });
});
