<?php 

require '../connection.php'; 

session_start();
session_destroy();
echo '<script>document.location.href="login.php"</script>';