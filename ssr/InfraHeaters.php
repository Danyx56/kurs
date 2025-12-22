<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if(!$_SESSION['user']){
    header('Location: login.php');
}
require_once('../app/InfraHeaterList.php');
require_once('../app/SphereOfApplList.php');
require_once('../app/WorkPrincList.php');
require_once('../app/VendorList.php');
require_once('../app/PropertyList.php');
$workList=new WorkPrincList();
$workList->getAllFromDatabase();
$sphereList=new SphereOfApplList();
$sphereList->getAllFromDatabase();
$vendorList=new VendorList();
$vendorList->getAllFromDatabase();
$propList=new PropertyList();
$propList->getAllFromDatabase();
$propArray=$propList->getAsAssocArray();
$a = new InfraHeaterList();
$item=null;
$itemProps=[];
$errorMessage = '';
if($_SERVER['REQUEST_METHOD']=='POST'){
    if($_POST['id']==""){
        $infraHeaterid=$a->insertIntoDatabase(['vendorid'=>$_POST['vendorid'], 
        'model'=>$_POST['model'],
        'workprincid'=>$_POST['workPrincid'],
        'sphereofapplid'=>$_POST['sphereOfApplid'],  
        'price'=>$_POST['price']
        ]);
        
        if ($infraHeaterid === false) {
            $errorMessage = "Помилка: Обігрівач такої моделі та виробника вже існує!";
            if(isset($_GET['search'])){
                 $a->getAllFromDatabaseBySearchCriteria($_GET['search']);
            }else{
                 $a->getAllFromDatabase();
            }
        } else {
            for ($i=0;$i<count($propArray);$i++){
                if(isset($_POST['prop-'.$propArray[$i]['id']]) && $_POST['prop-'.$propArray[$i]['id']] !== ''){
                    $a->addInfraHeaterProperty($infraHeaterid,$propArray[$i]['id'],$_POST['prop-'.$propArray[$i]['id']]);
                }
            }
            header('Location: InfraHeaters.php');
        }
    } else{
        $result = $a->updateDatabaseById(['id'=>$_POST['id'],
        'vendorid'=>$_POST['vendorid'], 
        'model'=>$_POST['model'],
        'workprincid'=>$_POST['workPrincid'],
        'sphereofapplid'=>$_POST['sphereOfApplid'],   
        'price'=>$_POST['price']]);
        
        if ($result === false) {
             $errorMessage = "Помилка: Інший обігрівач такої моделі та виробника вже існує!";
             if(isset($_GET['search'])){
                 $a->getAllFromDatabaseBySearchCriteria($_GET['search']);
            }else{
                 $a->getAllFromDatabase();
            }
            $item = $_POST;
            $itemProps = [];
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'prop-') === 0) {
                    $itemProps[] = [
                        'propertyid' => substr($key, 5),
                        'value' => $value
                    ];
                }
            }
        } else {
            $propArray=$propList->getAsAssocArray();
            for ($i=0;$i<count($propArray);$i++){
                if(isset($_POST['prop-'.$propArray[$i]['id']])){
                    $a->updateInfraHeaterProperty($_POST['id'],$propArray[$i]['id'],$_POST['prop-'.$propArray[$i]['id']]);
                }
            }
            header('Location: InfraHeaters.php');
        }
    }
} else{
    if(isset($_GET['search'])){
        $a->getAllFromDatabaseBySearchCriteria($_GET['search']);
    }else{
        $a->getAllFromDatabase();
    }
    if(isset($_GET['action'])&&$_GET['action']=='delete'){
        $a->deleteFromDatabaseById($_GET['id']);
        header('Location: InfraHeaters.php');
    } else if(isset($_GET['action'])&&$_GET['action']=='update'){
        $item=$a->getById($_GET['id']);
        $itemProps=$a->getInfraHeaterPropertiesById($_GET['id']);
    }
}
?>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Інфрачервоні обігрівачі</title>
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
            <h1>Інфрачервоні обігрівачі</h1>
            <div class="row">
                <div class="col-md-8">
                    <form method="GET">
                        <input type="text" required name="search" placeholder="Шукати"/>
                        <button type="submit" class="btn btn-primary">Пошук</button>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Модель</th>
                                <th>Виробник</th>
                                <th>Принцип роботи</th>
                                <th>Сфера застосування</th>
                                <th>Ціна</th>
                                <th>Характеристики</th>
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
                            <input type="text" name="model" value="<?php echo $item?$item['model']:'';?>" class="form-control" placeholder="Модель" required/>
                        </p>
                        <p>
                            <select name="vendorid" class="form-select" placeholder="Виробник" required><?php echo $vendorList->getAsSelectOptions($item?$item['vendorid']:'');?></select>
                        </p>
                        <p>
                            <select name="workPrincid" class="form-select" placeholder="Принцип роботи" required><?php echo $workList->getAsSelectOptions($item?$item['workPrincid']:'');?></select>
                        </p>
                        <p>
                            <select name="sphereOfApplid" class="form-select" placeholder="Сфера застосування" required><?php echo $sphereList->getAsSelectOptions($item?$item['sphereOfApplid']:'');?></select>
                        </p>
                        <p>
                            <input type="text" name="price" value="<?php echo $item?$item['price']:'';?>" class="form-control" placeholder="Ціна" required/>
                        </p>
                        <?php echo $propList->getAsInputGroup($itemProps); ?>
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