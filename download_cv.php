<?php
include 'config.php';

// Function to sanitize the input (avoid SQL injection)
function sanitize($conn, $input) {
    return mysqli_real_escape_string($conn, $input);
}

if (isset($_GET['cv_id'])) {
    $cv_id = sanitize($conn, $_GET['cv_id']);

    // Fetch the CV from the database
    $sql = "SELECT filename, filedata FROM cv WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cv_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($filename, $filedata);
        $stmt->fetch();

        // Serve the file as a PDF for download
        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        echo $filedata;

        // Optionally, display the content of the PDF (requires PDFlib)
        // $pdf = new PDFlib();
        // $pdf->set_option("errorpolicy=return");
        // $pdf->begin_document("", "");
        // $pdf->set_info("Creator", "Your Name");
        // $pdf->set_info("Author", "Your Name");
        // $pdf->set_info("Title", "CV");
        // $pdf->set_info("Subject", "CV");
        // $pdf->set_info("Keywords", "CV, download");
        // $pdf->begin_page_ext(595, 842, "");
        // $pdf->fit_textflow($tf, 50, 750, 500, 700, "fillcolor={rgb 0 0 1}");
        // $pdf->end_page_ext("");
        // $pdf->end_document("");

    } else {
        echo "CV not found.";
    }

    $stmt->close();
} else {
    echo "CV ID not provided.";
}

$conn->close();
?>
