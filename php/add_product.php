<?php 
    require "../config/config.php";   
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ( $mysqli->errno ) {
        echo $mysqli->error;
        exit();
    }
    $sql_conditions = "SELECT * FROM conditions;";
    $results_conditions = $mysqli->query($sql_conditions);
    if ( $results_conditions == false ) {
        echo $mysqli->error;
        exit();
    }
    $sql_categories = "SELECT * FROM categories;";
    $results_categories = $mysqli->query($sql_categories);
    if ( $results_categories == false ) {
        echo $mysqli->error;
        exit();
    }
    $sql_manufacturers = "SELECT * FROM manufacturers;";
    $results_manufacturers = $mysqli->query($sql_manufacturers);
    if ( $results_manufacturers == false ) {
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
    <link rel="stylesheet" type="text/css" href="../css/add_product.css">
    <link rel="stylesheet" type="text/css" href="../css/navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <title>Add Product</title>
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
        <form action="add_product_confirmation.php" method="POST">
            <div class="row row-margins">
                <div class="col col-12 register-row-text-center">                   
                    <div class="mb-3">
                        <label class="form-label fs-3 label-spacing"><span class="shipped-form-text align-middle home-fonts">ENTER THE</span><br><span class="shipped-form-text align-middle home-fonts">PRODUCT'S NAME</span><span class="text-danger">*</span></label>
                                <input type="text" id="product-name" name="product_name" class="form-control form-control-lg client-input-form-width register-row-text-center" placeholder="Client Name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fs-3 label-spacing"><span class="shipped-form-text align-middle home-fonts">ENTER THE QUANTITY</span><br><span class="shipped-form-text align-middle home-fonts">OF THE PRODUCT</span><span class="text-danger">*</span></label>
                                <input type="text" id="product-quantity" name="product_quantity" class="form-control form-control-lg client-input-form-width register-row-text-center" placeholder="Product Quantity">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fs-3 label-spacing"><span class="shipped-form-text align-middle home-fonts">ENTER THE</span><br><span class="shipped-form-text align-middle home-fonts">PRODUCT'S PRICE</span><span class="text-danger">*</span></label>
                                <input type="text" id="product-price" name="product_price" class="form-control form-control-lg client-input-form-width register-row-text-center" placeholder="Product Price">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-3 label-spacing"><span class="shipped-form-text align-middle home-fonts">ENTER THE</span><br><span class="shipped-form-text align-middle home-fonts">WAREHOUSE AISLE</span><span class="text-danger">*</span></label>
                                <input type="text" id="warehouse-aisle" name="warehouse_aisle" class="form-control form-control-lg client-input-form-width register-row-text-center" placeholder="Warehouse Aisle">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-3 label-spacing"><span class="shipped-form-text align-middle home-fonts">ENTER THE</span><br><span class="shipped-form-text align-middle home-fonts">PRODUCT'S MODEL</span><span class="text-danger">*</span></label>
                                <input type="text" id="product-model" name="product_model" class="form-control form-control-lg client-input-form-width register-row-text-center" placeholder="Product Model">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fs-3 label-spacing"><span class="shipped-form-text align-middle home-fonts">ENTER THE</span><br><span class="shipped-form-text align-middle home-fonts">PRODUCT'S FEATURES</span></label>
                                <input type="text" id="product-features" name="product_features" class="form-control form-control-lg client-input-form-width register-row-text-center" placeholder="Product Features">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-3 label-spacing"><span class="shipped-form-text align-middle home-fonts">SELECT THE</span><br><span class="shipped-form-text align-middle home-fonts">PRODUCT'S CATEGORY</span><span class="text-danger">*</span></label>
                                <select id="product-category-id" name="product_category_id" class="form-select client-input-form-width" aria-label="Default select example">
                                <option selected disabled>-- Select ONE --</option>
                                    <?php while( $row = $results_categories->fetch_assoc() ): ?>
                                    
                                        <option value="<?php echo $row['id']; ?>">
                                            <?php echo $row['category'];?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-3 label-spacing"><span class="shipped-form-text align-middle home-fonts">SELECT THE</span><br><span class="shipped-form-text align-middle home-fonts">PRODUCT'S MANUFACTURER</span><span class="text-danger">*</span></label>
                                <select id="product-manufacturer-id" name="product_manufacturer_id" class="form-select client-input-form-width" aria-label="Default select example">
                                <option selected disabled>-- Select ONE --</option>
                                    <?php while( $row = $results_manufacturers->fetch_assoc() ): ?>
                                    
                                        <option value="<?php echo $row['id']; ?>">
                                            <?php echo $row['manufacturer'];?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-3 label-spacing"><span class="shipped-form-text align-middle home-fonts">SELECT THE</span><br><span class="shipped-form-text align-middle home-fonts">PRODUCT'S CONDITIONS</span><span class="text-danger">*</span></label>
                                <select id="product-condition-id" name="product_condition_id" class="form-select client-input-form-width" aria-label="Default select example">
                                <option selected disabled>-- Select ONE --</option>
                                    <?php while( $row = $results_conditions->fetch_assoc() ): ?>
                                    
                                        <option value="<?php echo $row['id']; ?>">
                                            <?php echo $row['condition'];?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                    </div>
                    <div class="is-required-spacing"><span class="text-danger font-italic">* Required</span></div>
                    <a href="change_products.php" class="btn btn-primary submit-button-colors button-rounded-error home-fonts">BACK</a>
                    <button type="submit" class="btn btn-primary submit-button-colors home-fonts">ADD</button>
                </div>
            </div> 
        </form>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> 
    <script>
	document.querySelector('form').onsubmit = function(){
		if ( document.querySelector('#product-name').value.trim().length == 0 ) {
			document.querySelector('#product-name').classList.add('is-invalid');
		} else {
			document.querySelector('#product-name').classList.remove('is-invalid');
		}
		if ( document.querySelector('#product-quantity').value.trim().length == 0 ) {
			document.querySelector('#product-quantity').classList.add('is-invalid');
		} else {
			document.querySelector('#product-quantity').classList.remove('is-invalid');
		}
		if ( document.querySelector('#product-price').value.trim().length == 0 ) {
			document.querySelector('#product-price').classList.add('is-invalid');
		} else {
			document.querySelector('#product-price').classList.remove('is-invalid');
		}
		if ( document.querySelector('#warehouse-aisle').value.trim().length == 0 ) {
			document.querySelector('#warehouse-aisle').classList.add('is-invalid');
		} else {
			document.querySelector('#warehouse-aisle').classList.remove('is-invalid');
		}
		if ( document.querySelector('#product-model').value.trim().length == 0 ) {
			document.querySelector('#product-model').classList.add('is-invalid');
		} else {
			document.querySelector('#product-model').classList.remove('is-invalid');
		}
		if ( document.querySelector('#product-features').value.trim().length == 0 ) {
			document.querySelector('#product-features').classList.add('is-invalid');
		} else {
			document.querySelector('#product-features').classList.remove('is-invalid');
		}
		if ( document.querySelector('#product-category-id').value.trim().length == 0 ) {
			document.querySelector('#product-category-id').classList.add('is-invalid');
		} else {
			document.querySelector('#product-category-id').classList.remove('is-invalid');
		}
		if ( document.querySelector('#product-manufacturer-id').value.trim().length == 0  ) {
			document.querySelector('#product-manufacturer-id').classList.add('is-invalid');
		} else {
			document.querySelector('#product-manufacturer-id').classList.remove('is-invalid');
		}
		if ( document.querySelector('#product-condition-id').value.trim().length == 0  ) {
			document.querySelector('#product-condition-id').classList.add('is-invalid');
		} else {
			document.querySelector('#product-condition-id').classList.remove('is-invalid');
		}
		return ( !document.querySelectorAll('.is-invalid').length > 0 );
	   }

	</script>
</body>
</html>
