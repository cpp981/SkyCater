<?php

require_once 'Conexion.php';
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

    // Obtiene los productos
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

    // Inserta un producto
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

    // Recupera el Id de un producto a partir de su nombre
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

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // En caso de error, lanzar una excepción
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }

    // Borra un producto a partir de su Id
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

    // Recupera el Id del proveedor de ese producto a partir del nombre del producto
    public function getIdProveedorByProductName($nombre)
    {
        $query = "SELECT Id_Proveedor FROM Producto WHERE Nombre = ?";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(1, $nombre);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception(Messages::DELETE_DATA_ERROR);
        }
    }

    // Actualiza un producto a partir de su id
    public function updateProductById($n, $cat, $aler, $vn, $desc, $id)
    {
        $query = "UPDATE Producto SET Nombre = ?, Descripcion = ?, Categoria = ?, Alergenos = ?,
                    Fecha_Actualizacion = NOW(), Valor_Nutricional = ? WHERE Id_Producto = ?";

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(1, $n);
            $stmt->bindParam(2, $desc);
            $stmt->bindParam(3, $cat);
            $stmt->bindParam(4, $aler);
            $stmt->bindParam(5, $vn);
            $stmt->bindParam(6, $id);
            $stmt->execute();
            // Comprobar aquí como devolver si el update es correcto o si es erróneo
            // En principio podría ser así, COMPROBAR
            if ($stmt->rowCount() > 0) {
                return true; // Actualizado
            } else {
                return false; // No se encontró la fila 
            }
        } catch (PDOException $e) {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }

    }

    // Recupera los primeros platos
    public function getPrimerosPlatos()
    {
        $primerPlato = 'Primer Plato';
        $entrante = 'Entrante';
        $query = "SELECT Nombre, Alergenos FROM `Producto` WHERE Categoria = ? OR Categoria = ? AND Stock_Disponible >= 1";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(1, $primerPlato);
            $stmt->bindParam(2, $entrante);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }

    // Recupera los segundos platos
    public function getSegundosPlatos()
    {
        $segundoPlato = 'Segundo Plato';
        $query = "SELECT Nombre, Alergenos FROM `Producto` WHERE Categoria = ? AND Stock_Disponible >= 1";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(1, $segundoPlato);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }

    // Recupera las bebidas
    public function getBebidas()
    {
        $bebida = 'Bebida';
        $query = "SELECT Nombre, Alergenos FROM `Producto` WHERE Categoria = ? AND Stock_Disponible >= 1";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(1, $bebida);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }

    // Trata los 3 productos como una operación atómica
    // Es decir, se registran los 3 productos (Primero, Segundo y Bebida) o no se registra ninguno
    // Además, para cada Producto, trata como una operación atómica el insertar el producto y actualizar su stock
    public function asignarProductos($idVuelo, $idPasajero, $productos)
    {
        try {
            // Iniciar la transacción externa
            $this->pdo->beginTransaction();

            // Preparar consultas para el INSERT y el UPDATE
            $sqlInsert = "INSERT INTO AsignacionProductos (Id_Vuelo, Id_Pasajero, Id_Producto) 
                      VALUES (?, ?, ?)";
            $stmtInsert = $this->pdo->prepare($sqlInsert);

            $sqlUpdate = "UPDATE Producto SET Stock_Disponible = Stock_Disponible - 1 WHERE Id_Producto = ?";
            $stmtUpdate = $this->pdo->prepare($sqlUpdate);

            // Enlazar parámetros fijos para el INSERT
            $stmtInsert->bindParam(1, $idVuelo);
            $stmtInsert->bindParam(2, $idPasajero);

            // Procesar cada producto individualmente
            foreach ($productos as $idProducto) {
                // Enlazar el parámetro del producto para el INSERT
                $stmtInsert->bindParam(3, $idProducto);

                // Enlazar el parámetro del producto para el UPDATE
                $stmtUpdate->bindParam(1, $idProducto);

                // Ejecutar el INSERT y el UPDATE
                $stmtInsert->execute();
                $stmtUpdate->execute();
            }

            // Confirmar la transacción externa si todo es exitoso
            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            // Revertir la transacción externa en caso de error
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw new Exception("Error al asignar productos: " . $e->getMessage());
        }
    }

    // Contador categorias de platos
    public function contadorCategoriasProductos()
    {
        $query="SELECT Categoria, COUNT(Categoria) FROM Producto WHERE Categoria = 'Primer Plato' OR Categoria = 'Segundo Plato' OR Categoria = 'Bebida' GROUP BY Categoria ORDER BY Categoria DESC";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }

    // Contador de productos (total)
    public function getTotalProductos()
    {
        $query = "SELECT COUNT(*) AS Platos_Disponibles FROM Producto";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }
}