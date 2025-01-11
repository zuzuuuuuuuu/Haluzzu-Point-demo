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
		echo "<script>location.href='$base_url/log-in'</script>";
	} else {
		$r = mysqli_fetch_assoc($query);

		if ($r['user_type'] == "admin") { // Admin

			// if (isset($_SESSION['redirect_url'])) {
			// 	$redirect_url = $_SESSION['redirect_url'];
			// 	unset($_SESSION['redirect_url']); // Unset the stored URL after redirecting
			// 	header("Location: $redirect_url");
			// 	exit;
			// } else {
			// 	header("Location: $base_url/admin/dashboard"); // Default redirect for admin
			// 	exit;
			// }
			header("Location: $base_url"); // Default redirect for admin

		} elseif ($r['user_type'] == "agent") { // Admin
			// Set session variables
			$_SESSION['email'] = $r['email'];
			$_SESSION['user_id'] = $r['user_id'];
			$_SESSION['user_type'] = $r['user_type'];

			echo $_SESSION['redirect_url'];
			// Redirect back to the stored URL or a default page
			if (isset($_SESSION['redirect_url']) && !empty($_SESSION['redirect_url'])) {
				echo "1111";

				$redirect_url = $_SESSION['redirect_url'];
				unset($_SESSION['redirect_url']); // Unset the stored URL after redirecting
				session_write_close(); // Save and close the session
				header("Location: $redirect_url");
				exit;
			} else if (isset($_GET['redirect'])) {
				echo "222";

				// Decode the redirect URL to ensure it's usable as a location header
				$redirect_url = urldecode($_GET['redirect']);
				header("Location: $redirect_url");
				exit;
			} else {
				echo "3333222";

				// Default redirection if no redirect URL is provided
				header("Location: $base_url/agent/dashboard");
				exit;
			}
		} else { // Normal user
			// Set session variables
			$_SESSION['email'] = $r['email'];
			$_SESSION['user_id'] = $r['user_id'];
			$_SESSION['user_type'] = $r['user_type'];

			// Redirect back to the stored URL or a default page
			if (isset($_SESSION['redirect_url']) && !empty($_SESSION['redirect_url'])) {
				// echo "Redirect URL exists: " . $_SESSION['redirect_url'] . "<br>";
				$redirect_url = $_SESSION['redirect_url'];
				// echo "Redirecting to: " . $redirect_url . "<br>";
				unset($_SESSION['redirect_url']);
				session_write_close();
				header("Location: $redirect_url");
				exit;
			} else {
				// echo "Redirect URL does not exist. Redirecting to homepage.<br>";
				header("Location: $base_url/homepage");
				exit;
			}
		}
	}
}
mysqli_close($conn);
