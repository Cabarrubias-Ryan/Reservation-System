$(document).ready(function () {
  // Store all reservations in a global variable
  const allReservations = window.reservations;

  // Listen to search input
  $('#search').on('input', function () {
    const query = $(this).val().toLowerCase();
    filterReservations(query);
  });

  // Function to filter reservations by venue name
  function filterReservations(query) {
    const filtered = allReservations.filter(function (reservation) {
      return reservation.venue.name.toLowerCase().includes(query);
    });
    displayReservations(filtered);
  }

  // Function to display filtered reservations in the table
  function displayReservations(reservations) {
    const $tbody = $('#reservationlist');
    $tbody.empty();

    if (reservations.length === 0) {
      $tbody.append(`
        <tr>
          <td colspan="7" class="text-center text-muted">No reservations found.</td>
        </tr>
      `);
      return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    reservations.forEach(function (data) {
      const venueName = data.venue.name;
      const checkIn = data.check_in;
      const checkOut = data.check_out;
      const amount = parseFloat(data.amount).toFixed(2);
      const view = `<form action="/payment/receipt" method="POST" id="paymentForm" target="_blank">
                <input type="hidden" name="_token" value="${csrfToken}">
                <input type="hidden" name="id" value="${data.reservation_id}">

                <!-- Hidden submit button -->
                <button type="submit" style="display: none;"></button>

                <!-- View button, styled as a link -->
                <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="document.getElementById('paymentForm').submit();">
                    View
                </a>
            </form>
            `;

      const row = `
        <tr>
          <td>${data.firstname} ${data.lastname}</td>
          <td>${venueName}</td>
          <td>${checkIn}</td>
          <td>${checkOut}</td>
          <td>₱ ${amount}</td>
          <td>${view}</td>
        </tr>
      `;
      $tbody.append(row);
    });
  }

  // Initial display of all reservations
  displayReservations(allReservations);
});
