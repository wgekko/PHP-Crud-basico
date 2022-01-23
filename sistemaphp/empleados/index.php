<?php
require 'empleados.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud con PHP</title>
    <link  rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.css"></script>    

</head>
<body>
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">                
        <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <!--<label for="">Id:</label> -->
                        <input type="hidden" required name="id" value="<?php echo $id; ?>" placeholder="" id="id" require="">
                        <br>
                        <label for="">Nombre(s):</label>
                        <input type="text" class="form-control" <?php echo (isset($error['nombre']))?"is-invalid":"";?> required name="nombre" value="<?php echo $nombre; ?>" placeholder="" id="nombre" require="">
                        <div class="invalid-feedback"> 
                            <?php echo (isset($error['nombre']))?$error['nombre']:"";?>
                        </div>
                        <br>
                        <label for="">Apellido:</label>
                        <input type="text" class="form-control" <?php echo (isset($error['apellido']))?"is-invalid":"";?> required name="apellido" value="<?php echo $apellido; ?>" placeholder="" id="apellido" require="">
                        <div class="invalid-feedback"> 
                            <?php echo (isset($error['apellido']))?$error['apellido']:"";?>
                        </div>
                        <br>
                        <label for="">Correo :</label>
                        <input type="email"  class="form-control" <?php echo (isset($error['correo']))?"is-invalid":"";?> required name="correo" value="<?php echo $correo; ?>" placeholder="" id="correo" require="">
                        <div class="invalid-feedback"> 
                            <?php echo (isset($error['correo']))?$error['correo']:"";?>
                        </div>
                        <br>   
                        <label for="">Foto :</label>
                        <?php if ($foto != "") {?>
                            <br/>
                                <img class="img-thumbnail rounded mx-auto d-block" width="100px"src="/img/<?php echo $foto;?>"/>
                            <br/><br/>
                         <? }?>   
                        <input type="file" class="form-control" <?php echo (isset($error['foto']))?"is-invalid":"";?> accept="image/*" name="foto" value="<?php echo $foto; ?>"  placeholder="" id="foto" require="">
                        <div class="invalid-feedback"> 
                            <?php echo (isset($error['foto']))?$error['foto']:"";?>
                        </div>        

                        <br>           
                    </div>   
                </div>
                    <div class="modal-footer">
                        <button value="btnAgregar" <?php echo $accionAgregar;?> class="btn btn-success" type="submit" name="accion">Agregar</button>
                        <button value="btnModificar" <?php echo $accionModificar;?> class="btn btn-warning" type="submit" name="accion">Modificar</button>
                        <button value="btnElminiar"  onclick="return Confirmar(¿Seguro que deseas borrar?);" <?php echo $accionEliminar;?> class="btn btn-danger" type="submit" name="accion">ELiminar</button>
                        <button value="btnCancelar" <?php echo $accionCancelar;?>  class="btn btn-primary" type="submit" name="accion">Cancelar</button>
                    <!--
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                    -->
                    </div>
                </div>
            </div>
        </div>   
        <br/> <br/><br/>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Agregar registro + 
        </button>
        <br><br>
      
        </form>
    <div class="row">
        <table class="table table-hover table-bordered" >
            <thead class="thead-dark">
                <tr>
                    <th> Foto </th>
                    <th> Nombre </th>
                    <th> Apellido </th>
                    <th>  Correo </th>
                    <th> Acciones</th>
                </tr>
            </thead>
        <?php foreach(listaEmpleados as $empleado){ ?> 
            <tr><img class="img-thumbnail" width="100px" src="../img/<?php echo $empleado['foto']?>"/></tr>
            <td><?php echo $empleado['nombre']?></td>
            <td><?php echo $empleado['apellido']?></td>
            <td><?php echo $empleado['correo']?></td>            
            <td>
            <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $empleado['id']?>">
        <!--    <input type="hidden" name="nombre" value="<#?php echo $empleado['nombre']?>">
            <input type="hidden" name="apellido" value="<#?php echo $empleado['apellido']?>">
            <input type="hidden" name="correo" value="<#?php echo $empleado['correo']?>">
            <input type="hidden" name="foto" value="<#?php echo $empleado['foto']?>">
        -->
            <input type="button" value="Seleccionar" class="btn btn-info" name="accion"> 
            <button value="btnElminiar" onclick="return Confirmar(¿Seguro que deseas borrar?);"  type="submit" class="btn btn-danger" name="accion">ELiminar</button>
            </form>       
            </td>        
        <?php }?>
        </table>
    </div>    
    <?php if($mostrarModal){?>
        <script>
            $('#exampleModal').modal('show');
        </script>
    <?php }?>  
    <script>
        function Confirmar(Mensaje){
            return (cofirm(Mensaje))?true:false;

        }
    </script>
    </div>
</body>
</html>