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

                $statement=$db->getConnection()->prepare("SELECT * from carro WHERE id_carro = ?");
                $statement->execute([
                    $dato->id_vehiculo
                ]);

                $fk =$statement->fetch(PDO::FETCH_OBJ);

                
                array_push($res,array(
                    'id_conductor' =>  $dato->id_conductor ,
                    'cedula' =>  $dato->cedula,
                    'nombres' =>  $dato->nombres,
                    'apellidos' =>  $dato->apellidos, 
                    'fecha_contratacion' =>  $dato->fecha_contratacion,
                    'fecha_terminacion' =>  $dato->fecha_terminacion,
                    'fecha' =>  $dato->FECHA, 
                    "data_fk"=> array(
                    'id_carro' =>  $fk->id_carro ,
                    'placa' =>  $fk->placa,
                    'marca' =>  $fk->marca,
                    'cant_pasajeros' =>  $fk->cant_pasajeros 
                    ))
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

            $stm= $db->getConnection()->prepare("INSERT INTO $this->table (cedula, nombres, apellidos, fecha_contratacion, fecha_terminacion, bono_extras, email,fecha, id_vehiculo) VALUES (?,?,?,?,?,?,?,?,?)");
            
            $stm->execute([
                $_POST['cedula'],
                $_POST['nombres'],
                $_POST['apellidos'],

                $_POST['fecha_contratacion'],
                $_POST['fecha_terminacion'],
                $_POST['bono_extras'],

                $_POST['email'],
                
                $_POST['fecha'],
                $_POST['id_vehiculo']
            ]);

            
            $statement = $db->getConnection()->prepare("SELECT * from carro WHERE id_carro = ?");
            $statement->execute([
                $_POST['id_vehiculo']
            ]);

            $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);

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