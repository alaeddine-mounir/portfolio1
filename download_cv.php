<?php
include 'config.php';

// Fetch the CV from the database
$sql = "SELECT filename, filedata FROM cv ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $filename = $row['filename'];
    $filedata = $row['filedata'];

    // Serve the file
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    echo $filedata;
} else {
    echo "No CV found.";
}

$conn->close();
?>
