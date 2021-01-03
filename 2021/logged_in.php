<?php
	session_start();
	if (empty($_SESSION['username']) || empty($_SESSION['password'])) {
		header('Location: /index.php');
		// Can you spot the vulnerability here?
	}
	require 'credentials.php';
	
	if ($_SESSION['username'] === 'admin' && $_SESSION['password'] === $admin_password) {
		exit("<img src={$secret_image} width=500>");
	}

	$conn = mysqli_connect($db, $username, $password, $db_name);

	if (!$conn) exit("Connection failed, please contact a faciltator. Error message:<br><br><pre>" . mysqli_connect_error());
	$query = "SELECT `id`, `username` FROM `users`";
	if (isset($_GET['search'])) $query = "SELECT `id`, `username` FROM `users` WHERE `username` LIKE '%{$_GET['search']}%'";
	$sql_result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sieberrsec Users</title>
</head>
<body>
	<form>
		<input placeholder='Search...' name='search'>
		<button>Search</button>
	</form>
	<h1>List of users</h1>
	<table>
		<tr>
			<th>User ID</th>
			<th>Username</th>
		</tr>
		<?php
			while ($row = mysqli_fetch_assoc($sql_result)) {
				echo "<tr><td>{$row['id']}</td><td>{$row['username']}</td></tr>";
			}
			mysqli_close($conn);
		?>
	</table>
</body>
</html>