var myModal = new bootstrap.Modal(document.getElementById('myModal'));
let formula = document.getElementById('formulario');
document.addEventListener('DOMContentLoaded', function() {  
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    selectable: true,
    headerToolBar:{
        start: 'prev, next today',
        center: 'title',
        end: 'dayGridMonth, timeGridWeek, timeGridDay'
    },
    dateClick: function(info) {
        
       //alert('Date: ' + info.dateStr);
       //document.getElementById('start').value = info.dateStr;
       myModal.show();
    }
    });
    calendar.render();

    formula.addEventListener('btnAccion',function(e){
        e.preventDefault();
    });
});