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

$(document).ready(function () {
  $('body').on('click', '#filterBtn', function () {
    console.log('Filter button clicked');
  });
});
