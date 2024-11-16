<?php

require 'Conexion.php';

class Pedido
{
    private $numPedido;
    private $fechaPedido;
    private $costeTotal;
    private $observaciones;
    private $proveedor;
    private $usuario;
    private $estadoPedido;
    private $pdo;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->pdo = $conexion->getPdo();
    }

    // Obtiene todos los pedidos de la tabla
    public function getAllPedidos()
    {
        $query = "SELECT * FROM Pedido";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }

}
