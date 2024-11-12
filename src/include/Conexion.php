<?php

// Incluimos autoload de Composer para utilizar la librería vlucas/phpdotenv
// para poder cargar las variables de entorno del fichero .env
require '../vendor/autoload.php';

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
        $dotenv = Dotenv::createImmutable(__DIR__);  // O también dirname(__DIR__) si está en la raíz
        $dotenv->load();

        // Cargamos las variables de entorno desde el archivo .env
        $this->host = $_ENV['DB_HOST'] ?? 'localhost';  // Valor por defecto si no está en .env
        $this->db = $_ENV['DB_DATABASE'] ?? 'test_db';
        $this->user = $_ENV['DB_USERNAME'] ?? 'root';
        $this->pass = $_ENV['DB_PASSWORD'] ?? '';
        $this->charset = 'utf8mb4';

        // Intentamos realizar la conexión
        $this->connect();
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

    public function getPdo() 
    {
        return $this->pdo;
    }

    // Destructor para liberar recursos (aunque PDO lo hace automáticamente)
    public function __destruct()
    {
        $this->pdo = null;
    }
}
