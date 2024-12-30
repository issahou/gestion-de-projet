<?php
session_start();

include_once '../classes/Database.php';
include_once '../classes/Utilisateur.php';

$database = new Database();
$db = $database->getConnection();

$utilisateur = new Utilisateur($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $password = htmlspecialchars(strip_tags($_POST['password']));

    if ($utilisateur->verifierIdentifiants($email, $password)) {
        $_SESSION['utilisateur_id'] = $utilisateur->id;
        $_SESSION['role'] = $utilisateur->role;
        header("Location: indexe.php");
        exit();
    } else {
        $message = "Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Connexion</title>
</head>
<body>
    <div class="container">
        <h1>Connexion</h1>
        <?php if (isset($message)) echo "<p style='color:red;'>$message</p>"; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="input-field" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" class="input-field" required>
            </div>
            <input type="submit" value="Se connecter" class="btn">
        </form>
    </div>
</body>
</html>
