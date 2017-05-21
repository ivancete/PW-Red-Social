<?php

require_once ('mysql.php');
require_once ('usuario.php');

class Historia extends Mysql{

    protected $datos = array("idhistoria" => "","descripcion" => "", "titulo" => "", "refimagen" => "",
        "usuario" => "", "fecha" => "");

    public static function obtenerHistoria($user, $identificador){
        $connect = parent::connect();

        $sql = "SELECT * FROM " .TABLA_HISTORIAS. " WHERE usuario = :user AND idhistoria = :id";

        try {
            $st = $connect->prepare( $sql );

            $st->bindValue( ":user", $user, PDO::PARAM_STR );

            $st->bindValue( ":id", $identificador, PDO::PARAM_INT );

            $st->execute();

            //Devuelve las filas correspondientes

            $fila = $st->fetch();

            parent::desconect( $connect );

            if ( $fila ) {

                $nuevo = new Historia($fila);

                return $nuevo;
            }

        } catch ( PDOException $e ) {

            parent::desconect( $connect );
            die( "Consulta fallada: " . $e->getMessage() );

        }
    }

    public static function obtenerMisHistorias($user){
        $connect = parent::connect();

        $sql = "SELECT * FROM " .TABLA_HISTORIAS. " WHERE usuario = :user";

        try {
            $st = $connect->prepare( $sql );

            $st->bindValue( ":user", $user, PDO::PARAM_STR );

            $st->execute();

            //Devuelve las filas correspondientes

            $historias = array();

            foreach ( $st->fetchAll() as $fila ) {
                $historias[] = new Historia($fila);
            }

            parent::desconect( $connect );

            if( $historias ){

                return $historias;
            }

        } catch ( PDOException $e ) {

            parent::desconect( $connect );
            die( "Consulta fallada: " . $e->getMessage() );

        }
    }

    public static function obtenerHistoriasAmigos($user){
        $connect = parent::connect();

        $sql = "SELECT * FROM " .TABLA_HISTORIAS. " WHERE usuario != :user";

        try {
            $st = $connect->prepare( $sql );

            $st->bindValue( ":user", $user, PDO::PARAM_STR );

            $st->execute();

            //Devuelve las filas correspondientes

            $historias = array();

            foreach ( $st->fetchAll() as $fila ) {
                $historias[] = new Historia($fila);
            }

            parent::desconect( $connect );

            if( $historias ){

                return $historias;
            }

        } catch ( PDOException $e ) {

            parent::desconect( $connect );
            die( "Consulta fallada: " . $e->getMessage() );

        }
    }

    public static function obtenerHistoriasAmigosOrdenadas($user, $numerohistoria){
        $connect = parent::connect();

        //Nos devuelve las 9 primeras historias ordenadas por la fecha mas reciente.
        $sql = "SELECT * FROM " .TABLA_HISTORIAS. " WHERE usuario != :user 
                ORDER BY fecha DESC LIMIT ".$numerohistoria. ",9";

        try {
            $st = $connect->prepare( $sql );

            $st->bindValue( ":user", $user, PDO::PARAM_STR );

            $st->execute();

            //Devuelve las filas correspondientes

            $historias = array();

            foreach ( $st->fetchAll() as $fila ) {
                $historias[] = new Historia($fila);
            }

            parent::desconect( $connect );

            if( $historias ){

                return $historias;
            }

        } catch ( PDOException $e ) {

            parent::desconect( $connect );
            die( "Consulta fallada: " . $e->getMessage() );

        }
    }

    public static function obtenerHistoriasMiasOrdenadas($user, $numerohistoria, $numerohistoria2){
        $connect = parent::connect();

        //Nos devuelve las 9 primeras historias ordenadas por la fecha mas reciente.
        $sql = "SELECT * FROM " .TABLA_HISTORIAS. " WHERE usuario = :user 
                ORDER BY fecha DESC LIMIT " .$numerohistoria.",".$numerohistoria2;

        try {
            $st = $connect->prepare( $sql );

            $st->bindValue( ":user", $user, PDO::PARAM_STR );

            $st->execute();

            //Devuelve las filas correspondientes

            $historias = array();

            foreach ( $st->fetchAll() as $fila ) {
                $historias[] = new Historia($fila);
            }

            parent::desconect( $connect );

            if( $historias ){

                return $historias;
            }

        } catch ( PDOException $e ) {

            parent::desconect( $connect );
            die( "Consulta fallada: " . $e->getMessage() );

        }
    }

    public static function insertarHistoria($descripcion, $titulo, $refimagen , $usuario){
        $connect = parent::connect();

        $sql = "INSERT INTO historia (descripcion, titulo, refimagen , usuario) VALUES (
                '$descripcion', '$titulo', '$refimagen' , '$usuario')";

        try{
            $st = $connect->prepare($sql);

            $st->execute();

            parent::desconect($connect);

        }catch (PDOException $e){

            parent::desconect( $connect );
            die( "Inserción fallada: " . $e->getMessage() );
        }
    }
}

?>