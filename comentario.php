<?php

require_once ('mysql.php');
require_once ('usuario.php');

class Comentario extends Mysql{

    protected $datos = array("idhistoria" => "",
                                "idcomentario" => "",
                                "descripcion" => "",
                                "usuariocreadorhistoria" => "",
                                "usuariocreadorcomentario" => "",
                                "fecha" => "");

    public static function obtenerComentarios($user, $idhistoria){

        $connect = parent::connect();

        $sql = "SELECT * FROM " .TABLA_COMENTARIOS. " WHERE usuariocreadorhistoria = :user AND idhistoria = :id";

        try {
            $st = $connect->prepare( $sql );

            $st->bindValue( ":user", $user, PDO::PARAM_STR );

            $st->bindValue( ":id", $idhistoria, PDO::PARAM_STR );

            $st->execute();

            //Devuelve las filas correspondientes

            $comentarios = array();

            foreach ( $st->fetchAll() as $fila ) {
                $comentarios[] = new Comentario($fila);
            }

            parent::desconect( $connect );

            if( $comentarios ){

                return $comentarios;
            }

        } catch ( PDOException $e ) {

            parent::desconect( $connect );
            die( "Consulta fallada: " . $e->getMessage() );

        }

    }

    public static function insertarComentario($idhistoria, $userHistoria, $userComentario, $descripcion){
        $connect = parent::connect();

        $sql = "INSERT INTO comentario (idhistoria, descripcion, usuariocreadorhistoria, usuariocreadorcomentario)
                VALUES ($idhistoria , '$descripcion', '$userHistoria', '$userComentario')";

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