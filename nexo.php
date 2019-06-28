<?php

include_once "..\PP.BARREIRO.SOFIA\\vehiculo.php";
include_once "..\PP.BARREIRO.SOFIA\\servicio.php";



$caso= ($_REQUEST['caso']);
switch ($caso) {
    case (1):
    vehiculo::cargarVehiculo($_POST['marca'], $_POST['modelo'], $_POST['id'],$_POST['precio']);//agregar un nuevo vehicula el archivo txt   
    break;
    case(2):
    $retorno = vehiculo::consultarVehiculo($_GET['busqueda']);//puede buscar por id marca, tipo o modelo
    var_dump($retorno);
    break;
    case(3)://el id es la patente el tipo puede ser 10000,20000 o 50000, la demora es de los dias
    $retorno = servicio::cargarTipoServicio($_POST['id'], $_POST['tipo'], $_POST['precio'], $_POST['demora']);
    break;
    case(4):
    vehiculo::sacarTurno($_POST['id'], $_POST['fecha']);//id es la patente
    break;
    case(5):
    servicio::turnos();//muestra una tabla con los turnos
    case(6):
    servicio::inscripciones($_GET['busqueda']);//busca por tipo o por fecha
    break;
    case(7):
    vehiculo::modificarVehiculo($_POST['marca'], $_POST['modelo'], $_POST['id'], $_POST['precio'], $_FILES['imagen']);
    break;
    case(8):    
    vehiculo::vehiculos(); //devuelve una tabla con los datos del vehichulo
    default:
    break;
}
