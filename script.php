<?php
require_once 'vendor/autoload.php';

$databaseFile = 'database_ecommerce.db';

//clé de cryptage
$encryptionKey = 'votre_clé_de_cryptage_très_sécurisée';
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

// Fonction pour crypter une donnée
function encryptData($data, $key, $iv) {
    return openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
}

// Fonction pour décrypter une donnée
function decryptData($encryptedData, $key, $iv) {
    return openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
}

try {
    if (!file_exists($databaseFile)) {
        die("La base de données n'existe pas !");
    }

    $db = new PDO("sqlite:$databaseFile");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insertion utilisateur avec Faker
//    $stmt = $db->prepare("INSERT INTO User (name, email, phone) VALUES (:name, :email, :phone)");
//    $stmt->bindParam(':name', $name);
//    $stmt->bindParam(':email', $email);
//    $stmt->bindParam(':phone', $phone);

// Générer des données aléatoires pour un utilisateur
//    $name = $faker->name;
//    $email = $faker->email;
//    $phone = $faker->phoneNumber;
//    $stmt->execute();

    // Afficher les utilisateurs
    echo "\nListe des utilisateurs :\n";
    $stmt = $db->query("SELECT * FROM User");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($users as $user) {
        echo $user['name'] . " - " . $user['email'] . " - " . $user['phone'] . "\n";
    }

    // Afficher les produits
    echo "\nListe des produits :\n";
    $stmt = $db->query("SELECT * FROM Product");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($products as $product) {
        echo $product['product'] . " - " . $product['price'] . "\n";
    }

    // Afficher les adresses
    echo "\nListe des adresses :\n";
    $stmt = $db->query("SELECT * FROM Adress");
    $adresses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($adresses as $adress) {
        echo " User ID: " . $adress['id_user'] . " - " . $adress['city'] . " - " . $adress['adress'] . "\n";
    }

    // Afficher les commandes
    echo "\nListe des commandes :\n";
    $stmt = $db->query("SELECT * FROM Command");
    $commands = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($commands as $command) {
        echo $command['id_command'] . " - User ID: " . $command['id_user'] . " - List ID: " . $command['id_list'] . " - Total Price: " . $command['total_price'] . "\n";
    }

    // Afficher les factures
    echo "\nListe des factures :\n";
    $stmt = $db->query("SELECT * FROM Invoices");
    $invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($invoices as $invoice) {
        echo $invoice['id_invoices'] . " - Command ID: " . $invoice['id_command'] . " - Time Arrived: " . $invoice['time_arrived'] . "\n";
    }

    // Afficher les paiements
    echo "\nListe des paiements :\n";
    $stmt = $db->query("SELECT * FROM Payment");
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($payments as $payment) {
        // Décrypter les informations sensibles avant de les afficher
        $decryptedIban = decryptData($payment['iban'], $encryptionKey, $iv);
        echo $payment['id_payment'] . " - User ID: " . $payment['id_user'] . " - Adress ID: " . $payment['id_adress'] . " - Payment Method: " . $payment['payment_method'] . " - IBAN: " . $decryptedIban . "\n";
    }

} catch (PDOException $e) {
    // affiche un message d'erreur si ya un soucis
    die("Erreur : " . $e->getMessage());
}

?>
