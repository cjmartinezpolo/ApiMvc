<?php


class ControllerAutores{


    public function read(){
        
        require_once  ("./Models/autoresModel.php");

        $model = new autoresModel();

        header('Content-type:application/json;charset=utf-8');
        return json_encode($model->read());
     
    }


    public function create(){

        $json = json_decode(file_get_contents("php://input"), true);
        
        $json['nombres'] = $_POST['nombres'];
        $json['apellidos']= $_POST['apellidos'];
        $json['descripcion'] = $_POST['descripcion'];
    
        require_once  ("./Models/autoresModel.php");

        $model = new autoresModel();

        $result = $model->create();

        $json['id_autores'] = $result;

        header('Content-type:application/json;charset=utf-8');
        return json_encode($json);

    }

    public function delete(){
        
        require_once  ("./Models/autoresModel.php");

        $model = new autoresModel();
        
        header('Content-type:application/json;charset=utf-8');
        return json_encode([
            'mensaje' => "Registro eliminado correctamente",
            'Carro eliminado' => $model->delete()
        ]);
     
    }


    public function update(){
        
        require_once  ("./Models/autoresModel.php");

        $model = new autoresModel();

        
        
        header('Content-type:application/json;charset=utf-8');
        return json_encode([
            $model->update()
        ]);
     
    }

    
    public function autoresId(){

        
        require_once  ("./Models/autoresModel.php");

        $model = new autoresModel();

        header('Content-type:application/json;charset=utf-8');
        return json_encode($model->autoresId());
     
    }

   


}
