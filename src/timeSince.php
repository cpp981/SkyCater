<?php

// Función que obtiene el tiempo que lleva el usuario conectado
function time_since($timestamp) {
    $time_difference = time() - $timestamp;
    
    if ($time_difference < 60) {
        return $time_difference . " segundos";
    } elseif ($time_difference < 3600) {
        return floor($time_difference / 60) . " minutos";
    } elseif ($time_difference < 86400) {
        return floor($time_difference / 3600) . " horas";
    } else {
        return floor($time_difference / 86400) . " días";
    }
}