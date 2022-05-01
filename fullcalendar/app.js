var myModal = new bootstrap.Modal(document.getElementById('myModal'));
let formula = document.getElementById('formulario');
/*
$('btnRegistrar').click(function() {
  var nuevoEvento = {
    title:$('title').val(),
    start:$('start').val(),
    end:$('end').val()
  };

  calendar.addEvent(nuevoEvento);
  myModal.show('toggle');
});
*/
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