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
        $query = "SELECT p.Nombre, p.Apellido, p.Dni, p.Nacionalidad, p.Intolerancias, vp.Preferencias_Comida, vp.Asiento FROM Pasajero p 
                  INNER JOIN Vuelo_Pasajero vp ON p.Id_Pasajero = vp.Id_Pasajero INNER JOIN Vuelo v ON vp.Id_Vuelo = v.Id_Vuelo 
                  WHERE v.Id_Vuelo = ?";
        try{
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(1, $idVuelo);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
        {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }
}