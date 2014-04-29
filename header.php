<!-- Markup for header -->


<header>
	<a href="index.php"><img src="img/rrc_logo.png" alt="Red River College"></a>
	<a href="index.php"><p>Student Life App Admin Portal</p></a>
	<?php
		if($_SESSION['logged_in'])
		{
			?>
				<a href="index.php?logout">Sign Out</a>
			<?php
		}
	?>
</header>