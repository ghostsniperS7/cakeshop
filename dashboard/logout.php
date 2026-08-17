<?php
session_start();
session_destroy();
header("Location: ../project/index.php");
exit();
?>