<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "authapp"
);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}