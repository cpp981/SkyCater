<?php

require 'Conexion.php';
class Producto
{
    private $nombre;
    private $descripcion;
    private $categoria;
    private $alergenos;
    private $Stock;
    private $fecha_lastUpdate;
    private $valor_nutricional;
    private $pdo;
    //Constructor
    public function __construct()
    {
        $conexion = new Conexion();
        $this->pdo = $conexion->getPdo();
    }

    public function ObtenerProductos()
    {
        $query = "SELECT Nombre,Categoria,Alergenos,Stock_Disponible,Fecha_Actualizacion,Valor_Nutricional,Descripcion
                    FROM Producto";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Error: ' . Messages::INTERNAL_ERROR);
        }
    }

}