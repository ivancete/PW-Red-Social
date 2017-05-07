<?php

require_once ('configuracion.php');

abstract class Mysql{

    protected $datos = array();

    public function __construct( $datos ) {
        foreach ( $datos as $clave => $valor )
            if ( array_key_exists( $clave, $this->datos ) )
                $this->datos[$clave] = $valor;
    }

    public function devolverValor( $campo ) {
        if ( array_key_exists( $campo, $this->datos ) ) {
            return $this->datos[$campo];
        }
        else
            die( "Campo no encontrado" );
    }

    protected static function connect(){

        try{
            $conexion = new PDO( DB_DSN, DB_USUARIO, DB_CONTRASENIA );

            $conexion->setAttribute( PDO::ATTR_PERSISTENT, true );
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

        } catch ( PDOException $e ) {
            die( "Conexión fallida: " . $e->getMessage() );
        }
        return $conexion;
    }

    protected static function desconect($conexion){
        $conexion = "";
    }

}

?>