<?php

$accepted_origins = array(
    "http://localhost",
    "https://salesforceclouds.com",
    "http://salesforceclouds.com"
);

$imageFolder = "uploads/";

// Ensure the uploads folder exists
if (!is_dir($imageFolder)) {
    mkdir($imageFolder, 0755, true);
}

if (isset($_SERVER['HTTP_ORIGIN'])) {
    if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
        header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
    } else {
        error_log("Origin Denied: " . $_SERVER['HTTP_ORIGIN']);
        header("HTTP/1.1 403 Origin Denied");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    exit;
}

reset($_FILES);
$temp = current($_FILES);
if (is_uploaded_file($temp['tmp_name'])) {
    if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
        error_log("Invalid file name: " . $temp['name']);
        header("HTTP/1.1 400 Invalid file name.");
        exit;
    }

    if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "jpeg", "png"))) {
        error_log("Invalid file extension: " . $temp['name']);
        header("HTTP/1.1 400 Invalid extension.");
        exit;
    }

    $fileName = uniqid() . '_' . basename($temp['name']);
    $filetowrite = $imageFolder . $fileName;

    if (move_uploaded_file($temp['tmp_name'], $filetowrite)) {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? "https://" : "http://";
        $baseurl = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . "/";
        echo json_encode(array('location' => $baseurl . $filetowrite));
    } else {
        error_log("Upload failed for file: " . $temp['name']);
        header("HTTP/1.1 400 Upload failed.");
        exit;
    }
} else {
    error_log("File not uploaded properly.");
    header("HTTP/1.1 500 Server Error");
    exit;
}
