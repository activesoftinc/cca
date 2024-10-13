<?php

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bank_name = htmlspecialchars($_POST['bank_name']);
    $description = htmlspecialchars($_POST['description']);
    $affiliate_link = htmlspecialchars($_POST['affiliate_link']);

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Get image details
        $image = $_FILES['image'];
        $image_name = $image['name'];
        $image_tmp_name = $image['tmp_name'];
        $image_size = $image['size'];
        $image_error = $image['error'];
        $image_type = $image['type'];

        // Define allowed file types (JPEG, PNG)
        $allowed_types = ['image/jpeg', 'image/png'];
        if (in_array($image_type, $allowed_types)) {
            // Move the uploaded file to a directory
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);  // Create directory if it doesn't exist
            }

            $image_path = $upload_dir . basename($image_name);
            if (move_uploaded_file($image_tmp_name, $image_path)) {
                // Insert ad into credit_cards table
                $stmt = $conn->prepare("INSERT INTO credit_cards (bank_name, description, affiliate_link, image_path) VALUES (:bank_name, :description, :affiliate_link, :image_path)");
                $stmt->bindParam(':bank_name', $bank_name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':affiliate_link', $affiliate_link);
                $stmt->bindParam(':image_path', $image_path);

                if ($stmt->execute()) {
                    echo "<p class='alert alert-success'>Ad for $bank_name successfully added!</p>";
                } else {
                    echo "<p class='alert alert-danger'>Failed to add ad. Please try again.</p>";
                }
            } else {
                echo "<p class='alert alert-danger'>Failed to upload image.</p>";
            }
        } else {
            echo "<p class='alert alert-danger'>Invalid file type. Only JPEG and PNG are allowed.</p>";
        }
    } else {
        echo "<p class='alert alert-danger'>Please upload a valid image file.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Ad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Add New Credit Card Ad</h1>
        <form action="add_ad.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="bank_name" class="form-label">Bank Name</label>
                <input type="text" class="form-control" id="bank_name" name="bank_name" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Card Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="affiliate_link" class="form-label">Affiliate Link</label>
                <input type="url" class="form-control" id="affiliate_link" name="affiliate_link" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Credit Card Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Ad</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>