<?php
require_once ('usuario.php');
require_once ('historia.php');

$historias = Historia::obtenerMisHistorias($_GET["usuario"]);

if(count($historias) > 0) {

    echo "
    <html>
    <head>
    <meta charset='utf-8'/>
    <link rel='stylesheet'  href='diseno.css'/>
    <title>Títulos de Entradas</title>
    </head>
    <body>
    <table class='tablaTitulos'>
        <thead>
            <tr>
                <th>Títulos</th>
            </tr>
        </thead>
        <tbody border='1'>";

            for ($i = 0; $i < count($historias); ++$i) {

                $titulo = $historias[$i]->devolverValor("titulo");

                echo "
                    <tr>
                        <th> $titulo </th >
                    </tr >";
            }
    echo "</tbody>
    </table>
    </body>
    </html>";
}
else{
    echo "Este usuario no tiene historias creadas";
}
?>



