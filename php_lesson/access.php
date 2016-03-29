<?php
define('READ',1);
define('UPDATE',2);
define('DELETE',4);
define('CREAT',8);

$user_access =1;

echo 'Read : '.(bool)(READ & $user_access)."\n";
echo 'Update : '.(bool)(UPDATE & $user_access)."\n";
echo 'Delete : '.(bool)(DELETE & $user_access)."\n";
echo 'Create : '.(bool)(CREATE & $user_access)."\n";