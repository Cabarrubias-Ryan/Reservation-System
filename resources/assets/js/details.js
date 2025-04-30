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
  $('#reservationBtn').on('click', function (event) {
    const date = [
      { id: 'checkin-date', label: 'Check in' },
      { id: 'checkout-date', label: 'Check out' }
    ];

    const isValid = validateForm(date);

    if (!isValid) {
      event.preventDefault();
      return;
    }
    const checkinDate = $('#checkin-date').val();
    const checkoutDate = $('#checkout-date').val();
    const price = $('#venue_price').val();
    const name = $('#venue_name').val();
    const venueId = $('#venue_id').val();

    const checkin = new Date(checkinDate);
    const checkout = new Date(checkoutDate);

    if (checkin >= checkout) {
      Toastify({
        text: 'Check-in date cannot be later than or equal check-out date.',
        duration: 3000,
        close: true,
        gravity: 'top', // top or bottom
        position: 'right', // left, center or right
        backgroundColor: '#cc3300',
        stopOnFocus: true
      }).showToast();
      event.preventDefault();
    } else {
      const timeDifference = checkout - checkin;
      const dayDifference = timeDifference / (1000 * 3600 * 24); // Convert milliseconds to days
      const totalPrice = dayDifference * price;

      const totalPriceFormat = new Intl.NumberFormat('PHP', {
        style: 'currency',
        currency: 'PHP',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      }).format(totalPrice);

      const PriceFormat = new Intl.NumberFormat('PHP', {
        style: 'currency',
        currency: 'PHP',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      }).format(price);

      $('#dayDifference').text(dayDifference);
      $('#checkin').text(checkinDate);
      $('#checkout').text(checkoutDate);
      $('#VenueId').text(venueId);
      $('#name').text(name);
      $('#price').text(PriceFormat);
      $('#totalPrice').text(totalPriceFormat);

      $('#Details').modal('show');
    }
  });
});

$(document).ready(function () {
  $('body').on('click', '#loginBtn', function () {
    const data = [
      { id: 'email', label: 'Email and Username' },
      { id: 'password', label: 'Password' }
    ];

    let isValid = data.every(
      input =>
        $('#' + input.id)
          .val()
          .trim() !== ''
    );

    if (!isValid) {
      Toastify({
        text: 'Please fill in all required fields.',
        duration: 3000,
        close: true,
        gravity: 'top', // top or bottom
        position: 'right', // left, center or right
        backgroundColor: '#cc3300',
        stopOnFocus: true
      }).showToast();
      event.preventDefault();
      return;
    }

    $.ajax({
      type: 'POST',
      url: '/login/process',
      cache: false,
      data: $('#formAuthentication').serialize(),
      dataType: 'json',
      success: function (data) {
        if (data.Error == 1) {
          Toastify({
            text: data.Message,
            duration: 3000,
            close: true,
            gravity: 'top', // top or bottom
            position: 'right', // left, center or right
            backgroundColor: '#dc3545',
            stopOnFocus: true
          }).showToast();
        } else if (data.Error == 0) {
          window.location.href = data.Redirect;
        }
      },
      error: function (xhr) {
        if (xhr.status === 429) {
          let errorMessage = xhr.responseJSON.Message || 'Too many login attempts. Please try again later.';
          Toastify({
            text: errorMessage,
            duration: 3000,
            close: true,
            gravity: 'top', // top or bottom
            position: 'right', // left, center or right
            backgroundColor: '#cc3300',
            stopOnFocus: true
          }).showToast();
        } else {
          // Handle other errors (invalid credentials, etc.)
          let errorMessage = xhr.responseJSON.Message || 'An unexpected error occurred.';
          Toastify({
            text: errorMessage,
            duration: 3000,
            close: true,
            gravity: 'top', // top or bottom
            position: 'right', // left, center or right
            backgroundColor: '#cc3300',
            stopOnFocus: true
          }).showToast();
        }
      }
    });
  });
});
