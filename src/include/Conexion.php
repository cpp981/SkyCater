<?php

require '../vendor/autoload.php'; // Asegúrate de que 'vendor/autoload.php' esté en la ruta correcta

use Dotenv\Dotenv;

class Conexion 
{
    private $host;
    private $db;
    private $user;
    private $pass;
    private $charset;
    private $pdo;

    public function __construct() 
    {
        // Cargamos el archivo .env
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        // Cargamos las variables de entorno desde el archivo .env
        $this->host = $this->getHost(); // Determinamos el host dinámicamente
        $this->db = $_ENV['DB_DATABASE'];
        $this->user = $_ENV['DB_USERNAME'];
        $this->pass = $_ENV['DB_PASSWORD'];
        $this->charset = 'utf8mb4';

        // Intentamos realizar la conexión
        $this->connect();
    }

    // Función para determinar el host según el entorno
    private function getHost() 
    {
        // Si estamos dentro de Docker, el host debe ser "mysql", si estamos en local debe ser "localhost"
        return ($_ENV['APP_ENV'] === 'docker') ? 'mysql' : 'localhost';
    }

    private function connect() 
    {
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try 
        {
            // Construcción del DSN de conexión
            $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        } catch (PDOException $e) 
        {
            // Lanza una excepción más detallada con el mensaje original
            throw new Exception("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    public function getPdo(): PDO 
    {
        return $this->pdo;
    }

    // Destructor para liberar recursos (aunque PDO lo hace automáticamente)
    public function __destruct()
    {
        $this->pdo = null;
    }
}
