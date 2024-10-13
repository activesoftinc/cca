<?php

include 'config.php';

// Fetch all ads
$stmt = $conn->prepare("SELECT id, bank_name, description, affiliate_link, image_path FROM credit_cards");
$stmt->execute();
$ads = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Ads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Manage Credit Card Ads</h1>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Bank Name</th>
                    <th>Description</th>
                    <th>Affiliate Link</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ads as $ad): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($ad['bank_name']); ?></td>
                        <td><?php echo htmlspecialchars($ad['description']); ?></td>
                        <td><?php echo htmlspecialchars($ad['affiliate_link']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($ad['image_path']); ?>" alt="Ad Image" width="100"></td>
                        <td>
                            <a href="edit_ad.php?id=<?php echo $ad['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_ad.php?id=<?php echo $ad['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this ad?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>