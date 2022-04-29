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
     events: 'evento.php'
    });
    calendar.render();
});