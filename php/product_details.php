<?php 

    if( !isset($_GET["products_id"]) || empty($_GET["products_id"]) ) {
        $error = "Invalid Product Selected!";
    }
    else {
        require "../config/config.php";
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno) {
            echo $mysqli->connect_error;
            exit();
        }
    
        $mysqli->set_charset("utf-8");
    
        // SQL Statement 
        $sql = "SELECT *
        FROM products
        LEFT JOIN categories 
            ON products.categories_id = categories.id 
        LEFT JOIN manufacturers 
            ON products.manufacturers_id = manufacturers.id
        LEFT JOIN conditions 
            ON products.conditions_id = conditions.id 
        LEFT JOIN products_has_clients 
            ON products.id = products_has_clients.products_id
        LEFT JOIN clients 
            ON products_has_clients.clients_id = clients.id         
        WHERE products.id=" . $_GET["products_id"] . ";";


        $results = $mysqli->query($sql);
        if (!$results) {
            echo $mysqli->error;
            exit();
        }
        // $row = $results->fetch_assoc();
        // echo "<hr>";
        // var_dump($row);
    }
    
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/product_details.css">
    <link rel="stylesheet" type="text/css" href="../css/navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <title>Details</title>
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
                    <a class="nav-link navtext-padding" aria-current="page" href="home.php"><span class="navbar-text-color navbar-text-size">Home</span></a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link navtext-padding active" href="view_product.php"><span class="navbar-text-color-active navbar-text-size">View Products</span></a>
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

    <div class="container main-div">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="img-div js-add-img">
                    <img src="../pictures/general_prod_image.jpeg" alt="No Picture Image">
                </div>
            </div>
            <div class="col-12 col-md-6 important-info">
                <?php $row = $results->fetch_assoc(); ?>	
                <div class="under-img-text">
                    <strong class="query-result"><?php echo $row["name"]; ?></strong>
                </div>
                <div class="under-img-text">
                    Model No: <strong class="query-result"><?php echo $row["model"]; ?></strong>
                </div>
                <div class="under-img-text">
                    Quantity in Warehouse: <strong class="query-result"><?php echo $row["quantity"]; ?></strong>
                </div>
                <div class="under-img-text">
                    Warehouse Aisle: <strong class="query-result"><?php echo $row["warehouse_section"]; ?></strong>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 secondary-details">
                <?php $results->data_seek(0); ?>
                <?php $row = $results->fetch_assoc(); ?>	
                <div class="under-img-text">
                    $<strong class="query-result"><?php echo $row["price"]; ?></strong>
                </div>
                <div class="under-img-text">
                    Features: <strong class="query-result"><?php echo $row["features"]; ?></strong>
                </div>
                <div class="under-img-text">
                    Product Category: <strong class="query-result"><br><?php echo $row["category"]; ?></strong>
                </div>
                <div class="under-img-text">
                    Manufacturer: <strong class="query-result"><br><?php echo $row["manufacturer"]; ?></strong>
                </div>
                <div class="under-img-text">
                    Condition: <strong class="query-result"><?php echo $row["condition"];?></strong>
                </div>
            </div>
            <div class="col-12 col-md-6 bullet-list-div">
                <!-- <div class="under-img-text"> -->
                    <ul class="bullet-point-list-style under-img-text">
                        <div class="bullet-list-header">Past Clients Who Have Purchased:</div>
                        <?php if($row["client_name"] != null): ?> 
                            <?php $results->data_seek(0); ?>
                            <?php while( $row = $results->fetch_assoc() ):?>	
                                <li class="client-name-style"><?php echo $row["client_name"]; ?></li>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <li class="client-name-style no-purchase-styling">No Purchases <br>As Of Yet.</li>
                        <?php endif; ?>
                    </ul>
                <!-- </div> -->
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <a type="button" href="view_product.php" class="btn btn-primary button-colors">Back</a>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> 

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- <script src="../js/get_photos.js"></script> -->

    <script>
        let productName = "<?php echo $_GET["product_name"]; ?>";
        console.log(productName);
        
        $.ajax({
            method: "GET", 
            url: "https://api.pexels.com/v1/search",
            headers: {
                "Authorization":
                    "Bearer 563492ad6f91700001000001986c927e7df6444f92ad29d73a8028de",
            },
            data: {
                query: productName, 
            }
        })
        // if we get a successful AJAX response
        .done(function(results) {
            console.log(results);
            displayResults(results);
        })
        .fail(function(results) {
            console.log("ERROR");
            console.log(results);
        });

        function displayResults(resultsString) {
            // Clear the standard image 
            document.querySelector(".js-add-img").replaceChildren();

            // Construct the HTML string 
            let htmlString = `
            <img src="${resultsString.photos[0].src["large"]}" alt="Image of Selected Item">`
                
            // Attach the HTML string to the appropriate tag to display the image from the Pexels API 
            document.querySelector(".js-add-img").innerHTML += htmlString;
            
        };

    </script>

 
</body>
</html>