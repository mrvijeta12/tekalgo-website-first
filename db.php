
<?php

$host = '62.72.28.204';
$dbname = 'u360288577_slsfrcclds';
$username = 'u360288577_tekAlgo_slsfrs';
$password = '[Cc/?;6nQ2';

try {
    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}
?>