<!doctype html>
<html lang="en" class="h-full">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php require('components/imports.php'); ?>
	<title>SOUNDSEE.NET </title>
</head>

<?php

require('config/connect.php');

session_start();
$user = $_SESSION['user'];
if ($user) {
	echo "<script>alert('Please logout to access this page.'); location.href = 'home.php';</script>";
}

$doRegister = $_POST['doRegister'];

if ($doRegister === 'on') {
	$username = $_POST['username'];
	$phoneNumber = $_POST['phoneNumber'];
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$fullName = $firstName . " " . $lastName;
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirmPassword = $_POST['confirmPassword'];

	$check = $db->Execute('SELECT * FROM user WHERE username=? OR phoneNumber=?', [$username, $phoneNumber]);
	if ($check) {
		$alertType = "danger";
		$alert = "Username or Phone number is duplicate";
	} else {
		if ($password === $confirmPassword && $password && $confirmPassword) {
			$d = $db->Execute("INSERT INTO user (username, phoneNumber, name, email, password) VALUES (?,?,?,?,?)", [$username, $phoneNumber, $fullName, $email, $password]);
			$username = '';
			$phoneNumber = '';
			$firstName = '';
			$lastName = '';
			$email = '';
			$alert = "Registration success";
			$alertType = "success";
		} else {
			$alertType = "danger";
			$alert = "Password note same";
		}
	}
}

?>

<body class="h-full unauth">
	<div class="flex form-wrapper flex-col h-full justify-center items-center">
		<?php if (isset($alertType)) { ?>
			<div class="alert alert-<?php echo $alertType ?>" role="alert">
				<?php echo $alert; ?>
			</div>
		<?php } ?>
		<form class="flex flex-col" method="POST" action="register.php">
			<input type="checkbox" name="doRegister" checked class="hidden" />
			<h2 class="mb-4">Register your account</h2>
			<div class="input-group mb-3">
				<span class="input-group">Username</span>
				<input type="text" class="form-control" name="username" value="<?php echo $username; ?>" required />
			</div>
			<div class="input-group mb-3">
				<span class="input-group">Phone number</span>
				<input type="number" class="form-control" name="phoneNumber" value="<?php echo $phoneNumber; ?>" required />
			</div>
			<div class="input-group mb-3">
				<span class="input-group">First Name</span>
				<input type="text" class="form-control" name="firstName" value="<?php echo $firstName; ?>" required />
			</div>
			<div class="input-group mb-3">
				<span class="input-group">Last Name</span>
				<input type="text" class="form-control" name="lastName" value="<?php echo $lastName; ?>" required />
			</div>
			<div class="input-group mb-3">
				<span class="input-group">E-mail Address</span>
				<input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required />
			</div>
			<div class="input-group mb-3">
				<span class="input-group">Password</span>
				<input type="password" class="form-control" name="password" required />
			</div>
			<div class="input-group mb-3">
				<span class="input-group">Confirm Password</span>
				<input type="password" class="form-control" name="confirmPassword" required />
			</div>
			<div class="flex justify-between">
				<a href="login.php" class="flex flex-1 justify-center items-center btn btn-outline">
					<i class="fa text-primary fa-chevron-left pr-1"></i>
					<label class="text-primary">Login</label>
				</a>
				<div class="p-1"></div>
				<button type="submit" class="flex flex-1 justify-center btn btn-primary">Register</button>
			</div>
		</form>
	</div>
</body>

</html>