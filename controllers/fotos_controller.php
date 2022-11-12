<?php


class ControllerFotos{


    public function read(){
        
        require_once  ("./Models/fotosModel.php");

        $model = new fotosModel();          

        header('Content-type:application/json;charset=utf-8');
        return json_encode([
            $model->read()
        ]);
     
    }

    #crea un nuevo cliente
    public function create(){

    
        require_once  ("./Models/fotosModel.php");

        $model = new fotosModel();  

        header('Content-type:application/json;charset=utf-8');
        echo json_encode([
            $model->create()
        ]);

    }

    public function delete(){
        
        require_once  ("./Models/conductorModel.php");

        $model = new conductorModel();  
        
        header('Content-type:application/json;charset=utf-8');
        return json_encode([
            'mensaje' => "Registro eliminado correctamente",
            'Conductor eliminado' => $model->delete()
        ]);
     
    }


    public function update(){

        $json["id_conductor"] =  $_POST['id'];
        $json["cedula"] =  $_POST['cedula'];
        $json["nombres"] = $_POST['nombres'];
        $json["apellidos"] = $_POST['apellidos'];
        $json["fecha_contratacion"] = $_POST['fecha_contratacion'];
        $json["fecha_terminacion"] = $_POST['fecha_terminacion'];
        $json["bono_extras"] = $_POST['bono_extras'];
        $json["email"] =  $_POST['email'];

        $json["fecha"] = $_POST['fecha'];
      
    
        require_once  ("./Models/conductorModel.php");

        $model = new conductorModel();  
        
        $json["carro"] = $model->update();
        
        header('Content-type:application/json;charset=utf-8');
        return json_encode([
            'mensaje' => "Registro actualizado correctamente",
            'Carro actualizado' => $json
        ]);
     
    }

    
    public function conductor(){

        require_once  ("./Models/conductorModel.php");

        $model = new conductorModel();  


        header('Content-type:application/json;charset=utf-8');
        return json_encode($model->conductor());
     
    }

   


}
