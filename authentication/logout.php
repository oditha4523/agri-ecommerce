<?php
session_start();
session_unset();
session_destroy();
header("Location: ../shared/index.php");
exit();
?>
