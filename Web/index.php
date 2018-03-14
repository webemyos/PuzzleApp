<?php
   header('access-control-allow-origin: *'); 
   header('access-control-allow-credentials:true');
   header('access-control-allow-methods:GET, POST, OPTIONS, PUT, PATCH, DELETE');
   //header('Content-Type: application/json');
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */
   


include("../autoload.php");
include("../Core/Runner.php");
Runner::Run("PuzzleApp", "dev", true);

?>
