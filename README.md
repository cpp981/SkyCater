# SkyCater: Catering Management Application for Airlines

## Descripción

**SkyCater** es una aplicación web diseñada para la gestión del catering de una aerolínea, teniendo en cuenta las intolerancias alimentarias de los pasajeros a bordo de los vuelos. Esta aplicación optimiza la eficiencia en la gestión de comidas y reduce el desperdicio de alimentos.

## Funcionalidades

1. **Gestión de pedidos**: Visualización, creación, y gestión de pedidos de catering.
2. **Catálogo de productos**: Visualización y gestión de productos que pueden ser incluidos en los pedidos.
3. **Dashboard de administración**: Panel de control para mostrar estadísticas mas relevantes.
4. **Gestión de vuelos**: Visualización y control de vuelos así como asignación de comida a los pasajeros.
5. **Interfaz de usuario intuitiva**: Facil curva de aprendizaje.
6. **Autenticación de usuarios**: Sistema de inicio de sesión seguro con validación de usuarios.
7. **Peticiones AJAX**: Implementación de AJAX para interactividad y mejoras en la experiencia de usuario.
9. **Notificaciones y alertas**: Uso de Notyf y SweetAlert para notificaciones y alertas en tiempo real.

## Tecnologías Utilizadas

- **Backend**: PHP 8.1.2, utilizando la estructura de carpetas Modelo-Vista-Controlador (MVC).
- **Base de datos**: MySQL, gestionada a través de PHPMyAdmin.
- **Frontend**: HTML, CSS (Bootstrap 5.1.0), jQuery para la interacción dinámica.
- **Bibliotecas y Frameworks**:
  - **Bootstrap**: Para un diseño moderno y responsive.
  - **jQuery**: Para facilitar la manipulación del DOM y peticiones AJAX.
  - **DataTables**: Para la visualización interactiva de tablas de datos.
  - **SweetAlert**: Para mostrar mensajes emergentes con estilo.
  - **Notyf**: Para notificaciones de éxito y error.
- **Despliegue**: Servidor Apache, configurado para servir la aplicación en Ubuntu. Despliegue en la instancia de AWS EC2.

### Pasos de Instalación

1. **Clona el repositorio**:
    ```bash
    git clone https://github.com/cpp981/SkyCater
    ```

2. **Copia los archivos al directorio de tu servidor web**:
    ```bash
    sudo cp -r SkyCater /var/www/html/
    ```

3. **Configura la base de datos**:
   - Accede a PHPMyAdmin y crea una base de datos llamada `Sky_Cater`.
   - Importa el archivo `.sql` de la base de datos que se encuentra en `/var/www/html/SkyCater/Sql`.

4. **Configura el archivo `.env`**:
   - Crea o edita el archivo `.env` en la raíz del proyecto con las siguientes variables:
     ```env
     APP_ENV=local
     DB_HOST=localhost
     DB_USERNAME=tu-usuario-db
     DB_PASSWORD=tu-contraseña-db
     DB_DATABASE=Sky_Cater
     ```

5. **Asegúrate de que los permisos de los archivos sean correctos**:
   ```bash
   sudo chown -R www-data:www-data /var/www/html/SkyCater
   sudo chmod -R 755 /var/www/html/SkyCater

6. **Accede a la aplicación:**

    Abre tu navegador web y ve a http://'tu-ip'/SkyCater.

##Uso de la Aplicación

Inicio de sesión: Utiliza el sistema de autenticación para iniciar sesión y acceder a las funcionalidades.

Navegación: Utiliza la barra lateral para navegar entre las diferentes secciones de la aplicación.

Interacción: Las acciones como crear pedidos, gestionar productos y asignar vuelos se realizan a través de formularios y botones interactivos.

## Creación de Usuario Manual

La aplicación **SkyCater** ha sido diseñada para ser utilizada exclusivamente por los trabajadores de la aerolínea. El proceso de creación de cuentas de usuario se gestiona a través de un departamento diferente, específicamente en el momento del alta del empleado cuando se formaliza su contrato con la aerolínea. Esto significa que:

- **Los usuarios no se registran directamente desde la aplicación**: No se ha implementado un formulario de registro de usuario en la interfaz de la aplicación porque la creación de cuentas se realiza a nivel interno por el departamento de recursos humanos de la aerolínea, fuera del alcance de la aplicación.

- **Seguridad y control**: Esta metodología de alta de usuarios garantiza que solo los empleados autorizados tengan acceso a la plataforma, manteniendo un control centralizado y seguro sobre quién tiene acceso al sistema.

- **Uso previsto de la aplicación**: La aplicación está pensada para facilitar la gestión de pedidos y operaciones de catering de los vuelos de la aerolínea, por lo que la gestión de usuarios se centra en la autenticación y autorización de empleados ya dados de alta.

Por lo tanto, no se ha incluido un mecanismo de registro en la aplicación, ya que esta tarea es realizada externamente por el departamento encargado de gestionar los recursos humanos de la aerolínea.
Aún así hemos incluido un registro manual que se detalla a continuación:

### Pasos para usar `register.php`:

1. **Accede al archivo `register.php`** en tu servidor o entorno local.
2. **Modifica los parámetros de la llamada al método `registrarUsuario()`** con el nombre y la contraseña deseada. Por ejemplo:
    ```php
    $usuario = new Usuario();
    $usuario->registrarUsuario('nombre', 'pass');
    ```

    - Cambia `'nombre'` por el nombre del usuario que quieras crear.
    - Cambia `'pass'` por la contraseña que desees para el usuario.

3. **Ejecuta el script**. Puedes hacerlo accediendo a la URL correspondiente en tu navegador (ejemplo: `http://localhost/SkyCater/register.php`) o ejecutando el script desde la línea de comandos si estás en un entorno de desarrollo.

4. **Verifica el resultado**. Si el script se ejecuta correctamente, deberías ver el mensaje:
    ```
    Usuario registrado exitosamente.
    ```
   Si hay algún error, el mensaje será:
    ```
    Error al registrar el usuario.
    ```

### Ejemplo de uso:

```php
$usuario = new Usuario();
$usuario->registrarUsuario('admin', 'admin123');
