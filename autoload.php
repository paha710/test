<?php
include 'views/libs/Smarty.class.php';

function autoloadClasses($class) {
    $file = 'controller/'.$class.'.php';
    if(!is_file($file)) {
        $file = 'models/'.$class.'.php';
    }

    if(!is_file($file)){
        $file = 'views/libs/'.$class.'.php';
    }
        include_once($file);

}

spl_autoload_register('autoloadClasses');