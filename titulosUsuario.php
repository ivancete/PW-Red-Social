<?php
require_once ('usuario.php');
require_once ('historia.php');

$historias = Historia::obtenerMisHistorias($_GET["usuario"]);

if(count($historias) > 0) {

    echo "
    <table border='1'>
        <tr>
            <th>Título</th>
        </tr>
        </thead>
        <tbody>";

    for ($i = 0; $i < count($historias); ++$i) {

        $titulo = $historias[$i]->devolverValor("titulo");

        echo "
            <tr>
                <th > $titulo </th >
            </tr >";
    }
    echo "    </tbody>
    </table>";
}
else{
    echo "Este usuario no tiene historias creadas";
}
?>



