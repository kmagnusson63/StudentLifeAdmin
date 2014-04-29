<?php
	/**
	
		Functions script

		Places all functions required into 1 script

	**/

	/*
		Formats timestamps to a human-friendly format (e.g. "2 hours ago")
	*/
	define('DB_TIMESTAMP_FORMAT','Y-m-d H:i:s');
	define('HUMAN_TIME_FORMAT','M j, Y g:ia');
	function human_time($db_time)
	{
		$temp = date_create_from_format(DB_TIMESTAMP_FORMAT,$db_time);
		$new_time = date_format($temp,HUMAN_TIME_FORMAT);
		return $new_time;
	}

	/*
		Display list of tables names in the database as a navigation bar,
		linking to individual pages for tables
	*/
	function nav_bar($db)
	{
		
			echo '<div id="table_list">';
			echo '<h2>Tables</h2>';
			echo '<ol>';
			echo '<li><a href="index.php?a=list&amp;t=events">Events</a></li>';
			echo '<li><a href="index.php?a=list&amp;t=posts">Posts</a></li>';
			echo '<li><a href="index.php?a=list&amp;t=official_links">Official Links</a></li>';
			echo '<li><a href="index.php?a=list&amp;t=tokens">Tokens</a></li>';
			echo '<li><a href="index.php?a=list&amp;t=users">Users</a></li>';

			echo '</ol>';
			echo '</div>';
	}

	/*
		Formats field/column names of table to appropriate names
	*/
	function stripTableNameFromFieldName( $table_name, $field_name)
	{
		$temp = substr($field_name, strlen($table_name));
		$return = str_replace("_"," ", $temp);
		return $return;
	}

	// function displayEvents($db)
	// {

	// }

	/*
		Displays table
	*/
	function display_table($db, $table)
	{
		$data_limit = 10;
		if( isset($_GET{'page'} ) )
		{
		   $page = $_GET{'page'} + 1;
		   $offset = $data_limit * $page ;
		}
		else
		{
		   $page = 0;
		   $offset = 0;
		}

		
		$sql = "SELECT * FROM `" . $table . "`".
				" ORDER BY " . stripPlural($table) . "_id DESC" . 
				" LIMIT " . $offset . ", " . $data_limit;
		$results = $db->query($sql);

		$data_count = $results->num_rows;
		if($results->num_rows < 1)
		{
			echo '<p>no results</p>';
		}
		else
		{
			echo '<script type="text/javascript" src="js/main.js"></script>';
			echo '<div id="table">';
			echo '<form method="post" action="index.php?t=' . $table . '">';
			echo '<div id="form_crud_top">';
			echo '<input type="submit" name="edit" value="edit" >';
			echo '<input type="submit" name="delete" value="delete" >';
			echo '<input type="submit" name="insert" value="insert" >';
			echo '</div>';
			echo '<div id="table_wrapper">';
			echo '<table>';
			echo '<caption>"' . $table . '" Table</caption>';
			
			echo '<tr>';
			echo '<th><input id="all" type="checkbox" name="all" value="all" ></th>';
			$fields = $results->fetch_fields();
			foreach ($fields as $field ) {
				echo '<th>'.stripTableNameFromFieldName($table, $field->name).'</th>';
			}
			echo '</tr>';

			while($row = $results->fetch_assoc())
			{
				echo '<tr>';
				echo '<td><input class="checkbox" type="checkbox" name="id" value="' . $row[$fields[0]->name] . '" ></td>';
				foreach ($fields as $field ) {
					# code...
					echo '<td>' . $row[$field->name] . '</td>';
				}
				echo '</tr>';
			}
			echo '</table>';

			
			echo '</div>';
			if($page > 0 && $data_count == $data_limit)
			{
				$last = $page - 2;
				echo '<div id="paging">';
				echo '<a id="last_page" href="index.php?a=list&amp;t=' . $table . '&amp;page=' . $last . '">Last 10</a> | ';
				echo '<a id="next_page" href="index.php?a=list&amp;t=' . $table . '&amp;page=' . $page . '">Next 10</a>';
				echo '</div>';

			}
			else if($page == 0)
			{
				echo '<div id="paging">';
				echo '<a id="next_page" href="index.php?a=list&amp;t=' . $table . '&amp;page=' . $page . '">Next 10</a>';
				echo '</div>';
			}
			else if($data_limit > $data_count)
			{
				$last = $page - 2;
				echo '<div id="paging">';
				echo '<a id="last_page" href="index.php?a=list&amp;t=' . $table . '&amp;page=' . $last . '">Last 10</a>';
				echo '</div>';
			}


			echo '<div id="form_crud_bottom">';
			echo '<input type="submit" name="edit" value="edit" >';
			echo '<input type="submit" name="delete" value="delete" >';
			echo '<input type="submit" name="insert" value="insert" >';
			echo '</div>';
			echo '</form>';
			echo '</div>';
		}
	}

	/*
		Display table field/column names
	*/
	function displayFieldNames($table, $results)
	{
		$fields = $results->fetch_fields();
		foreach ($fields as $field ) {
			echo '<th>'.stripTableNameFromFieldName($table, $field->name).'</th>';
		}
	}

	/*
		Formats plural table names to singular
	*/
	function stripPlural($string)
	{
		return substr($string, 0, -1);
	}

	/*
		Gets data from database
	*/
	function getRow($db, $table, $id)
	{
		$new_sql = "SELECT * FROM `" . $table . "` WHERE " . stripPlural($table) . "_id=" . $id . ";";
		$result = $db->query($new_sql);
		return $result;
	}

	/*
		Displays form to edit/update data in tables
	*/
	function display_edit_row($table, $results)
	{
		echo '<div id="table" class="edit_table">';
		echo '<form method="post" action="index.php?t=' . $table . '">';
		echo '<table>';
		echo '<caption>EDIT "' . $table . '" Table</caption>';
		
		echo '<tr>';
		$fields = $results->fetch_fields();
		displayFieldNames($table, $results);
		echo '</tr>';
		echo '<tr>';
		$row = $results->fetch_assoc();
		foreach ($fields as $field ) {
			# code...
			$temp_field_name = stripPlural($table) . "_id";
			echo '<td><input type="text" name="' . $field->name . '" value="' . $row[$field->name] . '"';
			if($field->name == $temp_field_name)
			{
				echo ' readonly';
			}
			echo ' ></td>';
		}
		echo '</tr>';
		echo '<tr>';
		echo '<td><input type="submit" name="update" value="update"></td>';
		echo '</tr>';
		echo '</table>';
		echo '</form>';
		echo '</div>';
	}

	/*
		Updates data inputted from edit form
	*/
	function updateDataIntoTable($db, $table)
	{
		$sql = 'SELECT * FROM ' . $table . ' LIMIT 1';
		$results = $db->query($sql);
		$fields = $results->fetch_fields();

		$insert_sql = 'UPDATE ' . $table . ' SET ';
		for($i = 0; $i < count($fields); ++$i)
		{

			if($i == 0)
			{
				$where = ' WHERE ' . $fields[$i]->name . '="' . $_POST[$fields[$i]->name] . '"';
			}
			else
			{
				$insert_sql = $insert_sql . $fields[$i]->name . '="' . $_POST[$fields[$i]->name] . '"';
			}
			if(($i > 0) && $i < (count($fields)-1))
			{
				$insert_sql = $insert_sql . ", ";
			}
		}
		$insert_sql = $insert_sql . $where;

		$result = $db->query($insert_sql);

		if($result)
		{
			echo "Updated entry";
		}
		else
		{
			echo "Error updating entry";
		}
	}

	/*
		Displays selected data to be deleted
	*/
	function display_row($db, $table, $id)
	{
		$sql = 'SELECT * FROM `' . $table . '` WHERE ' . stripPlural($table) . '_id="' . $id . '"';
		$results = $db->query($sql);
		$fields = $results->fetch_fields();
		$rows = $results->fetch_assoc();
		
	?>
		<div id="table">
			<form method="POST" action=<?= '"index.php?t=' . $table . '"' ?> >
				<table id="delete_table">
					<caption><?= "Delete" ?></caption>
					<tr>
						<?php
							foreach ($fields as $field)
							{
						?>
								<th><?= $field->name ?></th>
						<?php
							}
						?>
					</tr>
						
					<tr>
						<?php
							foreach ($fields as $field)
							{
						?>
								<td><?= $rows[$field->name] ?></td>
						<?php
							}
						?>
					</tr>
						
				</table>
				
				<input type="hidden" name="id" value= <?= '"' . $rows[$fields[0]->name] .'"' ?> >
				<input type="hidden" name="id_name" value= <?= '"' . $fields[0]->name .'"' ?> >
				<input type="submit" name="confirm" value="Confirm?">
			</form>
		</div>
	<?php
	}

	/*
		Deletes selected data
	*/
	function deleteRow($db, $table, $id_name, $id)
	{
		$sql = 'DELETE FROM ' . $table . ' WHERE ' . $id_name . '="' . $id . '"';
		
		$result = $db->query($sql);
		header('Location: index.php?t=' . $table);
	}

	/*
		Inserts new data into table
	*/
	function insertDisplay($db, $table)
	{
		$sql = "DESCRIBE " . $table;

		$result = $db->query($sql);

		$fields = $result->fetch_assoc();

		var_dump($fields);
	}
?>