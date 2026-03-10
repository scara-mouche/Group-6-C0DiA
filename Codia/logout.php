<?php
session_start();
session_unset();   // burahin lahat ng session variables
session_destroy(); // sirain ang session
header("Location: index.php"); // redirect sa login page
exit();
?>