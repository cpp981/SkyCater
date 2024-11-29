<?php

require_once 'Conexion.php';
class Vuelo
{
    private $numVuelo;
    private $estado;
    private $pdo;
    //Constructor
    public function __construct()
    {
        $conexion = new Conexion();
        $this->pdo = $conexion->getPdo();
    }

    //Obtener los Vuelos
    public function ObtenerVuelos()
    {
        $query = "SELECT v.Id_Vuelo, v.Numero_Vuelo, vp.Origen, vp.Destino, MAX(vp.Fecha_Salida) AS Fecha_Salida, 
        MAX(vp.Fecha_Llegada) AS Fecha_Llegada, ev.Estado 
        FROM Vuelo v 
        INNER JOIN Vuelo_Pasajero vp ON v.Id_Vuelo = vp.Id_Vuelo 
        INNER JOIN Estado_Vuelo ev ON v.Id_Estado = ev.Id_Estado 
        GROUP BY v.Numero_Vuelo, vp.Origen, vp.Destino, ev.Estado";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }

    // Cuenta los pasajeros que hay en un vuelo
    public function contadorPasajerosVuelo($numVuelo)
    {
        $query = "SELECT COUNT(Id_Pasajero) AS 'Num_Pasajeros' FROM Vuelo_Pasajero AS vp 
                    INNER JOIN Vuelo AS v ON vp.Id_Vuelo = v.Id_Vuelo 
                    WHERE v.Numero_Vuelo = ? ";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(1, $numVuelo);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }

    // Cuenta los pasajeros con intolerancias alimentarias en un vuelo
    public function contadorPasajerosIntolerancias($numVuelo)
    {
        $query = "SELECT COUNT(vp.Id_Pasajero) AS Intolerancias FROM Vuelo_Pasajero AS vp 
                    INNER JOIN Vuelo AS v ON vp.Id_Vuelo = v.Id_Vuelo 
                    INNER JOIN Pasajero AS p ON vp.Id_Pasajero = p.Id_Pasajero 
                    WHERE v.Numero_Vuelo = ? AND p.Intolerancias != 'Ninguna'";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(1, $numVuelo);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }

    // Cuenta el total de vuelos ya gestionados
    public function getTotalVuelosGestionados()
    {
        $query = "SELECT count(*) AS 'Num_Vuelos_Gestionados' FROM Vuelo WHERE Id_Estado = 2";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }

    // Cuenta el total de vuelos sin gestionar
    public function getTotalVuelosSinGestionar()
    {
        $query = "SELECT count(*) AS 'Num_Vuelos_Gestionados' FROM Vuelo WHERE Id_Estado = 1";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }

    // Cuenta el total de pasajeros por Tipo de Asiento en un Vuelo
    public function getCountAsientoById($idVuelo)
    {
        $query = "SELECT Asiento, COUNT(*) AS Cantidad_Pasajeros FROM Vuelo_Pasajero WHERE Id_Vuelo = ?
                  GROUP BY Asiento";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(1, $idVuelo);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }

    }

    // Actualiza el Estado del Vuelo a Gestionado
    public function updateEstadoVueloById($idVuelo)
    {
        $query = "UPDATE Vuelo SET Id_Estado = 2 WHERE Id_Vuelo = ?";
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(1, $idVuelo, PDO::PARAM_INT);
            $stmt->execute();

            // Si al menos una fila fue afectada, la actualización fue exitosa
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }

}