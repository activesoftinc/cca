<?php

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $bank_id = (int)$_POST['bank_id'];

    // Insert the lead into the leads table
    $stmt = $conn->prepare("INSERT INTO leads (name, email, phone, bank_id) VALUES (:name, :email, :phone, :bank_id)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':bank_id', $bank_id);

    if ($stmt->execute()) {
        // Fetch the bank affiliate link
        $stmt = $conn->prepare("SELECT affiliate_link FROM credit_cards WHERE id = :id");
        $stmt->bindParam(':id', $bank_id, PDO::PARAM_INT);
        $stmt->execute();
        $card = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($card) {
            $affiliate_link = $card['affiliate_link'];
            echo "<h2>Thank you, $name!</h2>";
            echo "<p>Your information has been submitted for the credit card.</p>";
            echo "<p>Redirecting to <a href='$affiliate_link'>complete your application</a>...</p>";
            header("refresh:5;url=$affiliate_link");
        } else {
            echo "Invalid credit card selection.";
        }
    } else {
        echo "Failed to submit your lead. Please try again.";
    }
}
