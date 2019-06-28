<?php

class servicio
{

    var $id;
    var $tipo;
    var $precio;
    var $demora;


    public function __construct($id, $tipo, $precio, $demora)
    {

        $this->id = $id;
        $this->tipo = $tipo;
        $this->precio = $precio;
        $this->demora = $demora;
    }



    public static function cargarTipoServicio($id, $tipo, $precio, $demora)
    {

        $servicioTxt = "$id,$tipo,$precio,$demora";
        $myfileTxt = fopen("..\PP.BARREIRO.SOFIA\\tipoServicio.txt", "a+");

        if ((strcmp($tipo, "10000") == 0) || (strcmp($tipo, "20000") == 0) || (strcmp($tipo, "50000") == 0)) {


            fwrite($myfileTxt, $servicioTxt . ",\n");
            var_dump("carga exitosa");
        }


        fclose($myfileTxt);
    }


    public static function turnos()
    {
        $myfileTxt = fopen("..\PP.BARREIRO.SOFIA\\turnos.txt", "r");
        echo "<table>";
        echo "<tr><td>FECHA</td><td>PATENTE</td><td>MARCA</td><td>PRECIO</td><td>TIPO</td></tr>";
        while (!feof($myfileTxt)) {
            $texto = fgets($myfileTxt);


            if ($texto != null) {

                list($fecha, $id, $marca, $modelo, $precio, $tipo) = explode(",", $texto);
                echo "<tr><td>$fecha</td><td>$id</td><td>$marca</td><td>$precio</td><td>$tipo</td></tr>";
            }
        }
        echo "</table>";
        fclose($myfileTxt);
    }

    // (2pts.) caso: inscripciones(get): Puede recibir 
    // el tipo de servicio o la fecha y filtra la tabla de acuerdo al parámetro pasado. 

    public static function inscripciones($busqueda){

    $myfileTxt = fopen("..\PP.BARREIRO.SOFIA\\turnos.txt", "r");
    echo "<table>";
    echo "<tr><td>FECHA</td><td>PATENTE</td><td>MARCA</td><td>PRECIO</td><td>TIPO</td></tr>";
    while (!feof($myfileTxt)) {
        $texto = fgets($myfileTxt);


        if ($texto != null) {

            list($fecha, $id, $marca, $modelo, $precio, $tipo) = explode(",", $texto);
            if ((strcmp($tipo, $busqueda) == 0) || (strcmp($fecha, $busqueda) == 0)) {
                echo "<tr><td>$fecha</td><td>$id</td><td>$marca</td><td>$modelo</td><td>$precio</td><td>$tipo</td></tr>";
            }
        }
    }
    echo "</table>";
    fclose($myfileTxt);
    }
}
