<?php

class conexion{

    private $servidor="localhost";
    private $usuario="root";
    private $contraseña="";
    private $conexion;

    public function __construct(){

        try{
            $this->conexion=new PDO("mysql:host=$this->servidor;dbname=album",$this->usuario,$this->contraseña);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
            return "Falla de conexión".$e;
        }
        
    }

    public function ejecutar($sql){ // Este método funciona para insertar,eliminar y actualizar

        // Se ejecuta la instrucción sql con la función exec
        $this->conexion->exec($sql);
        return $this->conexion->lastInsertId();
    }
    
    public function consultar($sql){
        $sentencia=$this->conexion->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll();
    }

}

?>