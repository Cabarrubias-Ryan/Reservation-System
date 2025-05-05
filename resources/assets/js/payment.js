$(document).ready(function () {
  const reservation = window.reservation;
  console.log('Reservation Data:', reservation);
  if (reservation) {
    const venueId = reservation.venue_id;
    const name = reservation.name;
    const price = reservation.venue.price;
    const checkin = new Date(Date.parse(reservation.check_in));
    const checkout = new Date(Date.parse(reservation.check_out));

    const timeDifference = checkout - checkin;
    const dayDifference = timeDifference / (1000 * 3600 * 24); // Convert milliseconds to days
    const totalPrice = dayDifference * price;

    const totalPriceFormat = new Intl.NumberFormat('en-PH', {
      style: 'currency',
      currency: 'PHP',
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    }).format(totalPrice);

    const PriceFormat = new Intl.NumberFormat('en-PH', {
      style: 'currency',
      currency: 'PHP',
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    }).format(price);

    const options = { month: 'long', day: 'numeric', year: 'numeric' };
    const Datecheckin = checkin.toLocaleString('en-PH', options);
    const Datecheckout = checkout.toLocaleString('en-PH', options);

    // Populate fields
    $('#VenueId').val(venueId); // assuming this is an <input type="hidden">
    $('#name').text(name);
    $('#checkin').text(Datecheckin);
    $('#checkout').text(Datecheckout);
    $('#price').text(PriceFormat);
    $('#dayDifference').text(`${dayDifference} day(s)`);
    $('#totalPrice').text(totalPriceFormat);
  }
});
