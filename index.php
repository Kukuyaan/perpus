<?php

	include 'koneksi.php';

	session_start();

	if (isset($_SESSION['username'])) {
		if ($_SESSION['lvl']=="admin") {
			header("Location: dashboard-admin.php");
		} else if ($_SESSION['lvl']=="user") {
			header("Location: dashboard-user.php");
		}
	}
	error_reporting(0);

	if (isset($_POST['reg'])) {
		$username 	= 	$_POST['username'];
		$email 		= 	$_POST['signup-email'];
		$nis	 	= 	$_POST['nis'];
		$password 	= 	md5($_POST['signup-password']);
		$cpassword 	=	md5($_POST['signup-cpassword']);

		$chek_email = 	mysqli_num_rows(mysqli_query($koneksi, "SELECT email FROM user WHERE email = '$email'"));
		$chek_nis 	= 	mysqli_num_rows(mysqli_query($koneksi, "SELECT nis FROM user WHERE nis = '$nis'"));
		if ($password !== $cpassword) {
			echo "<script>alert('Password tidak sama!')</script>";
		}	elseif ($chek_email > 0) {
			echo "<script>alert('Email sudah dipakai!')</script>";
		}	elseif ($chek_nis > 0) {
			echo "<script>alert('NIS already dipakai!')</script>";
		}	else {
			$sql = "INSERT INTO user ( username , email , nis , password , lvl) VALUES ( '$username' , '$email' , '$nis' , '$password' , 'user') ";
			$result = mysqli_query($koneksi, $sql);
			if ($result) {
				$_POST['username']			= "" ;
				$_POST['signup-email']		= "" ;
				$_POST['nis']				= "" ;
				$_POST['signup-password']	= "" ;
				$_POST['signup-cpassword']	= "" ;
				echo "<script>alert('Pendaftaran berhasil')</script>";
			} else {
				echo "<script>alert('Pendaftaran gagal')</script>";
			}
		}
	}
	if (isset($_POST['login'])) {
		$email 		= 	$_POST['email'];
		$password 	= 	md5($_POST['password']);

		$chek_email =	mysqli_query($koneksi, "SELECT * FROM user WHERE email = '$email' AND password = '$password'");


		if (mysqli_num_rows($chek_email) > 0) {
			$row = mysqli_fetch_assoc($chek_email);

			if ($row['lvl']=='admin') {
			$_SESSION["username"] = $row['username'];
			$_SESSION["lvl"] = "admin";
			header("Location: dashboard-admin.php");

			} elseif ($row['lvl']=='user') {
				$_SESSION["username"] = $row['username'];
				$_SESSION["lvl"] = "user";
				header("Location: menu_user.php");
			}
		}  else {
			echo "<script>alert('Gagal login! coba lagi.')</script>";
		}
	}
 ?>

<html>
	<head>
		<link href='img\maput.png' rel='shortcut icon' >
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Perpustakaan</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<section>	
			<div class="container">
				<div class="user signinBx">
					<div class="imgBx"><img src="img\img1.jpg"></div>
					<div class="formBx">
						<form method="post" action="">
							<h2>Sign In</h2>
							<input type="text" placeholder="Email" name="email" value="<?php echo $_POST['email']; ?>" required />
							<input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required />
							<input type="submit" value="Login" name="login">
							<p class="signup">don't have an account? <a href="#" onclick="toggleForm();">Sign up.</a></p>
						</form>
					</div>
				</div>

				<div class="user signupBx">
						<div class="formBx">
							<form method="post" action="">
								<h2>Create an account</h2>
								<input type="text" placeholder="Username" name="username" value="<?php echo $_POST['username']; ?>" required />
								<input type="text" placeholder="Email Address" name="signup-email" value="<?php echo $_POST['signup-email']; ?>" required />
								<input type="text" placeholder="Nomor Induk Siswa" name="nis" value="<?php echo $_POST['nis']; ?>" required />
								<input type="password" placeholder="Create Password" name="signup-password" value="<?php echo $_POST['signup-password']; ?>" required />
								<input type="password" placeholder="Confirm Password" name="signup-cpassword" value="<?php echo $_POST['signup-cpassword']; ?>" required />
								<input type="submit" value="Sign Up" name="reg">
								<p class="signup">already have an account? <a href="#" onclick="toggleForm();">Sign in.</a></p>
							</form>
						</div>
					<div class="imgBx"><img src="img\img2.jpg"></div>
					</div>
				</div>
			</section>
		<script>
			function toggleForm() 
			{
				section = document.querySelector('section');
				container = document.querySelector('.container');
				container.classList.toggle('active');
				section.classList.toggle('active');
			}

			
		</script>

		
	</body>
</html>

