<?php
include 'autoload.php';
Core::Instance()->Call(isset($_GET['page']) ? $_GET['page']:'Articles',$_REQUEST);
?>
