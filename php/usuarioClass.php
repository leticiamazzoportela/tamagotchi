<?php 

    class Usuario{
        var $idUsuario;
        var $login;
        var $senha;

        #funções get e set para a classe usuário
        function set_login($new_login){
            $this->login = $new_login;
        }
        function get_login(){
            return $this->login;
        }

        function set_senha($new_senha){
            $this->senha = $new_senha;
        }
        function get_senha(){
            return $this->senha;
        }

    }

?>