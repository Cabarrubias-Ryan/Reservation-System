// calendar

document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    selectable: true,
    dayMaxEvents: 1,
    moreLinkClick: 'popover',
    eventColor: '#3C0061',
    events: window.reservations,
    eventClick: function (info) {
      alert(`Reservation: ${info.event.title}`);
    }
  });
  calendar.render();
});
