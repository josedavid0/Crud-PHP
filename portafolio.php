<?php include("cabecera.php") ?>
<?php include("conexion.php") ?>
<?php
// Muestra los datos que se introducen en el formulario
if ($_POST) {
    print_r($_POST);
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $imagen=$_FILES['archivo']['name'];

    $imagen_temporal=$_FILES['archivo']['tmp_name'];

    move_uploaded_file($imagen_temporal,"imagenes/".$imagen);

    $objConexion = new conexion(); // Instancia de la clase clase conexion

    // Sentencia sql que permite insertar nuevos registros
    $sql = "INSERT INTO `proyecto` (`id`, `nombre`, `imagen`, `descripcion`) VALUES (NULL, '$nombre', '$imagen', '$descripcion');";

    $objConexion->ejecutar($sql);
    header("location:portafolio.php");
}
if ($_GET) {

    // "DELETE FROM proyecto WHERE `proyecto`.`id` = 6"

    $id = $_GET['borrar'];
    $objConexion = new conexion();
    
    $imagen=$objConexion->consultar("SELECT imagen FROM `proyecto` WHERE id=".$id);
    unlink("imagenes/".$imagen[0]['imagen']);

    $sql = "DELETE FROM proyecto WHERE `proyecto`.`id` =" . $id;
    $objConexion->ejecutar($sql);
    header("location:portafolio.php");
}

/* El objConexion accede al método 'consultar',
 y se muestra cada uno de los registros gracias a 
 la instrucción sql*/
$objConexion = new conexion();
$resultado = $objConexion->consultar("SELECT * FROM `proyecto`");

// print_r($resultado);
?>

<br>

<div class="container">
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    Datos del proyecto
                </div>
                <div class="card-body">
                    <form action="portafolio.php" method="post" enctype="multipart/form-data">

                        Nombre del proyecto: <input class="form-control" type="text" name="nombre" required>
                        <br>
                        Imagen del proyecto: <input class="form-control" type="file" name="archivo" required>
                        <br>
                        Descripción:
                        <textarea class="form-control" name="descripcion" rows="3" required></textarea>
                        <br>
                        <input class="btn btn-success" type="submit" value="Enviar proyecto">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Imagen</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($resultado as $proyecto) { ?>
                        <tr>
                            <td><?php echo $proyecto['id']; ?></td>
                            <td><?php echo $proyecto['nombre']; ?></td>
                            <td>
                                <img width="100" src="imagenes/<?php echo $proyecto['imagen']; ?>" alt="imagen">
                            
                        
                        </td>
                            <td><?php echo $proyecto['descripcion']; ?></td>
                            <td> <a class="btn btn-danger" href="?borrar=<?php echo $proyecto['id']; ?>">Eliminar</a> </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>


<?php include("pie.php") ?>