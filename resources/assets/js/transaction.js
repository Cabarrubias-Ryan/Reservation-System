$(document).ready(function () {
  // Store all reservations in a global variable
  const allReservations = window.payments;

  // Listen to search input
  $('#search').on('input', function () {
    const query = $(this).val().toLowerCase();
    filterReservations(query);
  });

  // Function to filter reservations by venue name
  function filterReservations(query) {
    const filtered = allReservations.filter(function (payments) {
      return payments.firstname.toLowerCase().includes(query) || payments.lastname.toLowerCase().includes(query);
    });
    displayReservations(filtered);
  }

  // Function to display filtered reservations in the table
  function displayReservations(payments) {
    const $tbody = $('#transactionlist');
    $tbody.empty();

    if (payments.length === 0) {
      $tbody.append(`
        <tr>
          <td colspan="6" class="text-center text-muted">No reservations found.</td>
        </tr>
      `);
      return;
    }

    payments.forEach(function (data) {
      const fullName = `${data.firstname} ${data.lastname}`;
      const amount = parseFloat(data.amount).toFixed(2);

      const dateObj = new Date(data.created_at);

      // Format the date to 'DD MMM YYYY' (you can change the format as needed)
      const formattedDate = dateObj.toLocaleDateString('en-GB', {
        // 'en-GB' gives DD/MM/YYYY format
        weekday: 'short', // Optional: Adds day of the week
        day: '2-digit',
        month: 'short',
        year: 'numeric'
      });
      const statusBadge = `<span class="badge rounded-pill bg-label-success me-1">Complete</span>`;

      const row = `
        <tr>
          <td><span>${fullName}</span></td>
          <td>Stripe</td>
          <td>₱ ${amount}</td>
          <td>${formattedDate}</td>
          <td>${statusBadge}</td>
      `;
      $tbody.append(row);
    });
  }

  // Initial display of all reservations
  displayReservations(allReservations);
});
