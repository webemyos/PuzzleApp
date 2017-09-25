<?php
include ('Insert.php');

class InsertMenu extends Insert
{
	function ShowInsert()
	{
		echo "<menu>
		<item name='File' text='File'>
			<subitem name='Quit' text='Quit'  action='Quit' img = '../Images/icones/exit.png'/>
		</item>
		<item name='?' text='?'>
			<subitem name='About' action='About' img='../Images/icones/info.png' />
			<subitem name='Help' action='Help' img='../Images/icones/help.png' />
			<subitem name='ReportBug' action='ReportBug' img='../Images/icones/bug.png' />
		</item>
	</menu>";
	}
}


?>