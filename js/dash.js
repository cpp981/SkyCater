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
});