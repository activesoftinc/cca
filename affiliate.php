<?php

include 'config.php';

if (isset($_GET['bank_id'])) {
    $bank_id = (int)$_GET['bank_id'];

    // Fetch the credit card details based on the bank_id
    $stmt = $conn->prepare("SELECT * FROM credit_cards WHERE id = :id");
    $stmt->bindParam(':id', $bank_id, PDO::PARAM_INT);
    $stmt->execute();
    $card = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$card) {
        echo "Invalid bank selection.";
        die();
    }
} else {
    echo "No bank selected.";
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for <?php echo htmlspecialchars($card['bank_name']); ?> Credit Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div class="container my-5">
        <h2>Apply for <?php echo htmlspecialchars($card['bank_name']); ?> Credit Card</h2>
        <p>Fill out the form below to get started with your application.</p>

        <form action="submit_lead.php" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <input type="hidden" name="bank_id" value="<?php echo $card['id']; ?>">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>