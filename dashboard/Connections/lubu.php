<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_lubu = "localhost";
$database_lubu = "tfwsmg";
$username_lubu = "root";
$password_lubu = "";
$lubu = mysql_pconnect($hostname_lubu, $username_lubu, $password_lubu) or trigger_error(mysql_error(),E_USER_ERROR); 
?>