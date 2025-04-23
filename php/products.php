<!DOCTYPE html>
<html>
    <head>
        <?php
            require 'util.php';

            // Get the category
            $category = -1;
            if (isset($_GET['category'])) {
                $category = $_GET['category'];
                if ($category == 'Unscheduled') {
                    $category = 0;
                }
            }
        ?>

        <link rel="stylesheet" href="main.css">
    </head>

    <body>
        <?php
            // Get each product
            $products = getProducts($category);

            foreach ($products as $product) {
                // Fix schedule
                $schedule = $product['schedule'];
                $schedule = ltrim($schedule,'0');
                if ($schedule == '') {
                    $schedule = 'Unscheduled';
                }

                echo '<table>';
                echo sprintf('<tr><td>SKU</td><td>%s</td></tr>', $product['product_id']);
                echo sprintf('<tr><td>Schedule</td><td>%s</td></tr>', $schedule);
                echo sprintf('<tr><td>SKU</td><td>%s</td></tr>', $product['name']);
                echo sprintf('<tr><td>Stock</td><td>%s</td></tr>', $product['stock']);
                echo sprintf('<tr><td>Price</td><td>$%.2f</td></tr>', $product['price']);
                echo '</table>';

                echo sprintf('<form action="add_api.php">', $product['product_id']);
                echo sprintf('<input type="number" name="quantity" min="1" max="%d">', $product['stock']);
                echo '<input type="submit" value="Add to Cart">';
                echo sprintf('<input type="hidden" name="product_id" value="%d">', $product['product_id']);

                echo '</form>';
                echo '<br>';
            }
        ?>
    </body>
</html>