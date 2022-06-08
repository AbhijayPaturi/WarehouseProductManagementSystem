<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../home.css">
    <link rel="stylesheet" type="text/css" href="../css/navbar.css">
    <title>Home</title>
</head>
<body>
    
    <nav class="navbar navbar-expand-md navbar-light my-color sticky-top">
        <!-- Container that is fluid -->
        <div class="container-fluid">
            <a class="navbar-brand nav-brand-padding fs-2" href="home.php"><strong class="navbar-text-color">WPMS</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end nav-outer-text-padding fs-5" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link active navtext-padding" aria-current="page" href="home.php"><span class="navbar-text-color-active navbar-text-size">Home</span></a>
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
    <!-- Content -->
    <div class="container-fluid"> 
        <div class="row">
            <div class="col col-12 background-stuff">
                <!-- <div class="overlay-image"></div> -->
                <h1 class="client-text home-fonts"><span class="select-client-text">REGISTER A CLIENT</span></h1>
				<!-- <button type="submit" class="btn btn-primary select-client-button-colors form-rounded">SELECT A CLIENT</button> -->
            </div>
        </div>
    </div>

    <div class="container-fluid"> 
        <form action="register_client.php" method="POST">
            <div class="row row-margins">
                <div class="col col-12 register-row-text-center">
                    <div class="mb-3">
                    <label class="form-label fs-3"><span class="client-form-text align-middle home-fonts">ENTER THE</span><br><span class="client-form-text align-middle home-fonts">CLIENT'S NAME</span><span class="text-danger">*</span></label>
                                <input type="text" id="client-name-id" name="client_name" class="form-control form-control-lg form-bg-color form-rounded client-input-form-width register-row-text-center" placeholder="Client Name">
                    </div>
                    <div class="is-required-spacing"><span class="text-danger font-italic">* Required</span></div>
                    <button type="submit" class="btn btn-primary submit-button-colors form-rounded home-fonts">Submit</button>
                </div>

                <!-- <div class="col col-6 register-row-text-center">
                        <h1 class="home-fonts client-text"><a href="register_client.php" class="register-client-text">REGISTER A CLIENT</a></h1>
                </div> -->
            </div> 
        </form>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col col-12 register-row-text-center home-fonts about-info">
                <p class="about-title">About WPMS</p>
                <span>This website is a warehouse product management system that allows warehouse employees to register clients as well as manage the products that are in the warehouse at any given time. This allows employees to add and delete products, filtering by features like product aisle, quantity, brand, and condition. This gives employees, and executives, full jurisdiction over the products in their warehouse and helps them maintain their business. Give my website a whirl!</span>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script>
        // JS as first-level check
		document.querySelector('form').onsubmit = function(){
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