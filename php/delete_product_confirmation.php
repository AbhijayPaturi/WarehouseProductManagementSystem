<?php
	require "../config/config.php";
	$isDeleted = false;
	if ( !isset($_GET['products_id']) || empty($_GET['products_id']) || 
		!isset($_GET['product_name']) || empty($_GET['product_name'])) {

		$error = "Invalid Product Delete.";
	}
	else {
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit(); 
		}
		$sql_products_many = "SELECT * FROM products_has_clients WHERE products_id =" . $_GET["products_id"] . ";";
		$results_products_many = $mysqli->query($sql_products_many);
		if ( $results_products_many == false ) {
			echo $mysqli->error;
			exit();
		}

		$found = false;
		$total_rows = $results_products_many->num_rows;
			if ($total_rows > 0) {
			$found = true;
		}

		if ($found) {
			$statement_many = $mysqli->prepare("DELETE FROM products_has_clients WHERE products_id = ?");
			$statement_many->bind_param("i", $_GET["products_id"]);
			$executed_many = $statement_many->execute();
			if (!$executed_many) {
			    echo $mysqli->error;
			    exit();
			}
			if ($statement_many->affected_rows == $total_rows) {
			    $isDeleted = true;
			}
			else {
			    $error = "There was an error with this delete action. Please try again.";
			}
		}
		$statement = $mysqli->prepare("DELETE FROM products WHERE products.id = ?");
		$statement->bind_param("i", $_GET["products_id"]);
		$executed = $statement->execute();
		if (!$executed) {
			echo $mysqli->error;
			exit();
		}
		if ($statement->affected_rows == 1) {
			$isDeleted = true;
		}
		else {
			$error = "There was an error with this delete action. Please try again.";
		}
		$statement->close();
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
    <link rel="stylesheet" type="text/css" href="../css/delete_product_confirmation.css">
    <link rel="stylesheet" type="text/css" href="../css/navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <title>Delete Confirmation</title>
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
                    <a class="nav-link navtext-padding" aria-current="page" href="home.php"><span class="navbar-text-color navbar-text-size">Home</span></a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link navtext-padding" href="view_product.php"><span class="navbar-text-color navbar-text-size">View Products</span></a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link navtext-padding active" href="change_products.php"><span class="navbar-text-color-active navbar-text-size">Change Products</span></a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link navtext-padding" href="make_shipment.php"><span class="navbar-text-color navbar-text-size">Make Shipment</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
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
                                    <div id="msg"><span class="font-italic italics-msg"><?php $_GET["product_name"];?></span> Has NOT Been Successfully Deleted.<br>Press Back and Try Again!</div>
                                </div>
                            <?php endif; ?>
                            <?php if ($isDeleted) : ?>
                                <div class="text-success error-message">
                                    <div><span class="font-italic italics-msg"><?php echo $_GET["product_name"];?></span> Has Been Successfully Deleted!</div>
                                </div>
                            <?php endif; ?>             
                            <?php if ( isset($error) && !empty($error) ) : ?>
                                <a href="home.php" class="btn btn-primary submit-button-colors button-rounded-error home-fonts">Home</a>
                                <a href="delete_product.php" class="btn btn-primary submit-button-colors button-rounded-error home-fonts">Back</a>
                            <?php else : ?>
                                <a href="home.php" class="btn btn-primary submit-button-colors button-rounded-error home-fonts">Home</a>
                                <a href="delete_product.php" class="btn btn-primary submit-button-colors button-rounded-error home-fonts">Back</a>
                            <?php endif; ?>
                        </div>
                </div>
            </div>       
    </div>
    <?php include 'footer.php'; ?>    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> 
</body>
</html>
