<?php
    session_start();
    $db_server = "";
    $db_user = "";
    $db_pass = "";
    $db_name = "";

    $connection = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    if (mysqli_connect_error()) {
        die("Connection failed: ". mysqli_connect_error());
    }

    function getProductCategories() : array {
        global $connection;
        $sql = "SELECT schedule FROM product GROUP BY schedule ORDER BY schedule ASC";
        $query = mysqli_query($connection, $sql);
        $categories = [];
        while ($row = $query->fetch_assoc()) {
            $cat = ltrim($row["schedule"], "0");
            if ($cat == "") {
                $cat = "Unscheduled";
            }
            $categories[] = $cat;
        }
        return $categories;
    }

    function getProducts(int $category = -1) : array {
        global $connection;

        $sql = 'SELECT * FROM product';
        if ($category != -1) {
            $sql .= sprintf(' WHERE schedule = %d', $category);
        }
        $sql .= ';';

        $query = mysqli_query($connection, $sql);
        $products = [];
        while ($row = $query->fetch_assoc()) {
            $products[] = $row;
        }

        return $products;
    }

    function addToCart(int $product_id, int $quantity): void {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
    }

    function getProductByID(int $product_id): array {
        global $connection;

        $sql = sprintf('SELECT * FROM product WHERE product_id = %d;', $product_id);
        $query = mysqli_query($connection, $sql);
        $product = mysqli_fetch_assoc($query);
        return $product;
    }

    function getCustomerByID(int $customer_id): array | null {
        global $connection;
        $sql = sprintf('SELECT * FROM customer WHERE customer_id = %d', $customer_id);
        $query = mysqli_query($connection, $sql);
        $customer = mysqli_fetch_assoc($query);
        return $customer;
    }

    function restock(): void {
        global $connection;

        $restock_threshold = 25;
        $supplier_id = 500;
        // Get the latest transaction id
        $sql = "SELECT MAX(transaction_id) AS transaction_id FROM restock_request;";
        $query = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($query);
        $transaction_id = $row['transaction_id'];
        // Get all products where below threshold
        $sql = sprintf('SELECT * FROM product WHERE stock < %d', $restock_threshold);
        $query = mysqli_query($connection, $sql);
        $sql = "";
        while ($row = mysqli_fetch_assoc($query)) {
            $transaction_id++;
            $sql = sprintf("INSERT INTO restock_request (transaction_id, product_id, supplier_id, quantity) VALUES (%d, %d, %d, %d);",  $transaction_id, $row['product_id'], $supplier_id, 25 - $row['stock']);
            mysqli_query($connection, $sql);
        }
    }
?>