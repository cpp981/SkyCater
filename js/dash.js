document.addEventListener('DOMContentLoaded', function () {
    //Antes de cerrar la sesión, pide confirmación.
    $('#close').click(function () {
        Swal.fire({
            title: "Estás seguro?",
            text: "Se cerrará tu sesión!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#5cb85c",
            cancelButtonColor: "#d33",
            cancelButtonText: 'Cancelar',
            confirmButtonText: "Aceptar"
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = '../src/cerrar.php';
            }
          });
    });

    //jQuery para menú desplegable
    $('#sidebarToggle').click(function () {
        $('#sidebar').toggle(350, 'linear');
      
    });

    $(document).ready(function() {
      // Detectamos la URL actual de la página
      var currentPath = window.location.pathname;
  
      // Recorremos todos los enlaces del menú
      $('.nav-item .nav-link').each(function() {
          var linkPath = $(this).attr('href');  // Obtenemos el href del enlace
  
          // Si la URL actual coincide con el enlace, agregamos la clase 'active' al item
          if (currentPath.indexOf(linkPath) !== -1) {
              $(this).parent('.nav-item').addClass('active'); // Añadimos 'active' al elemento <li> correspondiente
          }
      });
  
      // Cuando el usuario haga clic en un enlace del menú
      $('.nav-item .nav-link').click(function() {
          // Eliminamos la clase 'active' de todos los elementos
          $('.nav-item').removeClass('active');
  
          // Agregamos la clase 'active' solo al item que fue clickeado
          $(this).parent('.nav-item').addClass('active');
      });
  }); 
});