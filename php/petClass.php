<?php

    class Pet{
        protected $mysql;
        protected $db = array(
            'servidor'=>'localhost',
            'database'=>'tamagotchi-db',
            'usuario'=>'root',
            'senha'=>'',
        );
        
        public function __construct(){
            $this->conectaBd();
        }

        public function listarPets(){
            $id = $_SESSION["id_usuario"];
            $sql = "SELECT * FROM pet WHERE idUsuario = '".$id."'";
            $mysql=$this->mysql->prepare($sql);
            $mysql->execute();
            return $mysql->fetchAll(PDO::FETCH_ASSOC);
        }

        protected function conectaBd(){
            $this->mysql = new PDO(
                'mysql:host='.$this->db['servidor'].';dbname='.$this->db['database'], $this->db['usuario'], $this->db['senha']
            );
            $this->mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        protected function retPet($pet){
        }

        public function criarPet(){
            session_start();
            $id = $_SESSION["id_usuario"];
            $src = 'tenor.gif'; //add outras imagens depois, por causa das fases do bicho
            error_log($id);             
            if ($_SERVER['REQUEST_METHOD']=='POST') {
                $sql="INSERT INTO pet (nomePet, happyPet, hungerPet, healthPet, sleepPet, statePet, imagem, idUsuario) VALUES (:nomePet, 40, 100, 49, 70, 'normal', '$src', '$id')";
                $mysql=$this->mysql->prepare($sql);
                $mysql->bindValue(':nomePet', $_POST['nomePet'],PDO::PARAM_STR);
                try{
                    $mysql->execute();
                    echo "<script type='text/javascript'>alert('Pet Criado com sucesso!');javascript:window.location='criarPet.php';</script>";
                }catch(PDOException $e){
                    echo $e->getMessage();
                }
            }
        }

        public function deletaPet(){
        }

    }

?>