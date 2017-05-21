<?php

require_once ('mysql.php');

class Usuario extends Mysql{

    protected $datos = array("usuario" => "", "conectado" => "" , "password" => "", "nombre" => "", "apellidos" => "", "sexo" => "",
        "fotoperfil" => "", "telefono" => "" ,"nacimiento" => "");

    public static function obtenerUsuario($user){
        $connect = parent::connect();

        $sql = "SELECT * FROM " .TABLA_USUARIOS. " WHERE usuario = :user";

        try {
            $st = $connect->prepare( $sql );

            //Se cambia el parámetro user por el valor.

            $st->bindValue( ":user", $user, PDO::PARAM_STR );

            $st->execute();

            $fila = $st->fetch();

            parent::desconect( $connect );

            if ( $fila ) {

                $nuevo = new Usuario($fila);

                return $nuevo;
            }

        } catch ( PDOException $e ) {

            parent::desconect( $connect );
            die( "Consulta fallada: " . $e->getMessage() );

        }
    }

    public static function devolverConectados(){

        $connect = parent::connect();

        $sql = "SELECT * FROM " .TABLA_USUARIOS. " WHERE conectado = 1";

        try {
            $st = $connect->prepare( $sql );

            $st->execute();

            //Devuelve las filas correspondientes

            $conectados = array();

            foreach ( $st->fetchAll() as $fila ) {
                $conectados[] = new Usuario($fila);
            }

            parent::desconect( $connect );

            if( $conectados ){

                return $conectados;
            }

        } catch ( PDOException $e ) {

            parent::desconect( $connect );
            die( "Consulta fallada: " . $e->getMessage() );

        }

    }

    public static function modificarAConectado($user){
        $connect = parent::connect();

        $sql = "UPDATE usuario SET conectado = 1 where usuario = '$user' ";

        try{
            $st = $connect->prepare($sql);

            $st->execute();

            parent::desconect($connect);

        }catch (PDOException $e){

            parent::desconect( $connect );
            die( "Actualización fallida: " . $e->getMessage() );
        }
    }

    public static function modificarADesconectado($user){
        $connect = parent::connect();

        $sql = "UPDATE usuario SET conectado = 0 where usuario = '$user' ";

        try{
            $st = $connect->prepare($sql);

            $st->execute();

            parent::desconect($connect);

        }catch (PDOException $e){

            parent::desconect( $connect );
            die( "Actualización fallida: " . $e->getMessage() );
        }
    }

    public static function validarUsuario($user, $otherPassw){
        $connect = parent::connect();

        $sql = "SELECT password FROM " .TABLA_USUARIOS. " WHERE usuario = :usuario";

        try {
            $st = $connect->prepare( $sql );

            //Se cambia el parámetro user por el valor concreto.

            $st->bindValue( ":usuario", $user, PDO::PARAM_STR );

            $st->execute();

            //Devuelve la fila correspondiente

            $passw = $st->fetch();

            parent::desconect( $connect );

            if ( $passw ) {


                if (password_verify($otherPassw, $passw[0])) {
                    return true;
                }
            }

        } catch ( PDOException $e ) {

            parent::desconect( $connect );
            die( "Consulta fallada: " . $e->getMessage() );

        }
    }

    public static function validarCorreo($user){
        $connect = parent::connect();

        $sql = "SELECT usuario FROM " .TABLA_USUARIOS. " WHERE usuario = :usuario";

        try {
            $st = $connect->prepare( $sql );

            //Se cambia el parámetro user por el valor concreto.

            $st->bindValue( ":usuario", $user, PDO::PARAM_STR );

            $st->execute();

            //Devuelve la fila correspondiente

            $usuario = $st->fetch();

            parent::desconect( $connect );

            if($usuario){

                return $usuario;
            }

        } catch ( PDOException $e ) {

            parent::desconect( $connect );
            die( "Consulta fallada: " . $e->getMessage() );

        }
    }

