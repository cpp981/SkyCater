<?php
//Incluir clase Conexion
require_once 'Conexion.php';

class Usuario{
    private $usuario;
    private $password;
    private $pdo;

    public  function __construct($user,$pass){
        $conexion = new Conexion();
        $this->pdo = $conexion->getPdo();
        $this->usuario = $user;
        $this->password = $pass;
    }

    //Comprueba el usuario y password recibidos al crear el objeto
    //True si es correcto, si no False
    public function comprobarCredenciales(){
        //Preparar la consulta con parámetros para evitar SQLInjection
        $stmt = $this->pdo->prepare("SELECT pass FROM Usuario_Registrado WHERE nombre = ? ");
        $stmt->bindParam(1, $this->usuario);
        $stmt->execute();
        $resul = $stmt->fetch(PDO::FETCH_ASSOC);
        if($resul && password_verify($this->password, $resul['pass'])){
            return true;
        }else{
            return false;
        }
    }
}