<?php

require_once ('mysql.php');
require_once ('usuario.php');

class Historia extends Mysql{

    protected $datos = array("id" => "", "descripcion" => "", "titulo" => "", "refimagen" => "",
        "usuario" => "", "fecha" => "");

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