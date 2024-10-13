<?php

include 'config.php';

// Delete ad
$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM credit_cards WHERE id = :id");
$stmt->bindParam(':id', $id);

if ($stmt->execute()) {
    echo "<p class='alert alert-success'>Ad deleted successfully!</p>";
} else {
    echo "<p class='alert alert-danger'>Failed to delete ad. Please try again.</p>";
}

// Redirect back to manage ads page
header("Location: manage_ads.php");
