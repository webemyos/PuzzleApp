<?php
include ('Insert.php');

class InsertModule extends Insert
{
	function ShowInsert()
	{
		echo "--   Interface -----------";
		echo "<module type='ProjectBlock'>
			<property Name='App' Value='EExplorer'></property>
			</module>";

		echo "--      Code PHP ---------";
		echo "if(!class_exists('AppCategoryBlock'))
  			include('AppCategoryBlock.php');";
	}
}


?>