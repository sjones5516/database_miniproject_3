<!DOCTYPE html>
<html>
    <head>
        <?php
            require 'util.php';
        ?>
        <link rel="stylesheet" href="main.css">
    </head>

    <body>
        <h1>Cart</h1>
        <?php
            $cart = $_SESSION['cart'];

            if (sizeof($cart) > 0) {
                $total = 0;
                foreach ($cart as $key => $value) {
                    $product = getProductByID($key);
                    echo sprintf("<p>%d %s: $%.2f</p>", $value, $product['name'], $value * $product['price']);
                    $total += $value * $product['price'];
                }

                // Add Checkout Button
                echo sprintf("Total: $%.2f", $total);
                echo sprintf('<form method="post" action="checkout_api.php">
                <label for="customer_id">Customer ID</label>
                <input type="number" id="customer_id" name="customer_id" required>
                <input type="hidden" name="total_price" value="%.2f">
                <br>
                <input type="submit" value="Checkout"> </form>', $total);
            } else {
                echo "<p>Cart is Empty</p>";
            }

        ?>
    </body>
</html>