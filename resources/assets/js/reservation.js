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
      return (
        reservation.venue.name.toLowerCase().includes(query) ||
        reservation.firstname.toLowerCase().includes(query) ||
        reservation.lastname.toLowerCase().includes(query)
      );
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

    reservations.forEach(function (data) {
      const fullName = `${data.firstname} ${data.lastname}`;
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

      const row = `
        <tr>
          <td><span>${fullName}</span></td>
          <td>${venueName}</td>
          <td>${checkIn}</td>
          <td>${checkOut}</td>
          <td>₱ ${amount}</td>
          <td>${statusBadge}</td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="ri-more-2-line"></i>
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item Edit" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#EditAccount">
                  <i class="ri-pencil-line me-1"></i> Edit
                </a>
                <a class="dropdown-item DeleteBtn" href="javascript:void(0);">
                  <i class="ri-delete-bin-6-line me-1"></i> Delete
                </a>
              </div>
            </div>
          </td>
        </tr>
      `;
      $tbody.append(row);
    });
  }

  // Initial display of all reservations
  displayReservations(allReservations);
});
