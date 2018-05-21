<?php
    

    class User{
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

        public function login(){
            session_start();
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $usuario = $this->retUsuario($_POST['usuario']);
                $_SESSION["id_usuario"] = $usuario["idUsuario"];
                if($_POST['senha'] === $usuario['senha']){
                    $_SESSION["usuario"] = $usuario;

                }
                else{
                    echo "<script type='text/javascript'>alert('Usuário não encontrado!');javascript:window.location='login.php';</script>";
                }
            }
            if(!empty($_SESSION["usuario"])){
                if(empty($_SESSION["url"])){
                    header('Location: ./listagem-pet.php');
                    echo "teste";
                } else{
                    header('Location: '.$_SESSION["url"]);
                }
            }


        }

        public function logout(){
            session_start();
            session_unset();
            session_destroy();
            header('Location: ./index.html');
        }

        public function protege(){
            session_start();
            if (empty($_SESSION["usuario"])) {
                $_SESSION["url"]=$_SERVER['REQUEST_URI'];
                header('Location: ./login.php');
            }
        }

        public function cadastrar(){
            if ($_SERVER['REQUEST_METHOD']=='POST') {
                $sql='INSERT INTO `usuario` (`usuario`, `senha`) VALUES (:usuario,:senha);';
                $mysql=$this->mysql->prepare($sql);
                $mysql->bindValue(':usuario', $_POST['usuario'],PDO::PARAM_STR);
                $mysql->bindValue(':senha', $_POST['senha'],PDO::PARAM_STR);
                try{
                    $mysql->execute();
                    echo "<script type='text/javascript'>alert('Cadastro efetuado com sucesso!');javascript:window.location='cadastrar.php';</script>";
                }catch(PDOException $e){
                    echo $e->getMessage();
                }
            }
        }

        protected function conectaBd(){
            $this->mysql = new PDO(
                'mysql:host='.$this->db['servidor'].';dbname='.$this->db['database'], $this->db['usuario'], $this->db['senha']
            );
            $this->mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        protected function retUsuario($usuario){
            $sql='SELECT * FROM `usuario` WHERE `usuario`.`usuario` = :usuario;';
            $mysql=$this->mysql->prepare($sql);
            $mysql->bindValue(':usuario', $usuario,PDO::PARAM_STR);
            $mysql->execute();
            return $mysql->fetch(PDO::FETCH_ASSOC);
        }

        

    }

?>