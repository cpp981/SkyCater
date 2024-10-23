<?php

require_once 'Conexion.php';
class Vuelo {
    private $numVuelo;
    private $estado;
    private $pdo;
    //Constructor
    public  function __construct(){
        $conexion = new Conexion();
        $this->pdo = $conexion->getPdo();
    }

    //Obtener los Vuelo
    public function ObtenerVuelos(){
        $query = "SELECT v.Numero_Vuelo, vp.Origen, vp.Destino, MAX(vp.Fecha_Salida) AS Fecha_Salida, 
        MAX(vp.Fecha_Llegada) AS Fecha_Llegada, ev.Estado 
        FROM Vuelo v 
        INNER JOIN Vuelo_Pasajero vp ON v.Id_Vuelo = vp.Id_Vuelo 
        INNER JOIN Estado_Vuelo ev ON v.Id_Estado = ev.Id_Estado 
        GROUP BY v.Numero_Vuelo, vp.Origen, vp.Destino, ev.Estado";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}