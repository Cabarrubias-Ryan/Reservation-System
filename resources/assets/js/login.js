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
      beforeSend: function () {
        $('.preloader').show();
      },
      success: function (data) {
        $('.preloader').hide();
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
        $('.preloader').hide();
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

$(document).ready(function () {
  // Get the input range and the span element to display the value
  const $rangeInput = $('#formRange2');
  const $rangeValue = $('#rangeValue');

  // Function to update the displayed value
  function updateRangeValue() {
    $rangeValue.text($rangeInput.val());
  }

  // Add event listener to update the value whenever the slider is moved
  $rangeInput.on('input', updateRangeValue);

  // Initialize the value when the page loads
  updateRangeValue();
});
