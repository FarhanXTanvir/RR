<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RouteRover</title>

    <!-- Style Sheet -->
    <link rel="stylesheet" href="rpstyle.css">
	<link rel="stylesheet" href="footer.css">
	<link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Font Family -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
  <header>
    <div class="cover">
      <h1>R<span>oute</span> R<span>over</span></h1>
      <p>Your one-stop travel companion</p>
    </div>
  
    <!-- Navigation bar -->
    <nav class="top-nav">
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="services.html">Services</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="index.html#contact">Contact</a></li>
      </ul>
    </nav>
  </header>
  <section id="#about" class="about">
  <?php
		// Change this to your connection info.
		$DATABASE_HOST = 'localhost';
		$DATABASE_USER = 'root';
		$DATABASE_PASS = '123456';
		$DATABASE_NAME = 'RouteRover';
		// Try and connect using the info above.
		$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
		if (mysqli_connect_errno()) {
			// If there is an error with the connection, stop the script and display the error.
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
		}
		// Now we check if the data was submitted, isset() function will check if the data exists.
		if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
			// Could not get the data that should have been sent.
			exit('Please complete the registration form!');
		}
		// Make sure the submitted registration values are not empty.
		if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
			// One or more values are empty.
			exit('Please complete the registration form');
		}
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			exit('Email is not valid!');
		}
		if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
			exit('Username is not valid!');
		}
		if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
			exit('Password must be between 5 and 20 characters long!');
		}
		// We need to check if the account with that username exists.
		if ($stmt = $con->prepare('SELECT id, password FROM users WHERE username = ?')) {
			// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
			$stmt->bind_param('s', $_POST['username']);
			$stmt->execute();
			$stmt->store_result();
			// Store the result so we can check if the account exists in the database.
			if ($stmt->num_rows > 0) {
				// Username already exists
				echo 'Username exists, please choose another!';
			} else {
				// Username doesn't exists, insert new account
				if ($stmt = $con->prepare('INSERT INTO users (username, password, email) VALUES (?, ?, ?)')) {
					// We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
					$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
					$stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
					$stmt->execute();
					echo 'You have successfully registered! You can now login!
					<a href="login.html"><button>Login</button></a>
					';
				} else {
					// Something is wrong with the SQL statement, so you must check to make sure your users table exists with all three fields.
					echo 'Could not prepare statement!';
				}
			}
			$stmt->close();
		} else {
			// Something is wrong with the SQL statement, so you must check to make sure your users table exists with all 3 fields.
			echo 'Could not prepare statement!';
		}
		$con->close();
	?>
    <!-- <h2>About Us</h2>
    <div class="content">
     <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
     <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
     <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
     <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
    </div> -->
  </section>
<!------------------- Footer Section ----------------->
  <footer>
    <div class="ftop">

    </div>
    <div class="fbtm">
      <div class="copyright">
        <p>
          &copy; 2024 Route Rover. All rights reserved
        </p>
      </div>
      <div class="legal">
        <ul>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Terms & Condition</a></li>
          <li><a href="#">Payment Methods</a></li>
        </ul>
      </div>
    </div>
  </footer>
</body>
</html>