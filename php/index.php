<!DOCTYPE html>
<html>
    <head>
        <?php
            require 'util.php'
        ?>

    <link rel="stylesheet" href="main.css">
    </head>

    <body>
        <h1>Categories</h1>
        <?php
            foreach(getProductCategories() as $category) {
                echo sprintf('<a href="products.php?category=%s">%s</a><br>', $category, $category);
            }
        ?>

        <br>
        
        <a href="checkout.php">Checkout</a>
    </body>
</html>