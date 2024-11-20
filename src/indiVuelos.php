<?php
require_once './include/Vuelo.php';
header('Content-Type: application/json');
session_start();

try 
{
    $claseVuelo = new Vuelo(); // Instancia de la clase
    $indicadores = [];
    $indicadores['vuelos_gestionados'] = $claseVuelo->getTotalVuelosGestionados();
    $indicadores['vuelos_sin_gestionar'] = $claseVuelo->getTotalVuelosSinGestionar();

    echo json_encode(['success' => true, 'data' => $indicadores]);

} 
catch (Exception $e) 
{
    echo json_encode(['error' => $e->getMessage()]);
}
