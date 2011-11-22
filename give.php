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
	<table class = "transactions">
	<?php
		$firstRow = 1;
		$query = "select email_add as friend, sum (with_amt) as amt from participates where with_username = '".$_SESSION['email']."' group by email_add order by amt";
		$amtSet = "";
		$amtLabelSet = "";
		$nameSet = "";
		$statement = oci_parse($connection, $query);
		if (!oci_execute($statement))
		{
			die($query);
		}

		while ($row = oci_fetch_object($statement))
		{
			if ($firstRow == 1)
			{
				echo "<tr><td class = 'transactions'>Friend</td><td class = 'transactions'>Amount</td></tr>";
				$firstRow = 0;
				$amtSet = "".$row->AMT;
				$amtLabelSet = $row->FRIEND." (".$row->AMT.")";
				$nameSet = "".$row->FRIEND;
			}
			else
			{
				$amtSet = $amtSet.",".$row->AMT;
				$amtLabelSet = $amtLabelSet."|".$row->FRIEND." (".$row->AMT.")";
				$nameSet = $nameSet."|".$row->FRIEND;
			}
			echo "<tr><td class = 'transactions'>".$row->FRIEND."</td><td class = 'transactions'>".$row->AMT."</td></tr>";
		}
	?>
	</table>
	
	<img src="http://chart.apis.google.com/chart?chs=700x300&cht=p3&chd=t:<?=$amtSet?>&chl=<?=$amtLabelSet?>&chdl=<?=$nameSet?>&chdlp=b&chtt=Your Breakup" alt="Title" />
</body>
</html>
