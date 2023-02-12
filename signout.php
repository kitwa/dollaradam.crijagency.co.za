<?php
session_start();
session_destroy();
session_unset();
setcookie("CrijC", "0813878054", time() - 3600, "/");
header("Location: index.php");
exit(); // important
?>