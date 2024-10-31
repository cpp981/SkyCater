$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        var username = $('#username').val();
        var password = $('#password').val();
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: '../src/login2.php',
            data: {
                username: username,
                password: password
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Inicio de sesión exitoso',
                        text: 'Serás redirigido en breve...',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.href = '../public/index.php'; // Redirige después de 3 segundos
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Usuario o contraseña incorrectos',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#5cb85c'
                      })
                }
            },
            error: function() {
                alert(error.message);
            }
        });
    });
});
        // Modo oscuro/claro
        $('#toggle-dark-mode').click(function() {
            $('body').toggleClass('dark-mode');
            $(this).text(function(i, text) {
                return text === "Modo Oscuro" ? "Modo Claro" : "Modo Oscuro";
            });
        });




      