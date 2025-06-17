<?php
require_once '../config/database.php';
require_once '../app/Controllers/UrlController.php';
require_once '../app/Models/Url.php';

$controller = new UrlController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->shortenUrl();
} elseif (isset($_GET['url'])) {
    $controller->redirect($_GET['url']);
} else {
    $controller->index();
}
