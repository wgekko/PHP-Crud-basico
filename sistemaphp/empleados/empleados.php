<?php
$id=(isset($_POST[$id]))?$_POST['id']:"";
$nombre=(isset($_POST[$nombre]))?$_POST['nombre']:"";
$apellido=(isset($_POST[$apellido]))?$_POST['apellido']:"";
$correo=(isset($_POST[$correo]))?$_POST['correo']:"";

$foto=(isset($_FILES[$foto] ["name"]))?$_FILES['foto'] ["name"]:"";
$accion=(isset($_POST[$accion]))?$_POST['accion']:"";

$error=array();

$accionAgregar= "";
$accionModificar=$accionEliminar=$accionCancelar="disabled";
$mostrarModal=false;

include("../conexion/conexion.php");

switch ($accion) {
    case 'btnAgregar':
        #validación de datos de ingreso 
        if($nombre==""){
            $error['nombre']="Debe escribir el nombre...";
        }
        if($apellido==""){
            $error['apellido']="Debe escribir el apellido...";
        }
        if($correo==""){
            $error['correo']="Debe escribir la dirección de correo...";
        }
        if($foto==""){
            $error['foto']="Debe ingresar una foto...";
        }
        if (count(error)>0){
            $mostrarModal=true;
            break;
        }
        $sentencia=$pdo->prepare("INSERT INTO empleados(nombre,apellido,correo,foto) 
        VALUES (:nombre,:apellido,:correo:foto)");
        $sentencia->bindParam(':nombre',$nombre);
        $sentencia->bindParam(':apellido',$apellido);
        $sentencia->bindParam(':correo',$correo);

        $Fecha=new DateTime();
        $nombreArchivo=($foto!="")?$Fecha->getTimestamp()."_".$_FILES["foto"] ["name"]:"image.jpg";
        $tmpFoto=$_FILES["foto"]["tmp_name"];
        if($tmpFoto !=""){
            move_uploaded_file($tmpFoto, "../img/".$nombreArchivo);
        }

        $sentencia->bindParam(':foto',$$nombreArchivo);
        $sentencia->execute();
        header('Location: index.php');     
        #echo "Presionaste agregar"
    break;
    case 'btnModificar':
        $sentencia=$pdo->prepare(" UPDATE empleados SET 
        nombre=:nombre,
        apellido=:apellido,
        correo=:correo WHERE id=:id"); 
        
        $sentencia->bindParam(':nombre',$nombre);
        $sentencia->bindParam(':apellido',$apellido);
        $sentencia->bindParam(':correo',$correo);
        #$sentencia->bindParam(':foto',$foto);

        $sentencia->bindParam(':id',$id);
        $sentencia->execute();
        
        $Fecha=new DateTime();
        $nombreArchivo=($foto!="")?$Fecha->getTimestamp()."_".$_FILES["foto"] ["name"]:"image.jpg";
        $tmpFoto=$_FILES["foto"]["tmp_name"];

        if($tmpFoto !=""){
            move_uploaded_file($tmpFoto, "../img/".$nombreArchivo);
            #borrado previo de la foto anterior
            $sentencia=$pdo->prepare(" SELECT foto FROM empleados WHERE id=:id");   
            $sentencia->bindParam(':id',$id);
            $sentencia->execute();
            $empleado=$sentencia->fetch(PDO::FETCH_LAZY);
            if(isset($empleado["foto"])){
                if(file_exists("../img/". $empleado["foto"])){

                    if($empleado['foto'] !="image.jpg"){
                        unlink("../img/". $empleado["foto"]);
                    }
                }
            }
            # se agrega la nueva foto
            $sentencia=$pdo->prepare(" UPDATE empleados SET 
            foto=:foto WHERE id=:id"); 
            $sentencia->bindParam(':foto',$nombreArchivo);
            $sentencia->bindParam(':id',$id);
            $sentencia->execute();
        }     

        header('Location: index.php');  
        #echo "Presionaste modificar"
    break;
    case 'btnElminiar':
        # se busca la foto existente en la carpeta img para borrarla
        $sentencia=$pdo->prepare(" SELECT foto FROM empleados WHERE id=:id");   
        $sentencia->bindParam(':id',$id);
        $sentencia->execute();
        $empleado=$sentencia->fetch(PDO::FETCH_LAZY);
        print_r($empleado)
        if(isset($empleado["foto"]) && ($empleado['foto']!="image.jpg")){
            if(file_exists("../img/". $empleado["foto"])){               
                        unlink("../img/". $empleado["foto"]);
            }
        }
        # se borra el registro 
        $sentencia=$pdo->prepare(" DELETE FROM empleados WHERE id=:id");   
        $sentencia->bindParam(':id',$id);
        $sentencia->execute();
        header('Location: index.php');       
        #echo "Presionaste eliminar"
    break;
    case 'btnCancelar':
        header('Location: index.php');  36
        #echo "Presionaste Cancelar"
    break;
    case 'Seleccionar':
        $accionAgregar= "disabled";
        $accionModificar=$accionEliminar=$accionCancelar="";
        $mostrarModal=true;

        $sentencia=$pdo->prepare(" SELECT * FROM empleados WHERE id=:id");   
        $sentencia->bindParam(':id',$id);
        $sentencia->execute();
        $empleado=$sentencia->fetch(PDO::FETCH_LAZY);

        $nombre=$empleado['nombre'];
        $apellido=$empleado['apellido'];
        $correo=$empleado['correo'];
        $foto=$empleado['foto'];
        
        #echo "Presionaste Cancelar"
    break;    
    default:
        echo "opcion no valida...."# code...
    break;
}
    $sentencia=$pdo->prepare("SELECT * FROM empleados  WHERE 1");
    $sentencia.execute();
    $listaEmpleados=$sentecia->fetchALL(PDO::FETCH_ASSOC);
    //print_r($listaEmpleados);
?>