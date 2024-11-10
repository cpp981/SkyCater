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
                        timer: 2000 // Redirige después de 2 segundos
                    }).then(() => {
                        window.location.href = '../public/index.php';
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#5cb85c'
                      })
                }
            },
            error: function(response) {
                // Hay que mirar como mostrar aquí el error del BACK.
                if(response.status == 'error')
                {
                    alert(response.message);
                }
            }
            });
        });
    });
        // Modo oscuro/claro
        /*$('#toggle-dark-mode').click(function() {
            $('body').toggleClass('dark-mode');
            $(this).text(function(i, text) {
                return text === "Modo Oscuro" ? "Modo Claro" : "Modo Oscuro";
            });
        });*/




      