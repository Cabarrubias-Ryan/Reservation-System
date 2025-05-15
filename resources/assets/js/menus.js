$(document).ready(function () {
  // Initially hide the venue list
  $('#venuelist').hide();

  // Function to display venues
  function displayVenues(venues) {
    $('#venuelist').empty();

    if (venues.length === 0) {
      // If no venues found, show a "Not Found" message
      $('#venuelist')
        .html(`<div style="padding: 8px 16px; text-align: center; color: #6c757d; margin: 0;">No venues found.</div>`)
        .show();
      return;
    }
    // Loop through the venues and create a list item for each venue
    venues.forEach(function (venue) {
      const venueItem = $(`
        <div style="padding: 8px 16px; margin: 0;">
          <a href="/venue/details/${venue.encrypted_id}" style="text-decoration: none; color: #000;">${venue.name}</a>
        </div>
      `);
      $('#venuelist').append(venueItem);
    });

    // Show the venue list after it's populated with data
    $('#venuelist').show();
  }

  // Listen to the search input for changes
  $('#search').on('input', function () {
    const query = $(this).val().toLowerCase();
    filterVenues(query);
  });

  // Function to filter and display venues based on search term
  function filterVenues(query) {
    const filteredVenues = window.venues.filter(function (venue) {
      return venue.name.toLowerCase().includes(query); // Filter by name
    });
    // Display the filtered venues
    displayVenues(filteredVenues);
  }

  $(document).on('click', function (event) {
    if (!$(event.target).closest('#search, #venuelist').length) {
      $('#venuelist').hide(); // Hide the venue list if clicked outside
    }
  });
});

$(document).ready(function () {
  $('#filterBtn').on('click', function () {
    const checkinDate = $('#start-date').val();
    const checkoutDate = $('#end-date').val();
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
    }
  });
});
