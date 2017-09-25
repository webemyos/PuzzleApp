<?php
include ('Insert.php');

class InsertMenuItem extends Insert
{
	function ShowInsert()
	{
		echo "<subitem name='About' action='About' img='../Images/icones/info.png' />";
	}
}


?>