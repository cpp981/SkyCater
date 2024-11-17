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
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }

    public function insertaProducto($nombre, $descripcion, $categoria, $alergenos, $stockDisponible, $fechaActualizacion, $valorNutricional, $idProv)
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

    public function getIdProductoByName($nombre)
    {
        $query = "SELECT Id_Producto FROM Producto WHERE Nombre = ?";
        try {
            // Preparar la consulta SQL
            $stmt = $this->pdo->prepare($query);

            // Vincular los parámetros a los valores recibidos
            $stmt->bindParam(1, $nombre);

            // Ejecutar la consulta
            $stmt->execute();

            // Si todo va bien, se devuelve true
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // En caso de error, lanzar una excepción
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }

    public function borraProductoById($id)
    {
        $query = "DELETE FROM Producto WHERE Id_Producto = ?";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            // Comprobamos si se ha eliminado alguna fila
            if ($stmt->rowCount() > 0) {
                return true; // Borrado exitoso
            } else {
                return false; // No se encontró la fila o no se borró
            }
        } catch (PDOException $e) {
            throw new Exception(Messages::DELETE_DATA_ERROR);
        }
    }
}