<?php
session_start();
if(!$_SESSION['user']){
    header('Location: login.php');
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../app/WorkPrincList.php');
$item=null;
$errorMessage = '';
$a = new WorkPrincList();
if($_SERVER['REQUEST_METHOD']=='POST'){
    $a->getAllFromDatabase();
    if($_POST['id']==""){
        $result = $a->insertIntoDatabase(['name'=>$_POST['name']]);
        if ($result === false) {
            $errorMessage = "Помилка: Такий принцип роботи вже існує!";
        }
    } else{
        $result = $a->updateDatabaseById(['id'=>$_POST['id'],'name'=>$_POST['name']]);
        if ($result === false) {
            $errorMessage = "Помилка: Принцип роботи з такою назвою вже існує!";
            $item = ['id'=>$_POST['id'], 'name'=>$_POST['name']];
        } else {
            header('Location: WorkPrincs.php');
            exit();
        }
    }
} else {
    if(isset($_GET['action'])&&$_GET['action']=='delete'){
        if(!$a->deleteFromDatabaseById($_GET['id'])){
            $errorMessage = "Помилка: Неможливо видалити цей запис, оскільки він використовується в існуючих обігрівачах!";
            $a->getAllFromDatabase();
        } else {
            header('Location: WorkPrincs.php');
            exit();
        }
    } else if(isset($_GET['action'])&&$_GET['action']=='update'){
        $a->getAllFromDatabase();
        $item=$a->getById($_GET['id']);
    } else {
        $a->getAllFromDatabase();
    }
}

?>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Принципи роботи</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    
        <link rel="stylesheet" href="../assets/styles.css">
    </head>
    <body>
        <div class="container">
            <ul class="nav">
                <li><a class="btn btn-outline nav-btn" href="./WorkPrincs.php">Принципи роботи</a></li>
                <li><a class="btn btn-outline nav-btn" href="./SpheresOfAppl.php">Сфери застосування</a></li>
                <li><a class="btn btn-outline nav-btn" href="./Properties.php">Характеристики</a></li>
                <li><a class="btn btn-outline nav-btn" href="./Vendors.php">Виробники</a></li>
                <li><a class="btn btn-outline nav-btn" href="./InfraHeaters.php">Інфрачервоні обігрівачі</a></li>
                <li><a class="btn btn-outline nav-btn" href="./logout.php">Вийти</a></li>
            </ul>
            <h1>Принципи роботи</h1>
            <div class="row">
                <div class="col-md-8">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Назва</th>
                                <th>Дії</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $a->getAsTableBody();?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <form method="POST">
                        <?php if($errorMessage): ?>
                            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                        <?php endif; ?>
                        <p>
                            <input type="text" name="name" value="<?php echo $item?$item['name']:'';?>" class="form-control" placeholder="Назва принципу роботи" required/>
                        </p>
                        <p>
                            <input type="hidden" name="id" value="<?php echo $item?$item['id']:'';?>"/>
                            <button class="btn btn-success" type="submit">Зберегти</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</html>