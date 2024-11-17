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

    public function crearPeido($numPedido, $fecha, $coste, $obs, $idProv, $idUser, $nombreProd, $cantidad, $precioUnidad)
    {
        $queryPedido = "INSERT INTO Pedido (Numero_Pedido, Fecha_Pedido, Coste_Total, Observaciones, Id_Proveedor, Id_Usuario, Estado_Pedido) 
                        VALUES (?,NOW(),?,?,?,?,1)";
        //Este idPedido hay que pasarselo a la siguente consulta bindieandolo. En esta debemos bindear el Numero_Pedido de la consulta de arriba.
        $idPedido = "SELECT Id_Pedido FROM Pedido WHERE Numero_Pedido = ?";
        
        $queryProdPedido = "INSERT INTO Pedido_Producto (Nombre_Producto, Cantidad, Precio_Producto, Id_Pedido, Id_Producto) 
                            VALUES (?,?,?,?,?)";
    }

}
