<?php
include '../modelo/Producto.php';
$producto=new Producto();

if($_POST['funcion']=='crear'){
    $nombre=$_POST['nombre'];
    $concentracion=$_POST['concentracion'];
    $adicional=$_POST['adicional'];
    $precio=$_POST['precio'];
    $laboratorio=$_POST['laboratorio'];
    $tipo=$_POST['tipo'];
    $presentacion=$_POST['presentacion'];
    $avatar='prod_avatar.jpg';
    $producto->crear($nombre,$concentracion,$adicional,$precio,$laboratorio,$tipo,$presentacion);
}
if($_POST['funcion']=='buscar'){
    $producto->buscar();
}
?>