<?php
	require 'db_details.php';

	if($_POST){
		// Check that an email address was posted and that it is valid
		if(isset($_POST['email_input']) && strlen(trim($_POST['email_input'])) > 0){
			if (!filter_var($_POST['email_input'], FILTER_VALIDATE_EMAIL)) {
			    $error = "Sorry, but you did not enter a valid email address";
			}
		}
		else{
			$error = "Sorry, you did not enter an email address.";
		}

		if(!isset($error)){
			try{
				// Create a PDO connection with the db_details vars
				$db = new PDO("mysql:host=$pdo_host;dbname=$pdo_db", $pdo_user, $pdo_pass);

				// Insert the email into the DB
				$statement = $db->prepare('INSERT INTO registrants(reg_email) values (:email)');
				$statement->bindParam(':email', $_POST['email_input'], PDO::PARAM_STR);
				$statement->execute();

				// Close the db connection and redirect to prevent re-posting
				$db = null;
				header("Location: " . $_SERVER['REQUEST_URI']);
				exit();
			}
			catch(PDOException $ex){
				echo $e->getMessage();
			}
		}
	}
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Simple Landing Page</title>

        <meta name="author" content="the author">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/base.css">
        <link rel="stylesheet" href="css/skeleton.css">
        <link rel="stylesheet" href="css/layout.css">
        <link rel="stylesheet" href="css/style.css">

        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </head>
    <body>
        <div class="container">
            <div id="header" class="sixteen columns">
                <h1>Simple Landing Page</h1>
            </div>

            <div id="thank-you" class="twelve columns offset-by-two">
            	<p>
            	<?php
            		if(isset($error)){
            			echo($error);
            		}
            		else{
            			echo("Thank you for registering your interest! We will get in touch shortly.");
            		}
            	?>
            	</p>
            </div>
        </div>
    </body>
</html>
