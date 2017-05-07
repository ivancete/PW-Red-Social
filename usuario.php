<?php

require_once ('mysql.php');

class Usuario extends Mysql{

    protected $datos = array("usuario" => "", "password" => "", "nombre" => "", "apellidos" => "", "sexo" => "",
        "fotoperfil"=> "");

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

    public static function insertarUsuario($user, $password, $nombre, $apellidos, $sexo){
        $connect = parent::connect();

        $passwordEncrypted = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (usuario, password, nombre, apellidos, sexo) VALUES (
                '$user', '$passwordEncrypted', '$nombre', '$apellidos', '$sexo')";

        try{
            $st = $connect->prepare($sql);

            $st->execute();

            parent::desconect($connect);

        }catch (PDOException $e){

            parent::desconect( $connect );
            die( "Inserción fallada: " . $e->getMessage() );
        }
    }

    public static function devolverAmigos(){

        $connect = parent::connect();

        $sql = "SELECT * FROM " .TABLA_USUARIOS;

        try {
            $st = $connect->prepare( $sql );

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

    public static function devolverHistorias(){

        $connect = parent::connect();

        $sql = "SELECT * FROM " .TABLA_USUARIOS;

        try {
            $st = $connect->prepare( $sql );

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