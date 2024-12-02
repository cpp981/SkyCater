<?php
//Incluir clase Conexion
require_once 'Conexion.php';

class Usuario
{
    private $usuario;
    private $password;
    private $pdo;

    public function __construct($user, $pass)
    {
        $conexion = new Conexion();
        $this->pdo = $conexion->getPdo();
        $this->usuario = $user;
        $this->password = $pass;
    }

    //Comprueba el usuario y password recibidos al crear el objeto
    //True si es correcto, si no False
    public function comprobarCredenciales()
    {
        //Preparar la consulta con parámetros
        $query = "SELECT pass FROM Usuario_Registrado WHERE nombre = ? ";
        try 
        {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(1, $this->usuario);
            $stmt->execute();
            $resul = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($resul && password_verify($this->password, $resul['pass'])) {
                return true;
            } 
            else 
            {
                return false;
            }
        } 
        catch (Exception $e) 
        {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }

    // Obtiene el Id del Usuario conectado
    public function getIdUsuarioByName()
    {
        $query = "SELECT Id_Usuario FROM Usuario_Registrado WHERE Nombre = ?";
        try 
        {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(1, $this->usuario);
            $stmt->execute();
            $resul = $stmt->fetch(PDO::FETCH_ASSOC);
            $id = $resul['Id_Usuario'];
            return $id;
        } 
        catch (Exception $e) 
        {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }

    }

    // Añade un log al Registro de Logs
    public function addLogRegistro($idUser)
    {
        $query = "INSERT INTO Registro_Log (Fecha, Id_Usuario) VALUES (NOW(),?)";
        try 
        {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } 
        catch (Exception $e) 
        {
            throw new Exception(Messages::LOAD_DATA_ERROR);
        }
    }
}