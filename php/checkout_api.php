<!DOCTYPE html>
<html>
    <head>
        <?php
            require 'util.php';
            global $connection;

            // Validate the customer ID
            $customer = getCustomerByID($_POST['customer_id']);
            if ($customer != null) {
                $customer_id = $customer['customer_id'];
                $total = $_POST['total_price'];

                // Create the order
                // Get the new order_id
                $sql = "SELECT MAX(order_id) as order_number from `order`;";
                $result = mysqli_query($connection, $sql);
                $row = mysqli_fetch_array($result);

                // Build the order query
                $order_id = $row["order_number"] + 1;
                $order_date = strval(date("Y-m-d"));

                $sql = sprintf("INSERT INTO `order` (order_id, customer_id, order_date) VALUES (%d, %d, '%s');", $order_id, $customer_id, $order_date);
                mysqli_query($connection, $sql);

                // Do the order_item queries
                foreach ($_SESSION['cart'] as $key => $value) {
                    $sql = sprintf('INSERT INTO order_item (order_id, product_id, quantity) VALUES (%s, %s, %s);', $order_id, $key, $value);
                    mysqli_query($connection, $sql);
                }

                // Do the transaction query
                $sql = 'SELECT MAX(transaction_id) as transaction_id FROM transaction;';
                $result = mysqli_query($connection, $sql);
                $row = mysqli_fetch_array($result);
                $transaction_id = $row['transaction_id'] + 1;

                $sql = 'SELECT net FROM transaction;';
                $result = mysqli_query($connection, $sql);
                $row = mysqli_fetch_array($result);
                $net = $row['net'] + $total;


                $sql = sprintf("INSERT INTO `transaction` (transaction_id, `change`, date, net) VALUES (%d, %d, '%s', %d);", $transaction_id, $total, $order_date, $net);
                mysqli_query($connection, $sql);

                restock();

                // Clear Cart
                $_SESSION['cart'] = [];

                echo '<h1>Transaction Complete</h1>';
            } else {
                echo sprintf("<h1>Invalid Customer ID</h1>", $customer);
            }
        ?>
    </head>

    <body>
    </body>
</html>