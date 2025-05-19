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

$(document).ready(function () {
  $('#BtnVoucher').on('click', function () {
    console.log('click');
    const fields = [
      { id: 'voucherName', label: 'Voucher Name' },
      { id: 'voucherCode', label: 'Voucher Code' },
      { id: 'voucherRequirements', label: 'Voucher Requirement' },
      { id: 'voucherDiscount', label: 'Voucher Discount' },
      { id: 'voucherDescription', label: 'Voucher Description' }
    ];

    const isValid = validateForm(fields);

    if (!isValid) {
      event.preventDefault();
      return;
    }

    $.ajax({
      type: 'POST',
      url: '/admin/vouchers-reports/add',
      cache: false,
      data: $('#VoucherData').serialize(),
      dataType: 'json',
      beforeSend: function () {
        $('#AddVouchers').modal('hide');
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

$(document).ready(function () {
  function displayUsers(voucher) {
    const $voucherList = $('#voucherlist');
    $voucherList.empty();

    if (voucher.length === 0) {
      $voucherList.html(`<tr><td colspan="6" class="text-center text-muted">No voucher found.</td></tr>`);
      return;
    }

    voucher.forEach(voucher => {
      const formattedDate = new Date(voucher.date).toLocaleDateString('en-US', {
        month: 'short',
        day: '2-digit',
        year: 'numeric'
      });
      const formattedExpireDate = new Date(voucher.expire_date).toLocaleDateString('en-US', {
        month: 'short',
        day: '2-digit',
        year: 'numeric'
      });
      const voucherRow = `
        <tr>
          <td><span>${voucher.name}</span></td>
          <td>${voucher.code}</td>
          <td>${voucher.discount}% off</td>
          <td>${formattedDate}</td>
          <td>${formattedExpireDate}</td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-more-2-line"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item Edit" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#EditVoucher"
                  data-id="${voucher.encrypted_id}"
                  data-name="${voucher.name}"
                  data-code="${voucher.code}"
                  data-requirements="${voucher.requirements}"
                  data-discount="${voucher.discount}"
                  data-description="${voucher.description}"
                  data-expire_date="${voucher.expire_date}">
                  <i class="ri-pencil-line me-1"></i> Edit
                </a>
                <a class="dropdown-item DeleteBtn" href="javascript:void(0);" data-id="${voucher.encrypted_id}">
                  <i class="ri-delete-bin-6-line me-1"></i> Delete
                </a>
              </div>
            </div>
          </td>
        </tr>
      `;
      $voucherList.append(voucherRow);
    });
  }

  function filterUsers(query) {
    const filtered = window.voucher.filter(voucher => {
      return voucher.name.toLowerCase().includes(query);
    });
    displayUsers(filtered);
  }

  $('#search').on('input', function () {
    const query = $(this).val().toLowerCase();
    filterUsers(query);
  });

  // Render all users on page load
  displayUsers(window.voucher);
});

$(document).ready(function () {
  $('body').on('click', '.Edit', function () {
    const id = $(this).data('id');
    const name = $(this).data('name');
    const code = $(this).data('code');
    const requirements = $(this).data('requirements');
    const discount = $(this).data('discount');
    const expire = $(this).data('expire_date');
    const description = $(this).data('description');

    $('#Edit_id').val(id);
    $('#Edit_voucherName').val(name);
    $('#Edit_voucherCode').val(code);
    $('#Edit_voucherRequirements').val(requirements);
    $('#Edit_voucherDiscount').val(discount);
    $('#Edit_voucherExpire').val(expire);
    $('#Edit_voucherDescription').val(description);
  });

  $('body').on('click', '#BtnEditVouchers', function (event) {
    const fields = [
      { id: 'Edit_id', label: 'ID' },
      { id: 'Edit_voucherName', label: 'Voucher Name' },
      { id: 'Edit_voucherCode', label: 'Voucher Code' },
      { id: 'Edit_voucherRequirements', label: 'Voucher Requirements' },
      { id: 'Edit_voucherDiscount', label: 'Voucher Discount' },
      { id: 'Edit_voucherExpire', label: 'Voucher Expiry' },
      { id: 'Edit_voucherDescription', label: 'Description' }
    ];

    const isValid = validateForm(fields);

    if (!isValid) {
      event.preventDefault();
      return;
    }

    $.ajax({
      type: 'POST',
      url: '/admin/vouchers-reports/update',
      cache: false,
      data: $('#Edit_VoucherData').serialize(),
      dataType: 'json',
      beforeSend: function () {
        $('#EditVoucher').modal('hide');
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

//for deleting
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
          url: '/admin/vouchers-reports/delete',
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
