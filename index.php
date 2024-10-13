<?php

include 'config.php';

// Fetch credit cards from the database
$stmt = $conn->prepare("SELECT * FROM credit_cards");
$stmt->execute();
$cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best Credit Cards - Compare & Apply</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <header class="bg-dark text-white text-center p-3">
        <h1>Compare and Apply for Best Credit Cards</h1>
        <p>Find the best credit card deals from top banks. Click, apply, and earn rewards!</p>
    </header>

    <div class="container my-5">
        <div class="row">
            <?php foreach ($cards as $card): ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="<?php echo $card['image_path']; ?>" class="card-img-top" alt="<?php echo $card['bank_name']; ?> Credit Card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $card['bank_name']; ?> Credit Card</h5>
                            <p class="card-text"><?php echo $card['description']; ?></p>
                            <a href="affiliate.php?bank_id=<?php echo $card['id']; ?>" class="btn btn-primary">Apply Now</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer class="bg-dark text-white text-center p-3">
        <p>&copy; 2024 Credit Card Affiliate. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>