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
        try 
        {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) 
        {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }

    public function insertaProducto($nombre,$descripcion,$categoria,$alergenos,$stockDisponible,$fechaActualizacion,$valorNutricional,$idProv)
    {
        $query = "INSERT INTO Producto (Nombre, Descripcion, Categoria, Alergenos, Stock_Disponible, Fecha_Actualizacion, Valor_Nutricional, Id_Proveedor) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        try {
            // Preparar la consulta SQL
            $stmt = $this->pdo->prepare($query);
            
            // Vincular los parámetros a los valores recibidos
            $stmt->bindParam(1, $nombre);
            $stmt->bindParam(2, $descripcion);
            $stmt->bindParam(3, $categoria);
            $stmt->bindParam(4, $alergenos);
            $stmt->bindParam(5, $stockDisponible);
            $stmt->bindParam(6, $fechaActualizacion);
            $stmt->bindParam(7, $valorNutricional);
            $stmt->bindParam(8, $idProv);

            // Ejecutar la consulta
            $stmt->execute();
            
            // Si todo va bien, se devuelve true
            return true;
        } catch (PDOException $e) {
            // En caso de error, lanzar una excepción
            throw new Exception(Messages::ERROR_INSERT_PRODUCT);
        }
    }
}