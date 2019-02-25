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

Runner::Run("PuzzleApp", GetEnvironnement(), false);

?>
