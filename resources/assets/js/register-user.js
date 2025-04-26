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
    if (field.id === 'password' && value) {
      if (!/[A-Z]/.test(value)) {
        valid = false;
        errorMessages.push('Password must contain at least one uppercase letter.');
      }
      if (!/[0-9]/.test(value)) {
        valid = false;
        errorMessages.push('Password must contain at least one number.');
      }
      if (!/[!@#$%^&*(),.?":{}|<>]/.test(value)) {
        valid = false;
        errorMessages.push('Password must contain at least one special character.');
      }
      if (value.length < 8) {
        valid = false;
        errorMessages.push('Password must be at least 8 characters long.');
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
// create A account
$(document).ready(function () {
  $('body').on('click', '#registerAccountBtn', function () {
    const fields = [
      { id: 'username', label: 'Username' },
      { id: 'firstname', label: 'Firstname' },
      { id: 'lastname', label: 'Lastname' },
      { id: 'email', label: 'Email' }
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
      url: '/auth/register-user/add',
      cache: false,
      data: $('#registerAccount').serialize(),
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
            window.location.href = data.Redirect;
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
