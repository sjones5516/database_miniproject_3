-- MySQL Workbench 8.0.41 Script to update product schedule
USE `pharm_db_project`;

-- Clear existing data if any
DELETE FROM order_item;
DELETE FROM `order`;
DELETE FROM restock_request;
DELETE FROM supplier;
DELETE FROM product;
DELETE FROM customer;
DELETE FROM transaction;

SET FOREIGN_KEY_CHECKS = 0;

-- Insert data into customer table
INSERT INTO customer (customer_id, insurance_policy, name, address, email) VALUES
(12345, 'Medicare', 'John Smith', '987 Main Street', 'jsmith@gmail.com'),
(74656, 'United Healthcare', 'Kathryn Janeway', '152 Delta Dr', '70ussvoy@bellsouth.net'),
(17929, 'Elevance Health', 'Ruby Rose', '718 Beacon Blvd', 'cresrose@gmail.com'),
(25170, 'CVS Health', 'Malcolm Reynolds', '511 Serenity Way', 'browncoat1@aol.com'),
(61910, 'Cigna', 'Lynne Trick', '444 Temsik Place', 'missile3@yahoo.com');

-- Insert data into product table with random schedule values between 0 and 5
INSERT INTO product (product_id, stock, price, name, schedule) VALUES
(1539, 13, 16.99, 'Dayquil', 2),
(7027, 2, 16.99, 'Nyquil', 3),
(3803, 30, 9.99, 'Advil', 0),
(5482, 29, 5.99, 'Tylenol', 1),
(2397, 60, 6.99, 'Halls', 0),
(3512, 25, 12.99, 'Pepto Bismol', 0),
(4735, 18, 16.49, 'Zyrtec', 1),
(9977, 15, 7.79, 'Tums', 0),
(8733, 34, 56.49, 'NicoDerm', 2),
(9932, 50, 18.99, 'BinaxNow', 0);

-- Insert data into supplier table
INSERT INTO supplier (supplier_id, name, address, email) VALUES
(737, 'Pfizer', '2002 N Tampa St', 'usbus@pfizer.com'),
(954, 'Johnson & Johnson', '4301 W Boy Scout Blvd', 'jombus@its.jnj.com'),
(500, 'AstraZeneca', '4222 Emperor Blvd', 'businfo@astrazeneca.com');

-- Insert data into order table with order dates
INSERT INTO `order` (order_id, customer_id, order_date) VALUES
(124, 12345, '2025-04-10'),
(125, 17929, '2025-04-11'),
(126, 25170, '2025-04-12'),
(127, 12345, '2025-04-12'),
(128, 74656, '2025-04-13'),
(129, 74656, '2025-04-14'),
(130, 17929, '2025-04-14'),
(131, 61910, '2025-04-15'),
(132, 25170, '2025-04-15'),
(133, 61910, '2025-04-16');

-- Insert data into order_item table
INSERT INTO order_item (order_id, product_id, quantity) VALUES
(124, 1539, 1),
(124, 7027, 1),
(125, 2397, 1),
(125, 7027, 2),
(126, 3512, 1),
(126, 8733, 1),
(127, 9932, 6),
(127, 2397, 2),
(128, 4735, 1),
(128, 9977, 1),
(129, 3803, 1),
(129, 5482, 5),
(130, 8733, 1),
(130, 9932, 4),
(131, 3512, 1),
(131, 9977, 8),
(132, 4735, 1),
(132, 2397, 1),
(133, 9932, 1),
(133, 3803, 1);

-- Insert data into restock_request table
INSERT INTO restock_request (transaction_id, product_id, supplier_id, quantity) VALUES
(1, 1539, 737, 7),
(2, 7027, 737, 7),
(3, 3803, 500, 10),
(4, 5482, 954, 10),
(5, 2397, 954, 5),
(6, 3512, 500, 12),
(7, 4735, 737, 5),
(8, 9977, 500, 12),
(9, 8733, 954, 4),
(10, 9932, 954, 15);

-- Insert transaction record for 4/20/25 with change of 0 and net of 420,000
INSERT INTO transaction (transaction_id, `change`, date, net) VALUES
(1, 0, '2025-04-20', 420000);

SET FOREIGN_KEY_CHECKS = 1;