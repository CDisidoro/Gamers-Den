var myModal = new bootstrap.Modal(document.getElementById('myModal'));
let formula = document.getElementById('formulario');

$('#btnRegistrar').click(function() {
  var nuevoEvento = {
    title:$('#title').val(),
    startDate:$('#start').val().format("Y-MM-DD HH:mm:ss"),
    endDate:$('#end').val().format("Y-MM-DD HH:mm:ss"),
    backgroundColor:$('#color').val()
  };
  
  $.ajax({
    url: "evento.php",
    type: "POST",
    contentType: 'application/json; charset=utf-8',
    dataType: "json",
    data: JSON.stringify(nuevoEvento),
    success: function() {
      calendar.refetchEvents();
      alert('Evento añadido');
    }
  })
});

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

      selectable: true,
      
      dateClick: function(info) {
        $('#start').val(info.dateStr);
        myModal.show();
      },
      events: 'evento.php'
    });
    calendar.render();
});