var myModal = new bootstrap.Modal(document.getElementById('myModal'));
var myModalEvento = new bootstrap.Modal(document.getElementById('myModalEvento'));
var calendar = null;
//let formula = document.getElementById('formulario');
//.format("Y-MM-DD HH:mm:ss")
$('#btnRegistrar').click(function() {
  var nuevoEvento = {
    "title" : $('#title').val(),
    "startDate" : $('#start').val() + " 00:00:00",
    "endDate" : $('#end').val() + " 23:59:59",
    "backgroundColor" : $('#color').val(),
    "userid" : $('#userid').val()
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
    },

    error: function(XMLHttpRequest, textStatus, errorThrown) {
      alert("Status: " + textStatus);
      alert("Error: " + errorThrown);
    }
  });
  
});

$('#btnEditar').click(function(info) {
  var nuevoEvento = {
    "title" : $('#titleE').val(),
    "startDate" : $('#startE').val() + " 00:00:00",
    "endDate" : $('#endE').val() + " 23:59:59", //el evento dura todo el día 
    "backgroundColor" : $('#colorE').val(),
    "id" : $('#id').val()
  };
  
  $.ajax({
    url: "evento.php",
    type: "POST",
    contentType: 'application/json; charset=utf-8',
    dataType: "json",
    data: JSON.stringify(nuevoEvento),
    success: function() {
      calendar.refetchEvents();
      alert('Evento editado');
    },

    error: function(XMLHttpRequest, textStatus, errorThrown) {
      alert("Status: " + textStatus);
      alert("Error: " + errorThrown);
    }
  });
  
});

$('#btnEliminar').click(function(info) {
  if (confirm("¿Seguro que desea eliminar el evento? Esta acción no se puede deshacer")) {
    var id = $('#id').val();

    $.ajax({
      url: "evento.php?idEvento=" + id,
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      type: "DELETE",
      success: function() {
        //location.reload(); //hace que se recargue la página, no sé si estará del todo bien
        calendar.refetchEvents();
        alert('Evento eliminado');
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        alert("Status: " + textStatus);
        alert("Error: " + errorThrown);
      }
    })
  }
  
});

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'es',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },

      selectable: true,
      editable: true,
      
      dateClick: function(info) {
        $('#start').val(info.dateStr);
        //En el caso de que se seleccione para insertar un nuevo evento, no mostrar el boton de eliminar
        //document.getElementById('#btnEliminar').classList.add('d-none');
        myModal.show();
      },

      eventClick: function(info) {
        //document.getElementById('btnEliminar').classList.remove('d-none');
        //document.getElementById('btnRegistrar').textContent = 'Modificar';
        var event = info.event;
        $('#startE').val(moment(event.start).format("YYYY-MM-DD"));
        $('#titleE').val(event.title);
        $('#endE').val(moment(event.end).format("YYYY-MM-DD"));
        $('#colorE').val(event.backgroundColor);
        $('#id').val(event.id);
        $('#useridE').val(event.userid);
        myModalEvento.show();   
      },
      eventDrop: function(info) {
        var event = info.event;
          var e = {
            "id": event.id,
            "startDate": moment(event.start).format("YYYY-MM-DD HH:mm:ss"),
            "endDate": moment(event.end).format("YYYY-MM-DD HH:mm:ss"),
            "title": event.title,
            "userid" : event.userid
          };

        $.ajax({
          url: "evento.php?idEvento=" + event.id,
          contentType: 'application/json; charset=utf-8',
          dataType: "json",
          type: "PUT",
          data: JSON.stringify(e),
          success: function() {
            calendar.refetchEvents();
            alert('Evento actualizado');
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Status: " + textStatus);
            alert("Error: " + errorThrown);
          }
        });
      },
      events: 'evento.php'
    });
    calendar.render();
});