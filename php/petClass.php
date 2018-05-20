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
            //$pets = $this->retPets();
        }

        protected function conectaBd(){
            $this->mysql = new PDO(
                'mysql:host='.$this->db['servidor'].';dbname='.$this->db['database'], $this->db['usuario'], $this->db['senha']
            );
            $this->mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        protected function retPet($pet){
            $sql = 'SELECT * FROM `pet` WHERE `pet`.`nomePet` = :nomePet;';
            $mysql = $this->mysql->prepare($sql);
            $mysql->bindValue(':nomePet', $nomePet,PDO::PARAM_STR);
            $mysql->execute();
            return $mysql->fetch(PDO::FETCH_ASSOC);
        }

        public function criarPet(){
            if ($_SERVER['REQUEST_METHOD']=='POST') {
                $sql='INSERT INTO `pet` (`nomePet`, `happyPet`, `hungerPet`, `healthPet`,`sleepPet`, `statePet`, `imagem`, `idUsuario`) VALUES (:nomePet, 100, 70, 100, 90, "normal", "sdas", 1);';
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

    }

?>