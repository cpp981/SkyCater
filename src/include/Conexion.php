<?php
// Incluimos autoload de Composer para utilizar la libreria vlucas/phpdotenv
// para poder cargar las variables de entorno del fichero .env
require '../vendor/autoload.php';

use Dotenv\Dotenv;

class Conexion {
    private $host;
    private $db;
    private $user;
    private $pass;
    private $charset;
    private $pdo;

    public function __construct() {
        $dotenv = Dotenv::createImmutable(dirname(  __DIR__));
        $dotenv->load();

        $this->host = $_ENV['DB_HOST'];
        $this->db = $_ENV['DB_DATABASE'];
        $this->user = $_ENV['DB_USERNAME'];
        $this->pass = $_ENV['DB_PASSWORD'];
        $this->charset = 'utf8mb4';

        $this->connect();
    }

    private function connect() {
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
            $this->pdo = new PDO($dsn, $this->user, $this->pass,$options);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        } catch (PDOException $e) {
            die(Messages::CONNECTION_FAILED);
        }
    }

    public function getPdo() {
        return $this->pdo;
    }
}
