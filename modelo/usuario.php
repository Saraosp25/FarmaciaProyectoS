<?php
include_once 'conexion.php';
class Usuario{
    var $objetos;
    public function __construct(){
        $db=new conexion();
        $this->acceso=$db->pdo;
    }
    function loguearse($dni,$pass){
        $sql="SELECT * FROM usuario where cedulaU=:dni and contra= :pass";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':dni'=>$dni,':pass'=>$pass));
        $this->objetos= $query->fetchall();
        return $this ->objetos;
    }
    function obtener_datos($id){
        $sql="SELECT * FROM usuario u,tipousuario t where u.tipoUsuario_idtipoUsuario=t.idtipoUsuario and idusuario=:id";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id));
        $this->objetos= $query->fetchall();
        return $this ->objetos;
    }
    function editar($usuario,$telefono,$residenciau,$correou,$adicionalu){
        $sql="UPDATE usuario SET telefonoU=:telefono,residenciaU=:residenciau,correoU=:correou,adicionalU=:adicionalu where idusuario=:id";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':id'=>$usuario,':telefono'=>$telefono,':residenciau'=>$residenciau,':correou'=>$correou,':adicionalu'=>$adicionalu));
        echo $query;
    }
    function cambiar_contra($usuario,$oldpass,$newpass){
        $sql="SELECT * FROM usuario where idusuario=:id and contra=:oldpass";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':id'=>$usuario,':oldpass'=>$oldpass));
        $this->objetos = $query->fetchall();
        if(!empty($this->objetos)){
            $sql="UPDATE usuario SET contra=:newpass where idusuario=:id ";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':id'=>$usuario,':newpass'=>$newpass));
            echo 'update';
        }else{
            echo 'noupdate';
        }
    }
    function cambiar_foto($usuario,$nombre){
        $sql="SELECT avatar FROM usuario where idusuario=:id ";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':id'=>$usuario));
        $this->objetos = $query->fetchall();
        
            $sql="UPDATE usuario SET avatar=:nombre where idusuario=:id ";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':id'=>$usuario,':nombre'=>$nombre));
        return $this->objetos;
        
    }
    function buscar(){
        if(!empty($_POST['consulta'])){
             $consulta=$_POST['consulta'];
             $sql="SELECT * FROM usuario JOIN tipoUsuario ON tipoUsuario_idtipoUsuario=idtipoUsuario where nombreu LIKE :consulta";
             $query = $this->acceso->prepare($sql);
             $query->execute(array(':consulta'=>"%$consulta%"));
             $this->objetos = $query->fetchall();
             return $this->objetos;
            

        }else{
       
            $sql="SELECT * FROM usuario JOIN tipoUsuario ON tipoUsuario_idtipoUsuario=idtipoUsuario WHERE nombreu NOT LIKE '' ";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos = $query->fetchall();
            return $this->objetos;


        }

    }
    function crear($nombre,$apellido,$edad,$dni,$pass,$tipo,$avatar){
        $sql="SELECT idusuario FROM usuario where cedulaU=:dni ";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':dni'=>$dni));
        $this->objetos = $query->fetchall();
        if(!empty($this->objetos)){
            echo 'noadd';

        }else{
            $sql="INSERT INTO usuario(nombreU,apellidoU,edad,cedulaU,contra,tipoUsuario_idtipoUsuario,avatar) VALUES (:nombre,:apellido,:edad,:dni,:pass,:tipo,:avatar);";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':nombre'=>$nombre,':apellido'=>$apellido,':edad'=>$edad,':dni'=>$dni,':dni'=>$dni,':pass'=>$pass,':tipo'=>$tipo,':avatar'=>$avatar));
            echo'add';

        }
        
    }
    function borrar($pass,$id_borrado,$usuario){
        $sql="SELECT idusuario FROM usuario where idusuario=:usuario and contra=:pass";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':usuario'=>$usuario,':pass'=>$pass));
        $this->objetos = $query->fetchall();
        if(!empty($this->objetos)){
            $sql="DELETE FROM usuario where idusuario=:id_borrado";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id_borrado'=>$id_borrado));
            echo'borrado';
        }else{   
            echo'noborrado';

        }

    }
}


?>