<?php 
    require "../config/config.php";

    
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ( $mysqli->errno ) {
        echo $mysqli->error;
        exit();
    }

    $sql_products = "SELECT products.id AS products_id, name, quantity, warehouse_section, price, conditions.condition FROM products LEFT JOIN conditions ON products.conditions_id = conditions.id;";
    $results_products = $mysqli->query($sql_products);
    if ( $results_products == false ) {
        echo $mysqli->error;
        exit();
    }

    // Create an array of unqiue warehouse aisles
    $warehouse_aisles_array = array();
    while ( $row = $results_products->fetch_assoc() ) {
        if ( !(in_array($row["warehouse_section"], $warehouse_aisles_array)) ) {
            array_push($warehouse_aisles_array, $row["warehouse_section"]);
        }
    }
    $results_products->data_seek(0); 

    $sql_conditions = "SELECT * FROM conditions;";
    $results_conditions = $mysqli->query($sql_conditions);
    if ( $results_conditions == false ) {
        echo $mysqli->error;
        exit();
    }

    $sql_manufac = "SELECT * FROM manufacturers;";
    $results_manufac = $mysqli->query($sql_manufac);
    if ( $results_manufac == false ) {
        echo $mysqli->error;
        exit();
    }

    $sql_categories = "SELECT * FROM categories;";
    $results_categories = $mysqli->query($sql_categories);
    if ( $results_categories == false ) {
        echo $mysqli->error;
        exit();
    }


    // var_dump($results_categories);
    // var_dump($results_products);
    // while ($row = $results_products->fetch_assoc()) {
    //     echo "<hr>";
    //     var_dump($row);
    // }
    // var_dump($results_products->fetch_assoc());
    // $row = $results_products->fetch_assoc();
    // var_dump($row);
    // echo "<hr>";
    // var_dump($row["warehouse_section"]);

                        
    // Close 
    $mysqli->close();


    // $error = "hi";
    // $isAdded = true;
    $i = 0;
    $j = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/delete_product.css">
    <link rel="stylesheet" type="text/css" href="../css/navbar.css">
    <link rel="stylesheet" type="text/css" href="../css/product_display.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <title>Delete Products</title>
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

    <div class="container-fluid main-div">
        <form id="form-id" action="" method="">
        <!-- Row 1 -->
        <div class="row">
            
            <div class="col-12 col-md-9">
                <div class="row">
                    <div class="col-12 search-padding">
                            <input type="text" id="product-name" name="product_name" class="form-control form-control-lg" placeholder="Product Name ... ">
                    </div>      
                </div>
            </div>
            <div class="col-12 col-md-3">  
                    <div class="row">
                        <div class="col-12 search-padding">
                                <button type="submit" class="btn btn-color w-100 form-control-lg">Search</button>
                        </div>      
                    </div>
            </div>
        </div>

        <!-- Row 2 -->
        <div class="row">
        <div id="row-2-column" class="col-0 col-md-3 options-border">
                <button type="button" class="btn btn-color w-100 form-control-lg filter-buttton-spacing">Filters</button>
                <div id="manufacturer-selection">
                    <p class="option-header maufacturers-spacing">Manufacturers</p>
                    <select id="product-manufacturer-id" name="product_manufacturer_id" class="form-select dropdown-spacing" aria-label="Default select example">
                            <option selected value="0">All</option>
                            <?php while( $row = $results_manufac->fetch_assoc() ): ?>
                                
                                <option value="<?php echo $row['id']; ?>">
                                    <?php echo $row['manufacturer'];?>
                                </option>
                            <?php endwhile; ?>
                    </select>
                </div>
                <div id="category-selection">
                    <p class="option-header">Categories</p>
                    
                    <select id="product-category-id" name="product_category_id" class="form-select dropdown-spacing" aria-label="Default select example">
                            <option selected value="0">All</option>
                            <?php while( $row = $results_categories->fetch_assoc() ): ?>
                                
                                <option value="<?php echo $row['id']; ?>">
                                    <?php echo $row['category'];?>
                                </option>
                            <?php endwhile; ?>
                    </select>
                    
                </div>
                <div id="warehouse-selection">
                    <p class="option-header">Warehouse Aisle</p>

                    <select id="warehouse_aisle_id" name="warehouse_aisle_id" class="form-select dropdown-spacing" aria-label="Default select example">
                            <option selected value="0">All</option>
                            <?php foreach ($warehouse_aisles_array as $warehouse_aisle): ?>
                                <option value="<?php echo $warehouse_aisle ?>">
                                    <?php echo $warehouse_aisle;?>
                                </option>
                            <?php endforeach; ?>
                    </select>
                    
                </div>
                <div id="condition-selection">
                    <p class="option-header">Condition</p>

                    <select id="product-condition-id" name="product_condition_id" class="form-select dropdown-spacing" aria-label="Default select example">
                            <option selected value="0">All</option>
                            <?php while( $row = $results_conditions->fetch_assoc() ): ?>
                                
                                <option value="<?php echo $row['id']; ?>">
                                    <?php echo $row['condition'];?>
                                </option>
                            <?php endwhile; ?>
                    </select>

                </div>
                
            </div>
            <?php $results_products->data_seek(0); ?>
            <!-- Product Information -->
            <div class="col-12 col-md-9 prod-rows-border js-ajax">
                <!-- Sub-Row -->
                <?php while( ($row = $results_products->fetch_assoc()) ):?>	
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <div class="img-div">
                                <!-- Product Pic -->
                                <img src="../pictures/no_pic_image.png" alt="Product Image">
                            </div>
                        </div>   
                        <div class="col-12 col-md-9 prod-rows-center">
                            <!-- Sub-Sub-Row -->
                            <div class="row">
                                <div class="col-12 prod-details-styling">
                                    <span class="prod-name-unique"><strong><?php echo $row["name"]; ?></strong></span>
                                </div>    
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6 prod-details-styling">
                                    Warehouse Aisle: <strong><?php echo $row["warehouse_section"]; ?></strong>
                                </div>   
                                <div class="col-12 col-md-6 prod-details-styling">
                                    Quantity: <strong><?php echo $row["quantity"]; ?></strong>
                                </div>      
                            </div>
                            <div class="row last-prod-row-styling">
                                <div class="col-12 prod-details-styling">
                                    <input type="hidden" name="products_id" value="<?php echo $row["products_id"] ?>"> 
                                    <input type="hidden" name="product_name" value="<?php echo $row["name"] ?>"> 
                                    <a type="button" href="delete_product_confirmation.php?products_id=<?php echo $row['products_id']?>&product_name=<?php echo $row['name']; ?>" onclick="return confirm('You are about to DELETE the product <?php echo $row['name']; ?>. Press OK if this was your intended action.');" class="btn btn-color delete-button-style form-control-lg">Delete</a>
                                </div>     
                            </div>
                        </div>      
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        </form>
    </div>

    <?php include 'footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> 

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script>
        $("#row-2-column button").on("click", function() {
            console.log($(this).siblings());
            $(this).siblings().slideToggle(500, function() {
            });
        });

        $("#manufacturer-selection p").on("click", function() {
            $(this).next().slideToggle(500, function() {
                
            });
        });

        $("#category-selection p").on("click", function() {
            $(this).next().slideToggle(500, function() {
            });
        });

        $("#warehouse-selection p").on("click", function() {
            $(this).next().slideToggle(500, function() {
            });
        });

        $("#condition-selection p").on("click", function() {
            $(this).next().slideToggle(500, function() {
            });
        });

        // Function declaration for ajax GET requests
		function ajaxGet(endpointUrl, returnFunction){
			var xhr = new XMLHttpRequest();
			xhr.open('GET', endpointUrl, true);
			xhr.onreadystatechange = function(){
				if (xhr.readyState == XMLHttpRequest.DONE) {
					if (xhr.status == 200) {
						// When ajax call is complete, call this function, pass a string with the response
						returnFunction( xhr.responseText );
					} else {
						alert('AJAX Error.');
						console.log(xhr.status);
					}
				}
			}
			xhr.send();
		};

        document.querySelector("#form-id").onsubmit = function() { 
			// prevent the form from actually being submitted 
			event.preventDefault();

			// Get the all of the user's search/filter terms 
			let searchInput = document.querySelector("#product-name").value.trim();
            console.log(searchInput);
            let manufacturerInfo = document.querySelector("#product-manufacturer-id").value;
            let categoriesInfo = document.querySelector("#product-category-id").value;
            let warehouseAisle = document.querySelector("#warehouse_aisle_id").value;
            console.log(warehouseAisle);
            let conditionInfo = document.querySelector("#product-condition-id").value;

			// Call the ajax function, pass in the search input, log out results 
			ajaxGet("view_product_backend.php?prodName=" + searchInput + "&manufacturerId=" + manufacturerInfo + "&categoryId=" + categoriesInfo + "&warehouseAisle=" + warehouseAisle + "&conditionId=" + conditionInfo, function(results) {
				console.log("view_product_backend.php?prodName=" + searchInput + "&manufacturerId=" + manufacturerInfo + "&categoryId=" + categoriesInfo + "&warehouseAisle=" + warehouseAisle + "&conditionId=" + conditionInfo);

				// convert the data into js object 
				let jsResults = JSON.parse(results);
				console.log(jsResults);
                // console.log(jsResults.length);

				let resultsList = document.querySelector(".js-ajax");
                // console.log(jsResults[0].warehouse_section);

				// Clear the previous list of results 
				resultsList.replaceChildren();

				// Run through the list of results and dynamically create a <li> tag for each of the reuslts 
				for (let i = 0; i < jsResults.length; i++) {
					let htmlString = `

                    <!-- Sub-Row -->
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <div class="img-div">
                                    <!-- Product Pic -->
                                    <img src="../pictures/general_prod_image.jpeg" alt="Product Image">
                                </div>
                            </div>   
                            <div class="col-12 col-md-9 prod-rows-center">
                                <!-- Sub-Sub-Row -->
                                <div class="row">
                                    <div class="col-12 prod-details-styling">
                                        <a class="product-name-styling" href="product_details.php?products_id=${jsResults[i].id}&product_name=${jsResults[i].name}>"><strong>${jsResults[i].name}</strong></a>
                                    </div>    
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6 prod-details-styling">
                                        Warehouse Aisle: <strong>${jsResults[i].warehouse_section}</strong>
                                    </div>   
                                    <div class="col-12 col-md-6 prod-details-styling">
                                        Quantity: <strong>${jsResults[i].quantity}</strong>
                                    </div>      
                                </div>
                                <div class="row last-prod-row-styling">
                                <div class="col-12 prod-details-styling">
                                    <input type="hidden" name="products_id" value="${jsResults[i].products_id}"> 
                                    <input type="hidden" name="product_name" value="${jsResults[i].name}"> 
                                    <a type="button" onclick="return confirm('You are about to DELETE the product ${jsResults[i].name}. Press OK if this was your intended action.');" class="btn btn-color delete-button-style form-control-lg">Delete</a>
                                </div>     
                            </div>
                            </div>      
                        </div>
                    `;
					// Append to the formatted output 
					resultsList.innerHTML += htmlString;
				}
			});
		}

    </script>
</body>
</html>