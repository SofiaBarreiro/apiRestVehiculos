<?php

class vehiculo
{


    var $marca;
    var $modelo;
    var $patente;
    var $precio;



    public  function __construct($marca, $modelo, $patente, $precio)
    {

        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->patente = $patente;
        $this->precio = $precio;
    }


    //carga un vehiculo en un archivo txt


    public static function cargarVehiculo($marca, $modelo, $patenteB, $precio)
    {


        $vehiculoTxt = "$marca,$modelo,$patenteB,$precio";
        $myfileTxt = fopen("..\apiRestVehiculos-master\\vehiculo.txt", "r");

        while (!feof($myfileTxt)) {
            $texto = fgets($myfileTxt);
            if ($texto != null) {

                list($marca, $modelo, $patente, $precio) = explode(",", $texto);


                if (strcasecmp($patenteB, $patente) == 0) {
                    var_dump("error, patente cargada");
                    return 0;
                }
                else{
                    var_dump("carga exitosa");
                }
            }
        }

        fclose($myfileTxt);

        $myfileTxt = fopen("..\apiRestVehiculos-master\\vehiculo.txt", "a+");

        fwrite($myfileTxt, $vehiculoTxt . ",\n");

        fclose($myfileTxt);
    }


    //consulta si un dato se encuentra en en el txt y devuelve un array de datos con todas las ocurrencias

    public static function consultarVehiculo($busqueda)
    {
        $nuevo = [];
        $myfileTxt = fopen("..\apiRestVehiculos-master\\vehiculo.txt", "r");


        while (!feof($myfileTxt)) {
            $texto = fgets($myfileTxt);
            if ($texto != null) {
                list($marca, $modelo, $patente, $precio) = explode(",", $texto);


                if ((strcasecmp($marca, $busqueda) == 0) || (strcasecmp($modelo, $busqueda) == 0) || (strcasecmp($patente, $busqueda) == 0)) {


                    $nuevo[] =  array("$marca, $modelo, $patente, $precio");
                }
            }
        }

        fclose($myfileTxt);

        if ($nuevo == null) {
            $nuevo = "no existe $busqueda \n";
        }
        return $nuevo;
    }



    // // - (2pts.) caso: sacarTurno (get): Se recibe 
    // patente y fecha (día) y se debe guardar en el archivo turnos.txt, 
    // fecha, patente, marca, modelo, precio y tipo de servicio. 
    // Si no hay cupo o la materia no existe informar cada caso particular. 
    // // 5


    //arma un nuevo archivo de texto con datos de vehiculo y de servicios, crea un nuevo array y lo guarda en un txt
    public static function sacarTurno($patenteAux, $fecha)
    {

        $vehiculo = vehiculo::getVehiculo($patenteAux);

        $servicio = vehiculo::getServicio($patenteAux);
        $nuevo = [];
        if ($vehiculo != null && $servicio != null) {

            $myfileTxt = fopen("..\apiRestVehiculos-master\\turnos.txt", "a+");


            $nuevo = "$fecha,$vehiculo->patente,$vehiculo->marca,$vehiculo->modelo,$vehiculo->precio,$servicio->tipo";
            var_dump($vehiculo->precio);
            fwrite($myfileTxt, $nuevo . ",\n");

            var_dump($nuevo);
            fclose($myfileTxt);
        }
    }

    //obtiene un vehiculo determinado filtrandolo por patente, devuelve un objeto

    private static function getVehiculo($patenteAux)
    {

        $vehiculoRetorno = null;
        $myfileTxt = fopen("..\apiRestVehiculos-master\\vehiculo.txt", "r");

        while (!feof($myfileTxt)) {
            $texto = fgets($myfileTxt);

            if ($texto != null) {
                list($marca, $modelo, $patente, $precio) = explode(",", $texto);

                if (strcasecmp($patente, $patenteAux) == 0) {
                    //aca hay que arreglar que no me imprima el salto de linea
                    $vehiculoRetorno =  new vehiculo($marca, $modelo, $patente, $precio);
                }
            }
        }

        fclose($myfileTxt);


        return $vehiculoRetorno;
    }


