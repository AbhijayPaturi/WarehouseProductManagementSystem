<?php
	require "../config/config.php";
	$isInserted = false;

	if ( !isset($_POST['client_name']) || 
	empty($_POST['client_name']) ) 
	{
		$error = "Please fill out the required Client Name field.";
	}
	else {
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->errno ) {
			echo $mysqli->error;
			exit();
		}

	$sql_clients = "SELECT * FROM clients;";
	$results_clients = $mysqli->query($sql_clients);
	if ( $results_clients == false ) {
	    echo $mysqli->error;
	    exit();
	}

	$found = false;
	while(($row = $results_clients->fetch_assoc()) && $found == false) {
	    if ($row["client_name"] == $_POST["client_name"]) {
		$found = true;
	    }
	}

	if (!$found) {
	    $statement = $mysqli->prepare("INSERT INTO clients(client_name) VALUES(?);");
	    $statement->bind_param("s", $_POST["client_name"]); 
	    $executed = $statement->execute();
	    if (!$executed) {
		$error = $mysqli->error;
	    }

	    if($mysqli->affected_rows == 1) {
		$isInserted = true;
	    }
	    else {
		$error = "There was an error with this add action. Please try again.";
	    }

	}
	else {
	    $error = "Are you sure you are NOT a client ALREADY? <br><strong>Please try again!</strong>";
	}

		$mysqli->close();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/register_client.css">
    <link rel="stylesheet" type="text/css" href="../css/navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <title>Register Client</title>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light my-color sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand nav-brand-padding fs-2" href="home.php"><strong class="navbar-text-color">WPMS</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end nav-outer-text-padding fs-5" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link navtext-padding active" aria-current="page" href="home.php"><span class="navbar-text-color-active navbar-text-size">Home</span></a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link navtext-padding" href="view_product.php"><span class="navbar-text-color navbar-text-size">View Products</span></a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link navtext-padding" href="change_products.php"><span class="navbar-text-color navbar-text-size">Change Products</span></a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link navtext-padding" href="make_shipment.php"><span class="navbar-text-color navbar-text-size">Make Shipment</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <form action="home.php" method="POST">
            <div class="row">
                <div class="col col-12 register-row-text-center">
                        <?php if ( isset($error) && !empty($error) ) : ?>
                            <div class="register-row-text-center img-div">
                                    <img src="../pictures/error_picture.jpeg" alt="Error Image">
                            </div>
                        <?php else : ?>
                            <div class="col col-6 register-row-text-center img-div">
                                    <img src="../pictures/success_picture.jpeg" alt="Success Image">
                            </div>
                        <?php endif; ?>
                        <div class="client-name-spacing">
                            <?php if ( isset($error) && !empty($error) ) : ?>
                                <div class="text-danger font-italic">
                                    <?php if ($found): ?>
                                        <?php echo $error; ?></div>
                                    <?php else : ?>
                                        <div>The Client <span class="font-italic italics-msg"><?php echo $_POST['client_name'];?></span> Has NOT Been Successfully Added To The Database. Press Back and Try Again!</div>
                                    <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php if ($isInserted) : ?>
                                <div class="text-success error-message">
                                    The Client <span class="font-italic italics-msg"><?php echo $_POST['client_name'];?></span> Has Been<br>Successfully Added To The Database.
                                </div>
                            <?php endif; ?>

                            <?php if ( isset($error) && !empty($error) ) : ?>
                                <button type="submit" class="btn btn-primary submit-button-colors button-rounded-error home-fonts">Back</button>
                            <?php else : ?>
                                <button type="submit" class="btn btn-primary submit-button-colors button-rounded-success home-fonts">Back</button>
                            <?php endif; ?>
                        </div>
                </div>
            </div> 
        </form>
    </div>
    
    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
