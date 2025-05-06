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
      const statusBadge =
        data.status == 1
          ? `<span class="badge rounded-pill bg-label-success me-1">Complete</span>`
          : data.status == 0
            ? `<span class="badge rounded-pill bg-label-warning me-1">Pending</span>`
            : data.status == 2
              ? `<span class="badge rounded-pill bg-label-danger me-1">Cancelled</span>`
              : '';
      const view =
        data.status == 1
          ? '<button class="btn btn-primary btn-sm">View</button>'
          : data.status == 0
            ? `<form action="/payment" method="POST" id="paymentForm">
                  <input type="hidden" name="_token" value="${csrfToken}">
                  <input type="hidden" name="id" value="${data.reservation_id}">
                  <button type="submit" class="btn btn-primary btn-sm" id="proceedToPaymentBtn">
                    Payment
                  </button>
                </form>`
            : data.status == 2
              ? '<button class="btn btn-primary btn-sm"> View</button>'
              : '';

      const row = `
        <tr>
          <td>${venueName}</td>
          <td>${checkIn}</td>
          <td>${checkOut}</td>
          <td>₱ ${amount}</td>
          <td>${statusBadge}</td>
          <td>${view}</td>
        </tr>
      `;
      $tbody.append(row);
    });
  }

  // Initial display of all reservations
  displayReservations(allReservations);
});
