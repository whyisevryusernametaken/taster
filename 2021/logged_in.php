<?php
	session_start();
	if (empty($_SESSION['username']) || empty($_SESSION['password'])) {
		header('Location: /index.php');
		// Can you spot the vulnerability here?
	}
	require 'credentials.php';

	$conn = mysqli_connect($db, $username, $password, $db_name);

	if (!$conn) exit("Connection failed, please contact a faciltator. Error message:<br><br><pre>" . mysqli_connect_error());
	$query = "SELECT * FROM `users`";
	$sql_result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sieberrsec Users</title>
</head>
<body>
	<h1>List of <img src='logo.jpg' height=50 style='vertical-align:bottom'> users</h1>
	<table>
		<tr>
			<th>User ID</th>
			<th>Username</th>
			<th>Password Hash</th>
		</tr>
		<?php
			while ($row = mysqli_fetch_assoc($sql_result)) {
				echo "<tr><td>{$row['id']}</td><td>{$row['username']}</td><td>{$row['password']}</td></tr>";
			}
			mysqli_close($conn);
		?>
	</table>
</body>
</html>