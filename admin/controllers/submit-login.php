<?php

session_start();
include('dbconnect.php');

if (isset($_POST['login'])) {

	$email = $_POST['email'];
	$password = $_POST['password'];

	$sql = "SELECT * FROM users WHERE email= '$email' AND password= '$password'";
	$query = mysqli_query($conn, $sql) or die("Update Query Failed");
	$row = mysqli_num_rows($query);
	if ($row == 0) {
		// Jump to indexwrong page
		echo "<script> alert('Wrong email or password')</script>";
		echo "<script>location.href='$base_url/admin/login'</script>";
	} else {
		$r = mysqli_fetch_assoc($query);

		if ($r['user_type'] == "admin") { // Admin
			// Set session variables
			$_SESSION['email'] = $r['email'];
			$_SESSION['user_id'] = $r['user_id'];
			$_SESSION['user_type'] = $r['user_type'];

			// Redirect back to the stored URL or a default page
			if (isset($_SESSION['redirect_url'])) {
				$redirect_url = $_SESSION['redirect_url'];
				unset($_SESSION['redirect_url']); // Unset the stored URL after redirecting
				header("Location: $redirect_url");
				exit;
			} else {
				header("Location: $base_url/admin/dashboard"); // Default redirect for admin
				exit;
			}
		}
		// elseif ($r['user_type'] == "agent") { // Admin
		// 	// Set session variables
		// 	$_SESSION['email'] = $r['email'];
		// 	$_SESSION['user_id'] = $r['user_id'];
		// 	$_SESSION['user_type'] = $r['user_type'];

		// 	// Redirect back to the stored URL or a default page
		// 	if (isset($_SESSION['redirect_url'])) {
		// 		$redirect_url = $_SESSION['redirect_url'];
		// 		unset($_SESSION['redirect_url']); // Unset the stored URL after redirecting
		// 		header("Location: $redirect_url");
		// 		exit;
		// 	} else {
		// 		header("Location: $base_url/agent/dashboard"); // Default redirect for admin
		// 		exit;
		// 	}
		// }
		else {
			echo "<script> alert('You are not admin')</script>";
			echo "<script>location.href='$base_url/admin/login'</script>";
		}
	}
}
mysqli_close($conn);
