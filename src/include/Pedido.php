<?php

require_once 'Conexion.php';

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
    // Hay que cambiar la consulta con un JOIN en la tabla Pedido_Producto y Pedido
    public function getAllPedidos()
    {
        $query = "SELECT p.Numero_Pedido, ep.Estado_Pedido, p.Coste_Total, pr.Nombre_Empresa,p.Fecha_Pedido,pp.Fecha_Entrega FROM Pedido p 
                   INNER JOIN Pedido_Producto pp ON p.Id_Pedido = pp.Id_Pedido 
                   INNER JOIN Proveedor pr ON p.Id_Proveedor = pr.Id_Proveedor 
                   INNER JOIN Estado_Pedido ep ON p.Estado_Pedido = ep.Id_Estado_Pedido";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }

    // Función para crear el pedido
    public function crearPedido($numPedido, $fecha, $coste, $obs, $idProv, $idUser, $nombreProd, $cantidad, $precioUnidad, $fechaEntrega, $idProd)
    {
        // Inicia una transacción para asegurar la atomicidad de las operaciones
        $this->pdo->beginTransaction();

        try {
            // Primero hacemos el Insert en la tabla Pedido
            $queryPedido = "INSERT INTO Pedido (Numero_Pedido, Fecha_Pedido, Coste_Total, Observaciones, Id_Proveedor, Id_Usuario, Estado_Pedido) 
                            VALUES (?, ?, ?, ?, ?, ?, 1)";
            $stmtPedido = $this->pdo->prepare($queryPedido);

            // Vinculamos los parámetros en el mismo orden que aparecen en la consulta
            $stmtPedido->bindParam(1, $numPedido, PDO::PARAM_STR);
            $stmtPedido->bindParam(2, $fecha, PDO::PARAM_STR);
            $stmtPedido->bindParam(3, $coste, PDO::PARAM_STR);
            $stmtPedido->bindParam(4, $obs, PDO::PARAM_STR);
            $stmtPedido->bindParam(5, $idProv, PDO::PARAM_INT);
            $stmtPedido->bindParam(6, $idUser, PDO::PARAM_INT);

            // Ejecutamos el primer insert
            $stmtPedido->execute();

            // Obtener el ID del Pedido recién insertado
            $idPedido = $this->pdo->lastInsertId();  // Esto obtiene el último ID insertado en la base de datos (el Id_Pedido)

            // Ahora hacemos el Insert en la tabla Pedido_Producto
            $queryProdPedido = "INSERT INTO Pedido_Producto (Nombre_Producto, Cantidad, Precio_Producto, Fecha_Entrega, Id_Pedido, Id_Producto) 
                                VALUES (?, ?, ?, ?, ?, ?)";
            $stmtProdPedido = $this->pdo->prepare($queryProdPedido);

            // Vinculamos los parámetros en el mismo orden que aparecen en la consulta
            $stmtProdPedido->bindParam(1, $nombreProd, PDO::PARAM_STR);
            $stmtProdPedido->bindParam(2, $cantidad, PDO::PARAM_INT);
            $stmtProdPedido->bindParam(3, $precioUnidad, PDO::PARAM_STR);
            $stmtProdPedido->bindParam(4, $fechaEntrega, PDO::PARAM_STR);
            $stmtProdPedido->bindParam(5, $idPedido, PDO::PARAM_INT);
            $stmtProdPedido->bindParam(6, $idProd, PDO::PARAM_INT);

            // Ejecutamos el segundo insert
            $stmtProdPedido->execute();

            // Si ambos inserts se realizaron correctamente, confirmamos la transacción
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            // Si ocurre algún error, revertimos la transacción
            $this->pdo->rollBack();
            return false;
        }
    }

    // Obtiene el total de pedidos completados
    public function getTotalPedidosCompletados()
    {
        $query = "SELECT COUNT(*) AS 'Completos' FROM Pedido WHERE Estado_Pedido = 2";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }

    // Obtiene el total de pedidos pendientes de entrega
    public function getTotalPedidosPendientes()
    {
        $query = "SELECT COUNT(*) AS 'Pendientes' FROM Pedido WHERE Estado_Pedido = 1";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }
}
