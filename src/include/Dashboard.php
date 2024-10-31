<?php
require_once 'Conexion.php';
require_once 'Messages.php';
class Dashboard{
    private $pdo;
    //Constructor
    public  function __construct(){
        $conexion = new Conexion();
        $this->pdo = $conexion->getPdo();
    }

    public function ObtenerProductos(){
        $query = "SELECT Nombre,Descripcion,Categoria,Alergenos,Stock_Disponible,Fecha_Actualizacion,Valor_Nutricional
                    FROM Producto";
        try{
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            die('Error: ' . Messages::INTERNAL_ERROR);
        }
    }
    // Métodos
    public function ContadorPrimeraClase(){
        $query = "SELECT count(*) FROM Vuelo_Pasajero WHERE Asiento = 'Primera Clase' OR Asiento = 'Bussiness' OR Asiento = 'Económica' GROUP BY Asiento ORDER BY Asiento DESC";
        try{
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
        }catch(PDOException $e){
            die('Error: ' . Messages::INTERNAL_ERROR);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function PersonasConIntolerancias(){
        $query = "SELECT count(*) FROM Pasajero WHERE Intolerancias != 'Ninguna'";
        try{
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();    
        }catch(PDOException $e){
            die('Error: ' . Messages::INTERNAL_ERROR);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}