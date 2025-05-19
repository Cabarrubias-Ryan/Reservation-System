$(document).ready(function () {
  const reservation = window.reservation;

  if (reservation) {
    const reservationId = reservation.id;
    const venueId = reservation.venues_id;
    const name = reservation.venue.name;
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

    $('#discount').on('change', function () {
      const selectedOption = $(this).find('option:selected');
      const discount = parseFloat(selectedOption.data('discount')) || 0;
      const minAmount = parseFloat(selectedOption.data('min')) || 0;

      if (totalPrice < minAmount) {
        Toastify({
          text: "You didn't reach the minimum spend requirements",
          duration: 3000,
          close: true,
          gravity: 'top',
          position: 'right',
          backgroundColor: 'orange',
          stopOnFocus: true
        }).showToast();
        $(this).val('');
        $('#discountBadge').html('');
        $('#totalPrice').text(totalPriceFormat); // revert if previously discounted
        $('#price').text(PriceFormat); // revert to original price
        $('#priceRaw').val(price);
        $('#totalPriceRaw').val(totalPrice);
        $('#originalPrice').text(``);
        return;
      }

      let discountAmount = 0;
      let discountedTotal = 0;

      discountAmount = (totalPrice * discount) / 100;
      discountedTotal = totalPrice - discountAmount;

      const discountedTotalFormat = new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      }).format(discountedTotal);
      const discountedPrice = price - (price * discount) / 100;
      const discountedPriceFormat = new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      }).format(discountedPrice);

      $('#totalPrice').text(discountedTotalFormat);
      $('#totalPriceRaw').val(discountedTotal);
      $('#originalPrice').text(`Original: ${totalPriceFormat}`);

      // edit the discounter price
      $('#price').text(discountedPriceFormat);
      $('#priceRaw').val(discountedPrice);

      if (discount == 0) {
        $('#discountBadge').html('');
      } else {
        $('#discountBadge').html(`
            <div class="alert alert-success py-1 px-2 mb-0 d-inline-block" style="font-size: 0.875rem;">
              ${discount}% OFF
            </div>
          `);
      }
    });
  }
});
