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
        $query = "SELECT p.Numero_Pedido, ep.Estado_Pedido, pp.Nombre_Producto, p.Coste_Total, pr.Nombre_Empresa,p.Fecha_Pedido,pp.Fecha_Entrega FROM Pedido p 
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

    // Cambia el estado del Pedido a Cancelado
    public function cancelPedidoByNumPedido($numPedido)
    {
        $query = "UPDATE Pedido SET Estado_Pedido = 3 WHERE Numero_Pedido = ?";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(1, $numPedido);

            // Ejecuta la consulta y verifica si se afectaron filas
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Si ocurre un error, devuelve el mensaje de error
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }

    // Obtiene los detalles de un pedido a partir de su numero
    public function getDetallesPedidoByNumPedido($numPedido)
    {
        $query = "SELECT p.Numero_Pedido, ep.Estado_Pedido, pp.Nombre_Producto, pp.Cantidad, pp.Precio_Producto, p.Coste_Total, pr.Nombre_Empresa,p.Fecha_Pedido,pp.Fecha_Entrega FROM Pedido p 
                   INNER JOIN Pedido_Producto pp ON p.Id_Pedido = pp.Id_Pedido 
                   INNER JOIN Proveedor pr ON p.Id_Proveedor = pr.Id_Proveedor 
                   INNER JOIN Estado_Pedido ep ON p.Estado_Pedido = ep.Id_Estado_Pedido
				   WHERE p.Numero_Pedido = ?";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(1, $numPedido);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }
    // Método para actualizar el stock de un producto
    private function actualizarStock($productoId, $cantidad)
    {
        $query = "
                UPDATE Producto 
                SET Stock_Disponible = Stock_Disponible + ? 
                WHERE Id_Producto = ?
            ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(1, $cantidad);
        $stmt->bindParam(2, $productoId);
        if ($stmt->execute()) {
            error_log("Stock actualizado para producto ID $productoId, cantidad añadida: $cantidad");
        } else {
            // Log si hubo algún error
            $errorInfo = $stmt->errorInfo();
            error_log("Error al actualizar el stock para producto ID $productoId. Error: " . implode(", ", $errorInfo));
        }

    }

    // Método para cambiar el estado de un pedido a 'Entregado'
    private function cambiarEstadoPedido($pedidoId)
    {
        $query = "
                UPDATE Pedido 
                SET Estado_Pedido = 2  -- Estado 'Entregado'
                WHERE Id_Pedido = ? ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(1, $pedidoId);
        $stmt->execute();
    }

    // Método para actualizar el stock y el estado de los pedidos pendientes
    public function actualizarPedidosPendientes()
    {
        // Consulta para obtener los pedidos cuya fecha de entrega ha pasado y están en estado 'Pendiente'
        $query = "
             SELECT p.Id_Pedido, pp.Id_Producto, pp.Cantidad
             FROM Pedido p
             INNER JOIN Pedido_Producto pp ON p.Id_Pedido = pp.Id_Pedido
             WHERE pp.Fecha_Entrega <= NOW()
             AND p.Estado_Pedido = 1";

        // Preparamos la consulta
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        // Verificar si hay pedidos pendientes para actualizar
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            // Iniciar la transacción
            $this->pdo->beginTransaction();

            try {
                foreach ($result as $row) {
                    // Actualizar el stock del producto
                    $this->actualizarStock($row['Id_Producto'], $row['Cantidad']);

                    // Cambiar el estado del pedido a 'Entregado'
                    $this->cambiarEstadoPedido($row['Id_Pedido']);
                }

                // Si todo salió bien, hacemos commit
                $this->pdo->commit();
                echo "Pedidos actualizados correctamente.";

            } catch (Exception $e) {
                // Si algo falla, hacemos rollback
                $this->pdo->rollBack();
                echo "Error al actualizar pedidos: " . $e->getMessage();
            }
        } else {
            echo "No hay pedidos pendientes para actualizar.";
        }
    }

    // Cuenta los pedidos por mes
    public function contadorPedidosPorMes()
    {
        $query = "SELECT DATE_FORMAT(fecha_pedido, '%Y-%m') AS mes, 
                  COUNT(*) AS total_pedidos FROM Pedido GROUP BY mes
                  ORDER BY mes";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }

    // Borra los pedidos Cancelados
    public function borraPedidosCancelados()
    {
        try {
                        
            // Consulta para obtener los Id_Pedido de los pedidos cancelados con fecha de entrega pasada
            $query = "
            SELECT p.Id_Pedido
            FROM Pedido p
            INNER JOIN Pedido_Producto pp ON p.Id_Pedido = pp.Id_Pedido
            WHERE pp.Fecha_Entrega <= NOW()
            AND p.Estado_Pedido = 3
        ";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($pedidos) {
                // Dividir los pedidos en lotes pequeños para evitar grandes consultas
                $pedidosPorLote = 1000;
                $totalPedidos = count($pedidos);
                $pedidosBorrados = 0;

                for ($i = 0; $i < $totalPedidos; $i += $pedidosPorLote) {
                    // Obtener un lote de pedidos
                    $lote = array_slice($pedidos, $i, $pedidosPorLote);
                    $idsPedidos = array_column($lote, 'Id_Pedido');

                    // Eliminar los pedidos en un solo DELETE por lote
                    $deletePedidoQuery = "
                    DELETE FROM Pedido
                    WHERE Estado_Pedido = 3 AND Id_Pedido IN (" . implode(',', array_map('intval', $idsPedidos)) . ")
                ";
                    $deletePedidoStmt = $this->pdo->prepare($deletePedidoQuery);
                    $deletePedidoStmt->execute();

                    // Contabilizar los pedidos eliminados
                    $pedidosBorrados += count($idsPedidos);
                }

                echo "Se han eliminado $pedidosBorrados pedidos cancelados correctamente.";
            } else {
                echo "No hay pedidos cancelados para eliminar.";
            }
        } catch (Exception $e) {
            echo "Error al obtener los pedidos: " . $e->getMessage();
        }
    }
}
