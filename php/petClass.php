<?php

    class Pet{
        protected $mysql;
        //protected $horaInicial = date('H:i:s');
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

        public function criarPet(){
            session_start();
            $id = $_SESSION["id_usuario"];
            $src_normal_triste = 'tails-normal.gif';
            /*$src_bravo = 'tails-bravo.gif';
            $src_cansado = 'tails-cansado.gif';
            $src_feliz = 'tails-feliz.gif';*/

            error_log($id);             
            if ($_SERVER['REQUEST_METHOD']=='POST') {
                $sql="INSERT INTO pet (nomePet, happyPet, hungerPet, healthPet, sleepPet, statePet, imagem, idade, idUsuario) VALUES (:nomePet, 40, 100, 49, 70, 'normal', '$src_normal_triste', 0, '$id')";
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

        public function atualizarStatusPet(){
            $id = $_SERVER["id_usuario"];
            error_log($id);
            
            if($_SERVER['REQUEST_METHOD']=='POST'){
                $hora = date('H:i:s');
                if($hora - $horaInicial >= 2){
                    $sql="UPDATE INTO pet (statePet, imagem) VALUES ('cansado', '$src_cansado')";
                    $mysql=$this->mysql->prepare($sql);
                    try{
                        $mysql->execute();
                    }catch(PDOException $e){
                        echo $e->getMessage();
                    }
                }
            }
        }

        public function deletaPet(){
        }

    }

?>