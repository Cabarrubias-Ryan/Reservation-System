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
    const now = Date.now();

    if (checkin < now && checkout < now) {
      Toastify({
        text: "Oops! You can't travel back in time — pick future dates!",
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
      return;
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

      const options = { month: 'long', day: 'numeric', year: 'numeric' };
      const Datecheckin = checkin.toLocaleString('en-PH', options);
      const Datecheckout = checkout.toLocaleString('en-PH', options);

      $('#dayDifference').text(dayDifference);
      $('#checkin').text(Datecheckin);
      $('#checkout').text(Datecheckout);
      $('#VenueId').text(venueId);
      $('#name').text(name);
      $('#price').text(PriceFormat);
      $('#totalPrice').text(totalPriceFormat);

      $('#Details').modal('show');
    }
  });
});
// reservation

$(document).ready(function () {
  $('body').on('click', '#reservationProcessBtn', function () {
    let totalPriceFormat = $('#totalPrice').text().trim();
    let cleanedPrice = totalPriceFormat.replace(/₱|,/g, '');
    let priceFloat = parseFloat(cleanedPrice);

    let dataDetails = {
      _token: $('input[name="_token"]').val(), // CSRF token
      venueId: $('#VenueId').text().trim(),
      name: $('#name').text().trim(),
      checkin: $('#checkin').text().trim(),
      checkout: $('#checkout').text().trim(),
      price: $('#price').text().trim(),
      dayDifference: $('#dayDifference').text().trim(),
      totalPrice: priceFloat
    };
    $.ajax({
      url: '/reservation/add',
      type: 'POST',
      cache: false,
      data: dataDetails,
      beforeSend: function () {
        $('#Details').modal('hide');
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
            $('#paymentOptions').modal('show');
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

// login
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
document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    selectable: true,
    dayMaxEvents: 1,
    moreLinkClick: 'popover',
    eventColor: '#3C0061',
    events: window.reservations,
    eventClick: function (info) {
      alert(`Reservation: ${info.event.title}`);
    }
  });
  calendar.render();
});
