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

        $json["nombre"] =  $_POST['nombre'];
        $json["tipo"] = $_POST['tipo'];
        $json["tamaño"] = $_POST['tamaño'];
        $json["descripcion"] = $_POST['descripcion'];
        $json["fecha_creacion"] = $_POST['fecha_creacion'];
        $json["fecha_modificacion"] = $_POST['fecha_modificacion'];
        $json["email"] =  $_POST['email']; 

        require_once  ("./Models/fotosModel.php");

        $model = new fotosModel(); 
        
        $json["autores"] = $model->create();

        header('Content-type:application/json;charset=utf-8');
        return json_encode([
            $json
        ]);

    }

    public function delete(){
        
        require_once  ("./Models/fotosModel.php");

        $model = new fotosModel(); 
        
        header('Content-type:application/json;charset=utf-8');
        return json_encode([
            $model->delete()
        ]);
     
    }


    public function update(){
      
    
        require_once  ("./Models/fotosModel.php");

        $model = new fotosModel(); 
        
        header('Content-type:application/json;charset=utf-8');
        return json_encode([
            $model->update()
        ]);
     
    }

    
    public function conductor(){

        require_once  ("./Models/conductorModel.php");

        $model = new conductorModel();  


        header('Content-type:application/json;charset=utf-8');
        return json_encode($model->conductor());
     
    }

   


}
