<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css"/>
</head>
<body>

<h1>List of products</h1>

<?php
    require_once("./lib.php");
    $productsList = new Products("./products.xml");

    //Using POST method to fetch the data from the form
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
        $name =  $_POST['name'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $category = $_POST['category'];
        $manufacturer = $_POST['manufacturer'];
        $barcode = $_POST['barcode'];
        $weight = $_POST['weight'];
        $instock = $_POST['instock'];
        $availability = $_POST['availability'];
    
        //If name is ok, we add a product in the XML File
        if (!empty($name)) {
            $productsList->add_product($name, $price, $quantity, $category, $manufacturer, $barcode, $weight, $instock, $availability);
            
            //Redirect user to the same page, so not resubmit the data.
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Name is required!";
        }
    }

    $productsList->print_html_table_with_all_products();

?>

<!-- Form for adding a product in XML -->
<form class="form" method="POST" action="products.php">
    <h2 class="title">Add product</h2>
    <hr/>

    <label for="name">Name*:</label><br>
    <input type="text" id="name" name="name" required><br><br>
    
    <label for="price">Price:</label><br>
    <input type="text" id="price" name="price"><br><br>
    
    <label for="quantity">Quantity:</label><br>
    <input type="number" id="quantity" name="quantity"><br><br>
    
    <label for="category">Category:</label><br>
    <input type="text" id="category" name="category"><br><br>
    
    <label for="manufacturer">Manufacturer:</label><br>
    <input type="text" id="manufacturer" name="manufacturer"><br><br>
    
    <label for="barcode">Barcode:</label><br>
    <input type="text" id="barcode" name="barcode"><br><br>
    
    <label for="weight">Weight:</label><br>
    <input type="text" id="weight" name="weight"><br><br>

    <label for="instock">In Stock:</label><br>
    <input type="text" id="instock" name="instock"><br><br>
    
    <label for="availability">Availability:</label><br>
    <input type="text" id="availability" name="availability"><br><br>
    
    <button type="submit" name="add_product">Add Product</button>
</form>

</body>
</html>