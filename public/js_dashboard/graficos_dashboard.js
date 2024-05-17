/**
* @author Tarsicio Carrizales telecom.com.ve@gmail.com
*/
// CHART PARA LOS Usuario por Rol
jQuery.ajax({
  url: "/users/usuarioRol",
  type: 'GET',
  error: function() {
  },
  dataType: 'json',
  success: function(data) {
    var array_NAME_ROLS = [];
    var array_TOTAL_USERS = [];    
    jQuery.each(data, function(index, value) {      
      array_NAME_ROLS.push(value.NAME_ROLS);
      array_TOTAL_USERS.push(value.TOTAL_USERS);      
    });
    var ctx = document.getElementById('countUserRol').getContext('2d');
    var countUserRol = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: array_NAME_ROLS,
        datasets: [{
          label: 'TOP 10 Usuarios por ROL',
          data: array_TOTAL_USERS,
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(180, 60, 132, 0.2)',
            'rgba(103, 162, 46, 0.2)',
            'rgba(175, 206, 86, 0.2)',
            'rgba(22, 40, 60, 0.2)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(180, 60, 132, 1)',
            'rgba(103, 162, 46, 1)',
            'rgba(175, 206, 86, 1)',
            'rgba(22, 40, 60, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
  },
});

/*
* CHART PARA LAS NOTIFICACIONES POR USUARIOS
*/
jQuery.ajax({
  url: "/users/notificationsUser",
  type: 'GET',
  error: function() {
  },
  dataType: 'json',
  success: function(data) {
    var array_NAME_USER = [];
    var array_TOTAL_NOTIFICATIONS = [];    
    jQuery.each(data, function(index, value) {      
      array_NAME_USER.push(value.USER_NAME);
      array_TOTAL_NOTIFICATIONS.push(value.TOTAL_NOTIFICATIONS);      
    });    
    var ctx = document.getElementById('notificationsUser').getContext('2d');
    var notificationsUser = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: array_NAME_USER,
        datasets: [{
          label: 'TOP 10 Notificaciones por Usuarios',
          data: array_TOTAL_NOTIFICATIONS,
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(180, 60, 132, 0.2)',
            'rgba(103, 162, 46, 0.2)',
            'rgba(175, 206, 86, 0.2)',
            'rgba(22, 40, 60, 0.2)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(180, 60, 132, 1)',
            'rgba(103, 162, 46, 1)',
            'rgba(175, 206, 86, 1)',
            'rgba(22, 40, 60, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
  },
});
// First AJAX request
jQuery.ajax({
  url: "/solicitud/solicitudTipo",
  type: 'GET',
  error: function() {
    // Handle error if needed
  },
  dataType: 'json',
  success: function(data) {
    var array_NAME_USER = [];
    var array_TOTAL_NOTIFICATIONS = [];    
    jQuery.each(data, function(index, value) {      
      array_NAME_USER.push(value.SOLICITUD_NOMBRE);
      array_TOTAL_NOTIFICATIONS.push(value.TOTAL_SOLICITUD);      
    });    
    var ctx = document.getElementById('solicitudTipo').getContext('2d');
    var solicitudTipo = new Chart(ctx, {
      type: 'pie', // Change the type to 'pie'
      data: {
        labels: array_NAME_USER,
        datasets: [{
          label: 'Total de Solicitudes por tipo',
          data: array_TOTAL_NOTIFICATIONS,
          backgroundColor: [ // Include appropriate colors for the pie chart
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            // Add more colors as needed
          ],
          borderColor: [ // Include corresponding border colors
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            // Add more colors as needed
          ],
          borderWidth: 1
        }]
      },
      options: {
        // No need for 'yAxes' configuration in pie charts
      }
    });
  },
});

jQuery.ajax({
  url: "/solicitud/solicitudTotalTipo",
  type: 'GET',
  error: function() {
  },
  dataType: 'json',
  success: function(data) {
    var array_NAME_USER = [];
    var array_TOTAL_NOTIFICATIONS = [];    
    jQuery.each(data, function(index, value) {      
      array_NAME_USER.push("TOTAL SOLICITUDES");
      array_TOTAL_NOTIFICATIONS.push(value.TOTAL_SOLICITUD);      
    });    
    var ctx = document.getElementById('solicitudTotalTipo').getContext('2d');
    var solicitudTipo = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: array_NAME_USER,
        datasets: [{
          label: 'Total de Solicitudes',
          data: array_TOTAL_NOTIFICATIONS,
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(180, 60, 132, 0.2)',
            'rgba(103, 162, 46, 0.2)',
            'rgba(175, 206, 86, 0.2)',
            'rgba(22, 40, 60, 0.2)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(180, 60, 132, 1)',
            'rgba(103, 162, 46, 1)',
            'rgba(175, 206, 86, 1)',
            'rgba(22, 40, 60, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
  },
});