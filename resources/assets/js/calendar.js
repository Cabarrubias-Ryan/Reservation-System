document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    selectable: true,
    dayMaxEvents: 1,
    moreLinkClick: 'popover',
    eventColor: '#3C0061', // default color
    events: window.reservations.map(event => {
      const currentDate = new Date();
      const eventStartDate = new Date(event.start);

      if (eventStartDate < currentDate) {
        event.title = 'Complete';
      }
      return event;
    }),
    eventClick: function (info) {
      alert(`Reservation: ${info.event.title}`);
    }
  });
  calendar.render();
});
