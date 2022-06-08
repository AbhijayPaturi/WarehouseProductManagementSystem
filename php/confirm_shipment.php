<?php
	require "../config/config.php";
	$isInserted = false;
	if ( !isset($_POST['client_name']) || 
	empty($_POST['client_name']) || 
	!isset($_POST['product_name']) || 
	empty($_POST['product_name']) || 
	!isset($_POST['quantity_shipped']) || 
	empty($_POST['quantity_shipped']) ) 
	{
		$error = "Please fill out the required fields.";
	}
	else {
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->errno ) {
			echo $mysqli->error;
			exit();
		}
	$statement_num_product = $mysqli->prepare("SELECT * FROM products WHERE id = ?;");
	$statement_num_product->bind_param("i", $_POST["product_name"]);
	$statement_num_product->execute();

	$results_num_product=$statement_num_product->get_result();
	$prod_db_name = null;
	$prod_db_quantity = null;
	if ($results_num_product->num_rows == 1) {
	    $row = $results_num_product->fetch_assoc();
	    $prod_db_name = $row["name"];
	    $prod_db_quantity = $row["quantity"];
	}
	$statement_num_product->close();
	$statement_client_name = $mysqli->prepare("SELECT client_name FROM clients WHERE id = ?;");
	$statement_client_name->bind_param("i", $_POST["client_name"]);
	$statement_client_name->execute();
	$results_client_name=$statement_client_name->get_result();
	$client_db_name = null;
	if ($results_client_name->num_rows == 1) {
	    $row = $results_client_name->fetch_assoc();
	    $client_db_name = $row["client_name"];
	}
	$statement_client_name->close();
	if ($prod_db_quantity != null) {
	    if ($_POST["quantity_shipped"] <= $prod_db_quantity) {
		$statement = $mysqli->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ?;");
		$statement->bind_param("ii", $_POST["quantity_shipped"], $_POST["product_name"]); 
		$executed = $statement->execute();
		if (!$executed) {
		    $error = $mysqli->error;
		}
		if($mysqli->affected_rows == 1) {
		    $isUpdated = true;
		}
		else {
		    $error = "There was an error with this update action. Please try again.";
		}
		$statement->close();
		$statement_check_many = $mysqli->prepare("SELECT * FROM products_has_clients WHERE products_id = ? AND clients_id = ?;");
		$statement_check_many->bind_param("ii", $_POST["product_name"], $_POST["client_name"]);
		$statement_check_many->execute();
		$results_check_many=$statement_check_many->get_result();
		if ($results_check_many->num_rows == 0) {
		    $statement = $mysqli->prepare("INSERT INTO products_has_clients(products_id, clients_id) VALUES(?, ?);");
		    $statement->bind_param("ii", $_POST["product_name"], $_POST["client_name"]); 
		    $executed = $statement->execute();
		    if (!$executed) {
			$error = $mysqli->error;
		    }
		    if($mysqli->affected_rows == 1) {
			$isUpdated = true;
		    }
		    else {
			$error = "There was an error with this update action. Please try again.";
		    }
		}
		$statement_check_many->close();
	    }
	    else {
		$error = "Sorry! We do not have enough <em>" . $prod_db_name . "</em>in the warehouse right now!";
	    }
	}
	else {
	    $error = "Sorry! Not a valid product quantity entered. Please try again!";
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
    <link rel="stylesheet" type="text/css" href="../css/confirm_shipment.css">
    <link rel="stylesheet" type="text/css" href="../css/navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <title>Confirm Shipment</title>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light my-color sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand nav-brand-padding fs-2" href="home.php"><strong class="navbar-text-color">WPMS</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end nav-outer-text-padding" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link navtext-padding" aria-current="page" href="home.php"><span class="navbar-text-color navbar-text-size">Home</span></a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link navtext-padding" href="view_product.php"><span class="navbar-text-color navbar-text-size">View Products</span></a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link navtext-padding" href="change_products.php"><span class="navbar-text-color navbar-text-size">Change Products</span></a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link navtext-padding active" href="make_shipment.php"><span class="navbar-text-color-active navbar-text-size">Make Shipment</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <form action="make_shipment.php" method="POST">
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
                                    <div id="msg">The <span class="font-italic italics-msg"><?php echo $prod_db_name;?></span> Has NOT Been Successfully Shipped To <span class="font-italic italics-msg"><?php echo $client_db_name;?></span>.<br>Press Back and Try Again!</div>
                                 </div>
                            <?php endif; ?>                       
                            <?php if ($isUpdated) : ?>
                                <div class="text-success error-message">                                
                                    <div>The <span class="font-italic italics-msg"><?php echo $prod_db_name;?></span> Has Been Successfully Shipped To <span class="font-italic italics-msg"><?php echo $client_db_name;?></span>!</div>
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
