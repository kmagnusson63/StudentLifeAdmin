<?php
	/**

			Main Admin script

	**/

	// Display nav_bar
	nav_bar($db);

	// Action controller
	if(isset($_GET['t']))
	{
		$table = $_GET['t'];
		// var_dump($_POST);
		if(isset($_POST['delete']))
		{
			display_row($db, $table, $_POST['id']);
		}
		elseif(isset($_POST['edit']))
		{
			$result = getRow($db, $table, $_POST['id']);
			display_edit_row($table, $result);
		}
		elseif(isset($_POST['update']))
		{
			updateDataIntoTable($db, $table);
		}
		elseif(isset($_POST['confirm']))
		{
			deleteRow($db, $table, $_POST['id_name'], $_POST['id']);
		}
		elseif(isset($_POST['insert']))
		{
			insertDisplay($db, $table);
		}
		elseif(isset($_GET['a']) && $_GET['a'] == 'list' && $_GET['t'] == 'events')
		{
			require('events.php');
		}
		else
		{
			display_table($db, $table);
		}
	}
?>