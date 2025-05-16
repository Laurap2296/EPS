<?php
session_start();
session_destroy(); // Destruye toda la sesión
header('Location: ../login.php'); // Redirige al login
exit();
