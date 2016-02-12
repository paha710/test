<?php
include 'autoload.php';
var_dump();
Core::Instance()->Call(isset($_GET['page']) ? $_GET['page']:'Articles',$_REQUEST);
?>