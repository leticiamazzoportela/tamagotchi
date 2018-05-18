<?php

require 'php/userClass.php';
$usuarios=new User();
$usuarios->logout();

?>

<!DOCTYPE html>
<html>

    <p>teste</p>
    <form action="listagem-pet.php" method="post" class="form-signin">
    <button class="btn btn-lg btn-primary btn-block" type="submit">
        <span class="glyphicon glyphicon-circle-arrow-right"></span> sair!
    </button>    


</html>