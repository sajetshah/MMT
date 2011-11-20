#!/usr/local/bin/php

<?php session_start();

	if (!isset($_SESSION['email']))
	{
		header("Location:index.php");
	}
	
	if (!require("mainBar.php"))
	{
		die("Failed to include mainbar!");
	}
?>

<html>
<head><title>Give Details - MMT</title>
</head>

<body>
	<br /></br >
	<table border = "1">
	<?php
		$firstRow = 1;
		$query = "select email_add as friend, sum (with_amt) as amt from participates where with_username = '".$_SESSION['email']."' group by email_add order by amt";
		$statement = oci_parse($connection, $query);
		if (!oci_execute($statement))
		{
			die($query);
		}

		while ($row = oci_fetch_object($statement))
		{
			if ($firstRow == 1)
			{
				echo "<tr><td>Friend</td><td>Amount</td></tr>";
				$firstRow = 0;
			}
			echo "<tr><td>".$row->FRIEND."</td><td>".$row->AMT."</td></tr>";
		}
	?>
	</table>
</body>
</html>
