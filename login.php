<?php
	/**
	
			Login script

	**/
	if(isset($_POST['user']) && isset($_POST['pass']))
	{

		$sql = "SELECT * FROM `admins` WHERE admin_name='" . $_POST['user'] . "' AND `admin_password`='" . $_POST['pass'] . "';";

		$result = $db->query($sql);

		if($result)
		{
			// login succeeded
			$_SESSION['logged_in'] = true;
			printf('<script>location.href="index.php"</script>');
		}
		else
		{
			// login failed
			$_SESSION['logged_in'] = false;
		}
	}
?>
<div id="login">
	<form method="POST" action="index.php">
		<ul>
			<li>
				<label for="user">Username:</label>
				<input type="text" id="user" name="user"/>
			</li>
			<li>
				<label for="pass">Password:</label>
				<input type="password" id="pass" name="pass"/>
			</li>
			<li>
				<input type="submit" value="Enter" id="submit">
			</li>
		</ul>
	</form>
</div>