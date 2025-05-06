$(document).ready(function () {
  const reservation = window.reservation;
  console.log('Reservation Data:', reservation);
  if (reservation) {
    const reservationId = reservation.id;
    const venueId = reservation.venues_id;
    const name = reservation.venue.name;
    const price = reservation.venue.price;
    const checkin = new Date(Date.parse(reservation.check_in));
    const checkout = new Date(Date.parse(reservation.check_out));
    console.log(venueId);
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
    $('#reservationId').val(reservationId); // assuming this is an <input type="hidden">
    $('#VenueId').val(venueId); // assuming this is an <input type="hidden">
    $('#priceRaw').val(price); // assuming this is an <input type="hidden">
    $('#dayDifferenceRaw').val(dayDifference); // assuming this is an <input type="hidden">
    $('#totalPriceRaw').val(totalPrice); // assuming this is an <input type="hidden">
    $('#checkinRaw').val(Datecheckin);
    $('#checkoutRaw').val(Datecheckout);
    $('#venueName').val(name);
    $('#name').text(name);
    $('#checkin').text(Datecheckin);
    $('#checkout').text(Datecheckout);
    $('#price').text(PriceFormat);
    $('#dayDifference').text(`${dayDifference} day(s)`);
    $('#totalPrice').text(totalPriceFormat);
  }
});
