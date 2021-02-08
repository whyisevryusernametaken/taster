<?php
	if (!empty($_POST['username']) && !empty($_POST['password'])) {
		require 'credentials.php';
		$conn = mysqli_connect($db, $username, $password, $db_name);

		if (!$conn) exit("Connection failed, please contact a faciltator. Error message:<br><br><pre>" . mysqli_connect_error());
		$password_hash = md5($_POST['password']);
		$query = "SELECT `id` FROM `users` WHERE `username`='admin'-- AND `password`='{$password_hash}'";
		$sql_result = mysqli_query($conn, $query);

		if (mysqli_num_rows($sql_result) > 0) {
			// User with matching username and password found
			session_start();
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['password'] = $_POST['password'];
			header('Location: /logged_in.php');
			mysqli_close($conn);
		} else {
			$incorrect = true;
		}
		mysqli_close($conn);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sieberrsec</title>
</head>
<body>
	<h1>Welcome to Sieberrsec!</h1>
	<form method='post'>
		<input placeholder='Username' name='username'>
		<input placeholder='Password' type='password' name='password'>
		<button>Log in</button>
		<?php
			if (isset($incorrect)) echo 'Incorrect credentials! Please try again.';
		?>
	</form>
</body>
</html>
