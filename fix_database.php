<?php
// Add missing columns to patients table
$conn = mysqli_connect('127.0.0.1', 'root', '', 'hospitex');

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

$queries = [
    'ALTER TABLE patients ADD COLUMN insurance_provider VARCHAR(255) NULL',
    'ALTER TABLE patients ADD COLUMN insurance_id VARCHAR(255) NULL',
    'ALTER TABLE patients ADD COLUMN date_admitted DATE NULL',
    "ALTER TABLE patients ADD COLUMN status ENUM('In', 'Out', 'Discharged') DEFAULT 'In'"
];

foreach ($queries as $query) {
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "✓ Column added successfully\n";
    } else {
        $error = mysqli_error($conn);
        if (strpos($error, 'Duplicate column') !== false) {
            echo "✓ Column already exists\n";
        } else {
            echo "✗ Error: " . $error . "\n";
        }
    }
}

mysqli_close($conn);
echo "\nDatabase update complete!\n";
?>
