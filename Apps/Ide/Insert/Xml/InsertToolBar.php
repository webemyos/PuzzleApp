<?php
include ('Insert.php');

class InsertToolBar extends Insert
{
	function ShowInsert()
	{
		echo "<toolbar>
		<tool img='Add.png' action='New' title='NewProject' />
		<tool img='Play.png' action='Play' title='Play' />
	</toolbar>";
	}
}


?>