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

    if (field.id === 'password-confirmation' && value) {
      const password = document.getElementById('password').value.trim();
      if (value !== password) {
        valid = false;
        errorMessages.push('Passwords do not match.');
      }
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

function validateFormPassword(fields) {
  let valid = true;

  fields.forEach(field => {
    const input = document.getElementById(field.id);
    const value = input.value.trim();
    const errorMessages = [];

    if (!value) {
      valid = false;
      errorMessages.push(`${field.label} is required.`);
    }
    if (field.id === 'password-confirmation' && value) {
      const password = document.getElementById('password').value.trim();
      if (value !== password) {
        valid = false;
        errorMessages.push('Passwords do not match.');
      }
    }

    const errorMessageContainer = document.getElementById(`${field.id}-error`);
    if (errorMessages.length > 0) {
      input.classList.add('is-invalid');
      if (errorMessageContainer) {
        errorMessageContainer.innerHTML = errorMessages.join('<br>');
        errorMessageContainer.style.display = 'block';
      }
    } else {
      input.classList.remove('is-invalid');
      if (errorMessageContainer) {
        errorMessageContainer.innerHTML = '';
        errorMessageContainer.style.display = 'none';
      }
    }
  });

  return valid;
}
// for adding

$(document).ready(function () {
  $('#AddAcountBtn').on('click', function (event) {
    const fields = [
      { id: 'username', label: 'Username' },
      { id: 'firstname', label: 'Firstname' },
      { id: 'lastname', label: 'Lastname' },
      { id: 'email', label: 'Email' },
      { id: 'terms-conditions', label: 'Terms and Condition' }
    ];
    const passwords = [
      { id: 'password', label: 'Password' },
      { id: 'password-confirmation', label: 'Password Confirmation' }
    ];
    const isPasswordValid = validateFormPassword(passwords);
    const isValid = validateForm(fields);

    if (!isValid || !isPasswordValid) {
      event.preventDefault();
      return;
    }

    $.ajax({
      type: 'POST',
      url: '/auth/register-basic/add',
      cache: false,
      data: $('#AddAccountData').serialize(),
      dataType: 'json',
      beforeSend: function () {
        $('#AddAccount').modal('hide');
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

// for editing
$(document).ready(function () {
  $('body').on('click', '.Edit', function () {
    const id = $(this).data('id');
    const firstname = $(this).data('firstname');
    const middlename = $(this).data('middlename');
    const lastname = $(this).data('lastname');
    const username = $(this).data('username');
    const email = $(this).data('email');

    $('#Edit_id').val(id);
    $('#Edit_firstname').val(firstname);
    $('#Edit_middlename').val(middlename);
    $('#Edit_lastname').val(lastname);
    $('#Edit_username').val(username);
    $('#Edit_email').val(email);
  });

  $('body').on('click', '#SaveEditBtn', function (event) {
    const fields = [
      { id: 'Edit_firstname', label: 'Firstname' },
      { id: 'Edit_lastname', label: 'Lastname' },
      { id: 'Edit_username', label: 'Username' },
      { id: 'Edit_email', label: 'Email' }
    ];

    const isValid = validateForm(fields);

    if (!isValid) {
      event.preventDefault();
      return;
    }

    $.ajax({
      type: 'POST',
      url: '/auth/register-basic/update',
      cache: false,
      data: $('#EditAccountData').serialize(),
      dataType: 'json',
      beforeSend: function () {
        $('#EditAccount').modal('hide');
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
          url: '/auth/register-basic/delete',
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
//for searching
$(document).ready(function () {
  $('#search').on('keyup', function () {
    var data = $(this).val().toLowerCase();

    if (data.length >= 1) {
      $.ajax({
        type: 'POST',
        url: '/auth/register-basic/search',
        cache: false,
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          search: data
        },
        dataType: 'json',
        success: function (data) {
          if (data.Error == 1) {
            Swal.fire('Error!', data.Message, 'error');
          } else if (data.Error == 0) {
            renderTaskList(data.html);
          }
        },
        error: function () {
          Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
        }
      });
    } else {
      $.ajax({
        type: 'GET',
        url: '/auth/register-basic',
        cache: false,
        success: function (data) {
          if (data.Error == 1) {
            Swal.fire('Error!', data.Message, 'error');
          } else if (data.Error == 0) {
            renderTaskList(data.html);
          }
        },
        error: function () {
          Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
        }
      });
    }
  });

  function renderTaskList(users) {
    let taskListHtml = ''; // Initialize an empty string for task list HTML

    // Loop through each task and generate the HTML
    users.forEach(function (user) {
      taskListHtml += `
          <tr>
          <td><span>${user.firstname} ${user.lastname}</span></td>
          <td>${user.email}</td>
          <td>${user.username}</td>
          <td><span class="badge rounded-pill bg-label-primary me-1">Active</span></td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-more-2-line"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item Edit" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#EditAccount"
                data-id="${user.id}"
                data-firstname="${user.firstname}"
                data-middlename="${user.middlename}"
                data-lastname="${user.lastname}"
                data-username="${user.username}"
                data-email="${user.email}"
                ><i class="ri-pencil-line me-1"></i> Edit</a>
                <a class="dropdown-item DeleteBtn" data-id="${user.id}" href="javascript:void(0);"><i class="ri-delete-bin-6-line me-1"></i> Delete</a>
              </div>
            </div>
          </td>
        </tr>
          `;
    });

    if (users.length === 0) {
      taskListHtml = `
      <tr>
          <h5>No Task Found</h5>
      </tr>
          `;
    }

    // Update the task list container with the generated HTML
    $('#userlist').html(taskListHtml);
  }
});
