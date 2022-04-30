var myModal = new bootstrap.Modal(document.getElementById('myModal'));
let formula = document.getElementById('formulario');

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'es',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      dateClick: function(info) {
        myModal.show();
      },
      events: [
        { // this object will be "parsed" into an Event Object
          title: 'The Title', // a property!
          start: '2022-04-27', // a property!
          end: '2022-04-28' // a property! ** see important note below about 'end' **
        }
      ]
    });
    calendar.render();
});