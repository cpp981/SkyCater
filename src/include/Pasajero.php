<?php

require_once 'Conexion.php';

class pasajero
{
    private $idPasajero;
    private $nombre;
    private $apellido;
    private $dni;
    private $fechaNacimiento;
    private $intolerancias;
    private $nacionalidad;
    private $pdo;

    //Constructor
    public  function __construct()
    {
        $conexion = new Conexion();
        $this->pdo = $conexion->getPdo();
    }

    // Obtener listado de pasajeros en un vuelo pasado como parámetro(Id_Vuelo)
    public function getPasajerosVueloById($idVuelo)
    {
        $query = "SELECT p.Nombre, p.Apellido, p.Dni, p.Nacionalidad, p.Intolerancias, vp.Preferencias_Comida, vp.Asiento,
                MAX(CASE WHEN producto_orden = 1 THEN nombre_producto END) AS `Plato1`,
                MAX(CASE WHEN producto_orden = 2 THEN nombre_producto END) AS `Plato2`,
                MAX(CASE WHEN producto_orden = 3 THEN nombre_producto END) AS `Plato3`
                FROM Pasajero p INNER JOIN Vuelo_Pasajero vp ON p.Id_Pasajero = vp.Id_Pasajero
                INNER JOIN Vuelo v ON vp.Id_Vuelo = v.Id_Vuelo LEFT JOIN 
                (SELECT ap.Id_Pasajero, pr.Nombre AS nombre_producto,
                ROW_NUMBER() OVER (PARTITION BY ap.Id_Pasajero ORDER BY ap.Id_Producto) AS producto_orden
                FROM AsignacionProductos ap INNER JOIN Producto pr ON ap.Id_Producto = pr.Id_Producto
                WHERE ap.Id_Vuelo = ?) AS productos_ordenados ON p.Id_Pasajero = productos_ordenados.Id_Pasajero
                WHERE v.Id_Vuelo = ? GROUP BY 
                p.Nombre, p.Apellido, p.Dni, p.Nacionalidad, p.Intolerancias, vp.Preferencias_Comida, vp.Asiento;";
        try{
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(1, $idVuelo);
            $stmt->bindParam(2, $idVuelo);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
        {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }

    // Obtener el Id del Pasajero a partir de su DNI
    public function getIdPasajeroByDni($dni)
    {
        $query = "SELECT Id_Pasajero FROM Pasajero WHERE Dni = ?";
        try{
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(1, $dni);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
        {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }
}