<?php  
    require "../config/config.php";   
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
    $sql_products = "SELECT * FROM products;";
    $results_products = $mysqli->query($sql_products);
    if ( $results_products == false ) {
        echo $mysqli->error;
        exit();
    }
    $mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/make_shipment.css">
    <link rel="stylesheet" type="text/css" href="../css/navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <title>Make Shipment</title>
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
        <form action="confirm_shipment.php" method="POST">
            <div class="row row-margins">
                <div class="col col-12 register-row-text-center">
                    <div class="mb-3">
                    <label class="form-label fs-3"><span class="shipped-form-text align-middle home-fonts">SELECT THE</span><br><span class="shipped-form-text align-middle home-fonts">CLIENT'S NAME</span><span class="text-danger">*</span></label>
                                <select id="client-name-id" name="client_name" class="form-select client-input-form-width" aria-label="Default select example">
                                <option selected disabled>-- Select ONE --</option>
                                    <?php while( $row = $results_clients->fetch_assoc() ): ?>
                                    
                                        <option value="<?php echo $row['id']; ?>">
                                            <?php echo $row['client_name'];?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                    </div>
                    <div class="mb-3">
                    <label class="form-label fs-3"><span class="shipped-form-text align-middle home-fonts">SELECT THE</span><br><span class="shipped-form-text align-middle home-fonts">PRODUCT</span><span class="text-danger">*</span></label>                              
                                <select id="product-selected" name="product_name" class="form-select client-input-form-width" aria-label="Default select example">
                                <option selected disabled>-- Select ONE --</option>
                                    <?php while( $row = $results_products->fetch_assoc() ): ?>
                                        <option value="<?php echo $row['id']; ?>">
                                            <?php echo $row['name'];?>
                                        </option>
                                    <?php endwhile; ?>                                   
                                </select>
                    </div>
                    <div class="mb-3">
                    <label class="form-label fs-3"><span class="shipped-form-text align-middle home-fonts">ENTER THE</span><br><span class="shipped-form-text align-middle home-fonts">QUANTITY TO SHIP</span><span class="text-danger">*</span></label>
                                <input type="number" id="quantity-shipped-id" name="quantity_shipped" class="form-control form-control-lg client-input-form-width register-row-text-center" id="exampleFormControlInput1" placeholder="Enter Quantity">
                    </div>
                    <div class="is-required-spacing"><span class="text-danger font-italic">* Required</span></div>
                    <button type="submit" class="btn btn-primary submit-button-colors home-fonts">Ship</button>
                </div>
            </div> 
        </form>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
	document.querySelector('form').onsubmit = function(){
		if ( document.querySelector('#quantity-shipped-id').value.trim().length == 0 ) {
			document.querySelector('#quantity-shipped-id').classList.add('is-invalid');
		} else {
			document.querySelector('#quantity-shipped-id').classList.remove('is-invalid');
		}

		if ( document.querySelector('#product-selected').value.trim().length == 0 ) {
			document.querySelector('#product-selected').classList.add('is-invalid');
		} else {
			document.querySelector('#product-selected').classList.remove('is-invalid');
		}

		if ( document.querySelector('#client-name-id').value.trim().length == 0 ) {
			document.querySelector('#client-name-id').classList.add('is-invalid');
		} else {
			document.querySelector('#client-name-id').classList.remove('is-invalid');
		}
		return ( !document.querySelectorAll('.is-invalid').length > 0 );
	}
    </script>
</body>
</html>
