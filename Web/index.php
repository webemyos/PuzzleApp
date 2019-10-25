<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

include("../environment.php");
include("../autoload.php");
include("../Core/Runner.php");

$env = GetEnvironnement();

Runner::Run("PuzzleApp", $env, $env == "dev");

?>
