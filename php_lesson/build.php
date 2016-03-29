<?php
include'models/Model.php';
include 'views/libs/config.php';
include 'views/libs/DB.php';

$models = array();
$handle = opendir(Config::$path['model']);
while(false !== ($rd = readdir($handle))){
    if($rd != '.' && $rd != '..' && $rd != 'Model.php'){
        $models[]=Config::$path['model'].$rd;
    }
}


foreach($models as $model){
    require_once($model);
    $modelName = str_replace(array('./models/','.php'),'',$model);
   $modelName::Generate($modelName);
}