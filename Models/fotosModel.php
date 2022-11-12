<?php


include_once('./Models/connection.php');

class fotosModel
{

    //Nombre de la tabla
    private $table = 'fotos';


    public function read()
    {

        $db = new DATABASE();

        try {
            $stm = $db->getConnection()->prepare("SELECT * FROM $this->table");
            $stm->execute();

            $res = array();

            foreach ($stm->fetchAll(PDO::FETCH_OBJ) as $key => $dato) {

                $statement = $db->getConnection()->prepare("SELECT * from autores WHERE id = ?");
                $statement->execute([
                    $dato->FK_AUTORES
                ]);

                $fk = $statement->fetch(PDO::FETCH_OBJ);


                array_push(
                    $res,
                    array(
                        'id' =>  $dato->ID,
                        'nombre' =>  $dato->NOMBRE,
                        'tipo' =>  $dato->TIPO,
                        'email' =>  $dato->EMAIL,
                        'descripcion' =>  $dato->DESCRIPCION,
                        'tamaño' =>  $dato->TAMAÑO,
                        'fecha_creacion' =>  $dato->FECHA_CREACION,
                        'fecha_modificacion' =>  $dato->FECHA_MODIFICACION,
                        "data_fk" => array(
                            'id' =>  $fk->ID,
                            'nombres' =>  $fk->NOMBRES,
                            'apellidos' =>  $fk->APELLIDOS,
                            'descripcion' =>  $fk->DESCRIPCION
                        )
                    )
                );
            }

            return $res;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function create()
    {

        $db = new DATABASE();

        try {

            $stm = $db->getConnection()->prepare("INSERT INTO $this->table (NOMBRE,TIPO,TAMAÑO,DESCRIPCION,FECHA_CREACION,FECHA_MODIFICACION,EMAIL,FK_AUTORES) VALUES (?,?,?,?,?,?,?,?)");

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


            //busca el los datos del fk 
            $sql1 = $db->getConnection()->prepare("SELECT * FROM autores where id= ?");
            $sql1->execute([
                $_POST['fk_autores']
            ]);

            $fk = $sql1->fetch(PDO::FETCH_OBJ);

            return $fk;
        } catch (PDOException $e) {
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
    public function delete()
    {

        $db = new DATABASE();

        try {

            //verificar si existe el usuario
            $sql = $db->getConnection()->prepare("SELECT * FROM $this->table where ID= ?");
            $sql->execute([$_POST['id']]);
            $result = $sql->rowCount();

            if ($result <= 0) {
                $res = array("ID " . $_POST['id'] => "no exite registro");

                return $res;
            } else {

                $dato = $sql->fetch(PDO::FETCH_OBJ);

                //busca el los datos del fk 
                $sql1 = $db->getConnection()->prepare("SELECT * FROM autores where id= ?");
                $sql1->execute([$dato->FK_AUTORES]);

                $fk = $sql1->fetch(PDO::FETCH_OBJ);


                $id = $_POST['id'];
                $statement = $db->getConnection()->prepare("DELETE FROM $this->table where id= ?");
                $statement->execute([
                    $id
                ]);
                header("HTTP/1.1 200 OK");

                $res = array(
                    'mensaje' => 'Registro eliminado satisfactoriamente',
                    'id' =>  $dato->ID,
                    'nombre' =>  $dato->NOMBRE,
                    'tipo' =>  $dato->TIPO,
                    'email' =>  $dato->EMAIL,
                    'tamaño' =>  $dato->TAMAÑO,
                    'fecha_creacion' =>  $dato->FECHA_CREACION,
                    'fecha_modificacion' =>  $dato->FECHA_MODIFICACION,
                    "data_fk" => array(
                        'id' =>  $fk->ID,
                        'nombres' =>  $fk->NOMBRES,
                        'apellidos' =>  $fk->APELLIDOS,
                        'descripcion' =>  $fk->DESCRIPCION
                    )
                );

                return $res;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Actualiza un resgistro por Id
    public function update()
    {

        $db = new DATABASE();


        try {

            //verificar si existe el usuario
            $sql = $db->getConnection()->prepare("SELECT * FROM $this->table where ID= ?");
            $sql->execute([
                $_POST['id']
            ]);

            $result = $sql->rowCount();

            if ($result <= 0) {
                $res = array("ID " . $_POST['id'] => "no exite registro");

                return $res;
            } else {

                $dato = $sql->fetch(PDO::FETCH_OBJ);

                $sql = "UPDATE $this->table SET NOMBRE = ?,TIPO = ?,TAMAÑO = ?,DESCRIPCION = ?,FECHA_CREACION = ?,FECHA_MODIFICACION = ?,EMAIL = ?,FK_AUTORES = ?  WHERE id= ? ";

                $statement = $db->getConnection()->prepare($sql);
                $statement->execute([
                    $_POST['nombre'],
                    $_POST['tipo'],
                    $_POST['tamaño'],
                    $_POST['descripcion'],
                    $_POST['fecha_creacion'],
                    $_POST['fecha_modificacion'],
                    $_POST['email'],
                    $_POST['fk_autores'],
                    $_POST['id'],
                ]);


                //busca el los datos del fk 
                $sql1 = $db->getConnection()->prepare("SELECT * FROM autores where id= ?");
                $sql1->execute([$_POST['fk_autores']]);

                $fk = $sql1->fetch(PDO::FETCH_OBJ);

                $res = array(
                    'mensaje' => 'Registro Actualizado satisfactoriamente',
                    'data' => array(
                        'id' =>  $_POST['id'],
                        'nombre' =>  $_POST['nombre'],
                        'tipo' =>  $_POST['tipo'],
                        'tamaño' =>  $_POST['tamaño'],
                        'descripcion' =>  $_POST['descripcion'],
                        'fecha_creacion' =>  $_POST['fecha_creacion'],
                        'fecha_modificacion' =>  $_POST['fecha_modificacion'],
                        'email' =>  $_POST['email'],
                        "data_fk" => array(
                            'id' =>  $fk->ID,
                            'nombres' =>  $fk->NOMBRES,
                            'apellidos' =>  $fk->APELLIDOS,
                            'descripcion' =>  $fk->DESCRIPCION
                        )
                    )

                );

                return $res;
            }
        } catch (PDOException $e) {
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
    public function fotosId()
    {

        $db = new DATABASE();
        try {

            //verificar si existe el usuario
            $sql = $db->getConnection()->prepare("SELECT * FROM $this->table where id= ?");
            $sql->execute([$_GET['id']]);
            $result = $sql->rowCount();

            if ($result <= 0) {
                $res = array("ID " . $_GET['id'] => "no exite este registro");

                return $res;
            } else {

                //Mostrar lista de post
                $sql = $db->getConnection()->prepare("SELECT * FROM $this->table WHERE ID = ?");
                $sql->execute([$_GET['id']]);

                $dato = $sql->fetch(PDO::FETCH_OBJ);

                //busca el los datos del fk 
                $sql1 = $db->getConnection()->prepare("SELECT * FROM autores where id= ?");
                $sql1->execute([$dato->FK_AUTORES]);

                $fk = $sql1->fetch(PDO::FETCH_OBJ);

                $res =  array(
                    'id' =>  $dato->ID,
                    'nombre' =>  $dato->NOMBRE,
                    'tipo' =>  $dato->TIPO,
                    'email' =>  $dato->EMAIL,
                    'descripcion' =>  $dato->DESCRIPCION,
                    'tamaño' =>  $dato->TAMAÑO,
                    'fecha_creacion' =>  $dato->FECHA_CREACION,
                    'fecha_modificacion' =>  $dato->FECHA_MODIFICACION,
                    "data_fk" => array(
                        'id' =>  $fk->ID,
                        'nombres' =>  $fk->NOMBRES,
                        'apellidos' =>  $fk->APELLIDOS,
                        'descripcion' =>  $fk->DESCRIPCION
                    )
                );

                header("HTTP/1.1 200 OK");
                echo json_encode($res);
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
