<!DOCTYPE html>
<html>
    <head>
        <?php
            require 'util.php';

            // Add the order item and quantity and then redirect to previous page
            if (isset($_GET['product_id']) && isset($_GET['quantity'])) {
                addToCart($_GET['product_id'], $_GET['quantity']);
            }

            header('Location: index.php');

        ?>
    </head>

    <body>
    </body>
</html>