<?php

require 'config/Database.php';
require 'controlers/Api.php';
require 'controlers/BarcodeGenerator.php';
require 'controlers/TicketModel.php'; 
require 'controlers/OrderTicket.php';

$database = new Database('mysql', 'my_database', 'my_user', 'user_password');
$order = new OrderTicket(1, '2023-06-15', ['Lgota', 'Lgota', 'Old', 'Old', 'Lgota']); 
$order->makeOrder($database);