<?php


include_once('./Models/connection.php');

class fotosModel{

       //Nombre de la tabla
   private $table = 'fotos';


    public function read(){

        $db = new DATABASE();

        try
        {
            $stm = $db->getConnection()->prepare("SELECT * FROM $this->table");
            $stm->execute();

            $res =array();

            foreach ($stm->fetchAll(PDO::FETCH_OBJ) as $key => $dato) {

                $statement=$db->getConnection()->prepare("SELECT * from autores WHERE id = ?");
                $statement->execute([
                    $dato->FK_AUTORES
                ]);

                $fk =$statement->fetch(PDO::FETCH_OBJ);

                
                $res =  array(
                    'id' =>  $dato->ID ,
                    'nombre' =>  $dato->NOMBRE,
                    'tipo' =>  $dato->TIPO,
                    'email' =>  $dato->EMAIL, 
                    'tamaño' =>  $dato->TAMAÑO,
                    'fecha_creacion' =>  $dato->FECHA_CREACION,
                    'fecha_modificacion' =>  $dato->FECHA_MODIFICACION, 
                    "data_fk"=> array(
                      'id' =>  $fk->ID ,
                      'nombres' =>  $fk->NOMBRES,
                      'apellidos' =>  $fk->APELLIDOS,
                      'descripcion' =>  $fk->DESCRIPCION 
                    )
                        );



            }
      

            return $res;
       
           
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }

     
    }

    public function create(){

        $db = new DATABASE();

        try{

            $stm= $db->getConnection()->prepare("INSERT INTO $this->table (NOMBRE,TIPO,TAMAÑO,DESCRIPCION,FECHA_CREACION,FECHA_MODIFICACION,EMAIL,FK_AUTORES) VALUES (?,?,?,?,?,?,?,?)");
            
            $stm->execute([
                $_POST['nombre'],
                $_POST['tipo'],
                $_POST['tamaño'],
                $_POST['descripcion'],

                $_POST['fecha_creacion'],
                $_POST['fecha_modificacion'],
                $_POST['email'],

                $_POST['fk_autores']
    
            ]);

        
            $postId = $db->getConnection()->lastInsertId();

            var_dump($postId);

            //buscamos los campos del registro insertado
            $sql = $db->getConnection()->prepare("SELECT * FROM $this->table where ID= ?");
            $sql->execute([$postId]);
            $dato = $sql->fetch(PDO::FETCH_OBJ);

            var_dump($dato);

            //busca el los datos del fk 
            $sql1 = $db->getConnection()->prepare("SELECT * FROM autores where id= ?");
            $sql1->execute([$dato->FK_AUTORES]);

            $fk =$sql1->fetch(PDO::FETCH_OBJ);

            $res =  array(
                'id' =>  $dato->ID ,
                'nombre' =>  $dato->NOMBRE,
                'tipo' =>  $dato->TIPO,
                'email' =>  $dato->EMAIL, 
                'tamaño' =>  $dato->TAMAÑO,
                'fecha_creacion' =>  $dato->FECHA_CREACION,
                'fecha_modificacion' =>  $dato->FECHA_MODIFICACION, 
                "data_fk"=> array(
                    'id' =>  $fk->ID ,
                    'nombres' =>  $fk->NOMBRES,
                    'apellidos' =>  $fk->APELLIDOS,
                    'descripcion' =>  $fk->DESCRIPCION 
                )        );

                return $res;
        }catch(PDOException $e){
            header('Content-type:application/json;charset=utf-8');
            echo json_encode([
                'error' => [
                    'codigo' => $e->getCode(),
                    'mensaje' => $e->getMessage()
                ]
            ]);
        }
    }

          //Elimina un registro por Id
    public function delete(){

        $db = new DATABASE();

        try
        {

            $statement = $db->getConnection()->prepare("SELECT * FROM $this->table WHERE id_conductor = ?");
            $statement->execute([
                $_POST['id']
            ]);
        
            $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);

            $stm = $db->getConnection()->prepare("DELETE FROM $this->table WHERE id_conductor=?");
            $stm->execute([
                $_POST['id']
            ]);

            return $resultado;
           
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }
    }

     // Actualiza un resgistro por Id
     public function update(){

        $db = new DATABASE();
        try{
            $stm = $db->getConnection()->prepare("UPDATE $this->table SET cedula = ?, nombres = ?, apellidos = ?, fecha_contratacion = ?, fecha_terminacion = ?, bono_extras = ?, email = ?, id_vehiculo = ?,fecha= ? WHERE id_conductor = ?");

            $stm->execute([
                $_POST['cedula'],
                $_POST['nombres'],
                $_POST['apellidos'],

                $_POST['fecha_contratacion'],
                $_POST['fecha_terminacion'],
                $_POST['bono_extras'],

                $_POST['email'],
                $_POST['id_vehiculo'],
                $_POST['fecha'],
                $_POST['id']
                
        ]);

        $update = $db->getConnection()->prepare("SELECT * from carro WHERE id_carro = ?");
        $update->execute([
            $_POST['id_vehiculo'],
        ]);

        $resultado = $update->fetchAll(PDO::FETCH_ASSOC);

        return $resultado;

        }catch(PDOException $e){
            header('Content-type:application/json;charset=utf-8');
            echo json_encode([
                'error' => [
                    'codigo' => $e->getCode(),
                    'mensaje' => $e->getMessage()
                ]
            ]);
        }
    }

       //Obtiene un registro por Id
       public function conductor(){

        $db = new DATABASE();
        try
        {
            $stm = $db->getConnection()->prepare("SELECT * FROM $this->table WHERE id_conductor= ?");

            $stm->execute([
                $_POST['id']
            ]);
            
            $resultado = $stm->fetch(PDO::FETCH_ASSOC);

            $statement =$db->getConnection()->prepare("SELECT * from carro WHERE id_carro = ?");

    
            $id_vehiculo = $resultado['id_vehiculo'];
            $statement->execute([
                    $id_vehiculo
            ]);
    
            $resultado2 = $statement->fetch(PDO::FETCH_ASSOC);
            $resultado['Carro asignado'] = $resultado2;
        

            return $resultado;
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }
    }

}