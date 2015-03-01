<?php
  // N'hésitez pas à éditer le fichier de configuration pour adapter
  // le mini-chat à votre environnement :
  include 'config.php';
  session_start();

  // ---------------------------------------------------------------------------
  // On se connecte à la base de données via PDO
  try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $user, $password);
  } catch (PDOException $e) {
    die($e->getMessage());
  }

  // ---------------------------------------------------------------------------
  // Récupération des champs de formulaire et sécurisation
  //
  $pseudo  = isset($_POST['pseudo']) ? htmlspecialchars($_POST['pseudo']) : "";
  $message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : "";

  // On retient le pseudo
  if (!empty($pseudo)) {
    $_SESSION['pseudo'] = $pseudo;
  }

  // Les deux champs sont requis
  if (empty($pseudo) || empty($message)) {
    $_SESSION['error'] = 'Merci de renseigner tous les champs';
  } else {
    // On enregistre le message
    $req = $pdo->prepare("INSERT INTO `$table` (`pseudo`, `message`) VALUES (?, ?);");
    $req->execute(array($pseudo, $message));
  }

  // Et on redirige vers la première page
  header('Location: minichat.php');
?>