    private static function getServicio($patenteAux)
    {

        //obtiene un servicio determinado filtrandolo por patente, devuelve un objeto
        $servicioRetorno = null;
        $myfileTxt = fopen("..\apiRestVehiculos-masterIA\\tipoServicio.txt", "r");

        while (!feof($myfileTxt)) {
            $texto = fgets($myfileTxt);
            if ($texto != null) {
                list($id, $tipo, $precio, $demora) = explode(",", $texto);


                if ($id == $patenteAux) {
                    $servicioRetorno =  new servicio($id, $tipo, $precio, $demora);
                    // var_dump($servicioRetorno);
                }
            }
        }

        fclose($myfileTxt);

        return $servicioRetorno;
    }

    public static function modificarVehiculo($marca, $modelo, $patenteB, $precio, $imagen)
    {

        $vehiculos= vehiculo::traerVehiculos($patenteB, $marca, $modelo, $precio, $imagen);

        vehiculo::guardarArray($vehiculos);
    }
    //para modificar vehiculos por patente
    //trae todos los vehiculos los cambia con la funcion guardar Foto y 
    //despues llama a guardar array y guarda todo Junto


    public static function traerVehiculos($patenteB, $marcaA, $modeloA, $precioA, $imagenA)
    {
        $vehiculoOk = [];
        $myfileTxt = fopen("..\apiRestVehiculos-masterA\\vehiculo.txt", "r");


        while (!feof($myfileTxt)) {
            $texto = fgets($myfileTxt);

            if ($texto != null) {
                list($marca, $modelo, $patente, $precio, $imagen) = explode(",", $texto);

                if (strcasecmp($patente, $patenteB) == 0) {

                    if (strcmp("\n", $imagen) == 0) {
                        $nuevoPath = vehiculo::GuardarFoto($imagenA);
                        var_dump($nuevoPath);
                        $vehiculoOk[] = array("$marcaA,$modeloA,$patenteB,$precioA,$nuevoPath,");
                        
                    } else {

                        var_dump('guardarfoto vieja');
                        
                        vehiculo::moverFoto($imagenA);
                        // $imagen=vehiculo::cambiarNombre($imagenA);
                        $vehiculoOk[] = array("$marcaA,$modeloA,$patenteB,$precioA,$imagen,");
                    }
                } else {

                    $vehiculoOk[] = array("$marca,$modelo,$patente,$precio,$imagen");
                }
            }
        }
        fclose($myfileTxt);
        return $vehiculoOk;
    }




    public static function guardarArray($array)
    {

        $myfileTxt = fopen("..\apiRestVehiculos-masterA\\vehiculo.txt", "w");
        $longitud = count($array);
        for ($i = 0; $i < $longitud; $i++) {

            var_dump(fwrite($myfileTxt, (implode('\n', $array[$i]))));
        }


        fclose($myfileTxt);
    }


     
    public static function GuardarFoto($file)
    {
        $file1 = $file['name'];
        $temp_name = $file['tmp_name'];
        $destination = '..\apiRestVehiculos-mastera\fotos'.'\\'.$file1;

        move_uploaded_file($temp_name, $destination);

        return $destination;

    }
    public static function moverFoto($file)
    {
        $file1 = $file['name'];
        $temp_name = $file['tmp_name'];
        $destination = '..\apiRestVehiculos-master\backUpFotos'.'\\'.$file1;

        move_uploaded_file($temp_name, $destination);

        return $destination;

    }

    public static function cambiarNombre($file){

        $file1 = $file['name'];
        $nuevoNombre = rename($file1, '..\\apiRestVehiculos-master\\backUpFotos'.'\\'. "nuevaFoto.jpg");
        return $nuevoNombre;

    }





    public static function vehiculos()
    {

        $myfileTxt = fopen("..\apiRestVehiculos-master\\vehiculo.txt", "r");
        echo "<table>";
        echo "<tr><td>MARCA</td><td>MODELO</td><td>PATENTE</td><td>PRECIO</td><td>IMAGEN</td></tr>";

        while (!feof($myfileTxt)) {
            $texto = fgets($myfileTxt);

            if ($texto != null) {

                list($marca, $modelo, $patente, $precio, $foto) = explode(",", $texto);
                if (strcmp($foto, "\n") == 0) {
                    $foto = "sin foto";
                    echo "<tr><td>$marca</td><td>$modelo</td><td>$patente</td><td>$precio</td><td>$foto</td></tr>";
                } else {
                    echo "<tr><td>$marca</td><td>$modelo</td><td>$patente</td><td>$precio</td><td> <img src=$foto></td></tr>";
                }
            }
        }
        echo "</table>";
        fclose($myfileTxt);
    }
}
