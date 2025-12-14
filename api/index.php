<?php
$path= $_SERVER['REQUEST_URI'];
if(str_contains($path, 'WorkPrincs')){
    require_once('./WorkPrincs.php');
} else if(str_contains($path, 'SpheresOfAppl')){
    require_once('./SpheresOfAppl.php');
} else if(str_contains($path, 'Properties')){
    require_once('./Properties.php');
} else if(str_contains($path, 'Heaters')){
    require_once('./Heaters.php');
} else if(str_contains($path, 'Profile')){
    require_once('./Profile.php');
} else{
    echo "Invalid route";
}
?>