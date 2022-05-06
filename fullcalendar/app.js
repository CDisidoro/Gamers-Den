var myModal = new bootstrap.Modal(document.getElementById('myModal'));
var myModalEvento = new bootstrap.Modal(document.getElementById('myModalEvento'));
var calendar = null;
//let formula = document.getElementById('formulario');
//.format("Y-MM-DD HH:mm:ss")

$('#btnRegistrar').click(function() {
  var isPublic;
  if($('#isPublic').val()) isPublic = 1;
  else isPublic = 0;

  var nuevoEvento = {
    "title" : $('#title').val(),
    "startDate" : moment($('#start').val()).format("Y-MM-DD HH:mm") + ":00",
    "endDate" : moment($('#end').val()).format("Y-MM-DD HH:mm") + ":00",
    "backgroundColor" : $('#color').val(),
    "userid" : $('#userid').val(),
    "isPublic" : isPublic
  };
  
  $.ajax({
    url: "evento.php",
    type: "POST",
    contentType: 'application/json; charset=utf-8',
    dataType: "json",
    data: JSON.stringify(nuevoEvento),
    success: function() {    
      $(document).ready(function() {
        Swal.fire({
            title: "¡Aviso!",
            text: "¡Evento registrado correctamente!",
            icon: 'success',
            timer: 2000,
            button: "Ok",
        });
     });
     calendar.refetchEvents();
    },

    error: function(XMLHttpRequest, textStatus, errorThrown) {
      alert("Algo ha salido mal. Por favor revisa que las fechas sean correctas (start < end)");
    }
  });
  
});

$('#btnEditar').click(function(info) { 
  var nuevoEvento = {
    "title" : $('#titleE').val(),
    "startDate" : moment($('#startE').val()).format("Y-MM-DD HH:mm") + ":00",
    "endDate" : moment($('#endE').val()).format("Y-MM-DD HH:mm")+ ":00", 
    "backgroundColor" : $('#colorE').val(),
    "id" : $('#id').val(),
    "userid" : $('#userid').val()
  };
  
  $.ajax({
    url: "evento.php",
    type: "POST",
    contentType: 'application/json; charset=utf-8',
    dataType: "json",
    data: JSON.stringify(nuevoEvento),
    success: function() { 
      $(document).ready(function() {
        Swal.fire({
            title: "¡Aviso!",
            text: "¡Evento editado correctamente!",
            icon: 'success',
            timer: 2000,
            button: "Ok",
        });
     });
     calendar.refetchEvents();
    },

    error: function(XMLHttpRequest, textStatus, errorThrown) {
      alert("Algo ha salido mal. Por favor revisa que las fechas sean correctas (start < end)");
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
        calendar.refetchEvents();
        $(document).ready(function() {
          Swal.fire({
              title: "¡Aviso!",
              text: "¡Evento borrado correctamente!",
              icon: 'success',
              timer: 2000,
              button: "Ok",
          });
       });
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
        $('#start').val(moment(info.dateStr).format("Y-MM-DDTHH:mm"));
        //En el caso de que se seleccione para insertar un nuevo evento, no mostrar el boton de eliminar
        //document.getElementById('#btnEliminar').classList.add('d-none');
        myModal.show();
      },

      eventClick: function(info) {
        var event = info.event;
        $('#startE').val(moment(event.start).format("Y-MM-DDTHH:mm"));
        $('#titleE').val(event.title);
        $('#endE').val(moment(event.end).format("Y-MM-DDTHH:mm"));
        $('#colorE').val(event.backgroundColor);
        $('#id').val(event.id);

        if($('#userid').val() != event.extendedProps.userid){
          $('#btnEliminar').hide();
          $('#btnEditar').hide();
        }
        else{
          $('#btnEliminar').show();
          $('#btnEditar').show();
        }

        myModalEvento.show();   
      },

      editable: true,
        // Ejecutado al cambiar la duración del evento arrastrando
        eventResize: function(info) {
          if(info.event.extendedProps.userid == $('#userid').val()){
            var event = info.event;
            var e = {
              "id": event.id,
              "startDate": moment(event.start).format("Y-MM-DD HH:mm")+ ":00",
              "endDate": moment(event.end).format("Y-MM-DD HH:mm")+ ":00",
              "title": event.title,
              "userid" : event.userid
            };
            
            $.ajax({
              url: "evento.php",
              type: "POST",
              contentType: 'application/json; charset=utf-8',
              dataType: "json",
              data: JSON.stringify(e),
              success: function() {
                calendar.refetchEvents();
                $(document).ready(function() {
                  Swal.fire({
                      title: "¡Aviso!",
                      text: "¡Evento actualizado correctamente!",
                      icon: 'success',
                      timer: 2000,
                      button: "Ok",
                  });
              });
              },
          
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus);
                alert("Error: " + errorThrown);
              }
            });
          }
          else{
            $(document).ready(function() {
              Swal.fire({
                  title: "¡Aviso!",
                  text: "¡No puedes actualizar este evento!",
                  icon: 'error',
                  timer: 2000,
                  button: "Ok",
              });
           });
           calendar.refetchEvents();
          }
        },       

      eventDrop: function(info) {
        if(info.event.extendedProps.userid == $('#userid').val()){
          var event = info.event;
          var e = {
            "id": event.id,
            "startDate": moment(event.start).format("Y-MM-DD HH:mm")+ ":00",
            "endDate": moment(event.end).format("Y-MM-DD HH:mm")+ ":00",
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
            $(document).ready(function() {
              Swal.fire({
                  title: "¡Aviso!",
                  text: "¡Evento actualizado correctamente!",
                  icon: 'success',
                  timer: 2000,
                  button: "Ok",
              });
           });
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Status: " + textStatus);
            alert("Error: " + errorThrown);
          }
        });
        }      
        else{        
          $(document).ready(function() {
            Swal.fire({
                title: "¡Aviso!",
                text: "¡No puedes actualizar este evento!",
                icon: 'error',
                timer: 2000,
                button: "Ok",
            });
         });
         calendar.refetchEvents();
        }
      },
      events: 'evento.php'
    });
    calendar.render();
});