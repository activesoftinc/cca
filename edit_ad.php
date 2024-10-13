<?php

include 'config.php';

// Fetch ad details
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM credit_cards WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$ad = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission for updating the ad
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bank_name = htmlspecialchars($_POST['bank_name']);
    $description = htmlspecialchars($_POST['description']);
    $affiliate_link = htmlspecialchars($_POST['affiliate_link']);

    // Handle image upload if a new image is selected
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        $image_path = 'uploads/' . basename($image['name']);
        move_uploaded_file($image['tmp_name'], $image_path);
    } else {
        $image_path = $ad['image_path'];  // Keep the current image if not changed
    }

    // Update the ad in the database
    $stmt = $conn->prepare("UPDATE credit_cards SET bank_name = :bank_name, description = :description, affiliate_link = :affiliate_link, image_path = :image_path WHERE id = :id");
    $stmt->bindParam(':bank_name', $bank_name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':affiliate_link', $affiliate_link);
    $stmt->bindParam(':image_path', $image_path);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "<p class='alert alert-success'>Ad updated successfully!</p>";
    } else {
        echo "<p class='alert alert-danger'>Failed to update ad. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Edit Credit Card Ad</h1>

        <form action="edit_ad.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="bank_name" class="form-label">Bank Name</label>
                <input type="text" class="form-control" id="bank_name" name="bank_name" value="<?php echo htmlspecialchars($ad['bank_name']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Card Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($ad['description']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="affiliate_link" class="form-label">Affiliate Link</label>
                <input type="url" class="form-control" id="affiliate_link" name="affiliate_link" value="<?php echo htmlspecialchars($ad['affiliate_link']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Credit Card Image (Leave blank to keep current image)</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <img src="<?php echo htmlspecialchars($ad['image_path']); ?>" alt="Current Image" width="100" class="mt-3">
            </div>

            <button type="submit" class="btn btn-primary">Update Ad</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>