    public static function modificarNombre($user, $nombrenuevo, $apellidonuevo){
        $connect = parent::connect();

        $sql = "UPDATE usuario SET nombre = '$nombrenuevo', apellidos = '$apellidonuevo' where usuario = '$user' ";

        try{
            $st = $connect->prepare($sql);

            $st->execute();

            parent::desconect($connect);

        }catch (PDOException $e){

            parent::desconect( $connect );
            die( "Actualización fallida: " . $e->getMessage() );
        }
    }

    public static function modificarPassword($user, $passwordNuevo){
        $connect = parent::connect();

        $passwordEncrypted = password_hash($passwordNuevo, PASSWORD_DEFAULT);

        $sql = "UPDATE usuario SET password = '$passwordEncrypted' where usuario = '$user' ";

        try{
            $st = $connect->prepare($sql);

            $st->execute();

            parent::desconect($connect);

        }catch (PDOException $e){

            parent::desconect( $connect );
            die( "Actualización fallida: " . $e->getMessage() );
        }
    }

    public static function modificarNacimiento($user, $nacimiento){
        $connect = parent::connect();

        $sql = "UPDATE usuario SET nacimiento = '$nacimiento' where usuario = '$user' ";

        try{
            $st = $connect->prepare($sql);

            $st->execute();

            parent::desconect($connect);

        }catch (PDOException $e){

            parent::desconect( $connect );
            die( "Actualización fallida: " . $e->getMessage() );
        }
    }

    public static function modificarSexo($user, $sexo){
        $connect = parent::connect();

        $sql = "UPDATE usuario SET sexo = '$sexo' where usuario = '$user' ";

        try{
            $st = $connect->prepare($sql);

            $st->execute();

            parent::desconect($connect);

        }catch (PDOException $e){

            parent::desconect( $connect );
            die( "Actualización fallida: " . $e->getMessage() );
        }
    }

    public static function modificarTelefono($user, $telefono){
        $connect = parent::connect();

        $sql = "UPDATE usuario SET telefono = $telefono where usuario = '$user' ";

        try{
            $st = $connect->prepare($sql);

            $st->execute();

            parent::desconect($connect);

        }catch (PDOException $e){

            parent::desconect( $connect );
            die( "Actualización fallida: " . $e->getMessage() );
        }
    }

    public static function insertarUsuario($user, $password, $nombre, $apellidos, $sexo, $telefono ,$nacimiento){
        $connect = parent::connect();

        $passwordEncrypted = password_hash($password, PASSWORD_DEFAULT);

        //Formateamos el formato de la fecha para que no haya problemas con MySQL.
        $nacimiento = date('Y-m-d');

        $sql = "INSERT INTO usuario(usuario, password, nombre, apellidos, sexo, telefono , nacimiento) VALUES (
                '$user', '$passwordEncrypted', '$nombre', '$apellidos', '$sexo', $telefono , '$nacimiento')";

        try{
            $st = $connect->prepare($sql);

            $st->execute();

            parent::desconect($connect);

        }catch (PDOException $e){

            parent::desconect( $connect );
            die( "Inserción fallada: " . $e->getMessage() );
        }
    }

    public static function devolverAmigos($user){

        $connect = parent::connect();

        $sql = "SELECT * FROM " .TABLA_USUARIOS. " WHERE usuario != :user";

        try {
            $st = $connect->prepare( $sql );

            $st->bindValue( ":user", $user, PDO::PARAM_STR );

            $st->execute();

            //Devuelve las filas correspondientes

            $amigos = array();

            foreach ( $st->fetchAll() as $fila ) {
                $amigos[] = new Usuario($fila);
            }

            parent::desconect( $connect );

            if( $amigos ){

                return $amigos;
            }

        } catch ( PDOException $e ) {

            parent::desconect( $connect );
            die( "Consulta fallada: " . $e->getMessage() );

        }

    }
}

?>