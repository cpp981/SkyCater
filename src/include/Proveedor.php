<?php

require_once 'Conexion.php';
require_once 'Messages.php';

class Proveedor
{
   private $nombreEmpresa;
   private $personaContacto;
   private $tlf;
   private $valoracion;
   private $pdo;
   
   public function __construct()
   {
    $conexion = new Conexion();
    $this->pdo = $conexion->getPdo();
   }

   // Obtener listado de nombres de proveedores
   public function getNombresProveedores()
   {
        $query = "SELECT Nombre_Empresa, Id_Proveedor FROM Proveedor";
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

   // Recupera nombre de producto a partir del Id del proveedor
   public function getProdByIdProveedor($id)
   {
        $query = "SELECT Nombre, Id_Producto, Categoria FROM Producto WHERE Id_Proveedor = ?";
        try
        {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e)
        {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
   }

   // Recupera nombre de proveedor a partir de su Id
   public function getNombreProveedorById($id)
   {
        $query = "SELECT Nombre_Empresa FROM Proveedor WHERE Id_Proveedor = ?";
        try
        {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
        {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
   }
}