<?php
    session_start();
    if($_SESSION['user']){
        header('Location: ./InfraHeaters.php');
    }
    $login='user';
    $pass='111111';
    $loginError=null;
    if($_SERVER['REQUEST_METHOD']=="POST"){
        if($login==$_POST['login']&&$pass==$_POST['password']){
            $_SESSION['user']='user';
            header('Location: ./InfraHeaters.php');
        } else{
            $loginError="Неправильний логін або пароль!";
        }
    }
?>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Форма входу</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    
    </head>
    <body>
        <div class="container">
            <h1>Форма входу</h1>
            <div class="row">
                <form method="POST">
                        <p>
                            <input type="text" name="login" value="" class="form-control" placeholder="Логін" required/>
                        </p>
                        <p>
                            <input type="password" name="password" value="" class="form-control" placeholder="Пароль" required/>
                        </p>
                        <p>
                            <button class="btn btn-success" type="submit">Увійти</button>
                        </p>
                        <p class="text-danger"><?php echo $loginError?$loginError:''; ?></p>
                    </form>
            </div>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</html>