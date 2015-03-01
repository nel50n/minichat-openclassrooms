<?php
  // N'hésitez pas à éditer le fichier de configuration pour adapter
  // le mini-chat à votre environnement :
  include 'config.php';
  session_start();

  // ---------------------------------------------------------------------------
  // On se connecte à MySQL via PDO
  try {
    $pdo = new PDO("mysql:host=$host;charset=utf8", $user, $password);
  } catch (PDOException $e) {
    die($e->getMessage());
  }

  // On vérifie l'existence de la base de donnée et de la table
  try {
    $dbexist = $pdo->query("SELECT 1 FROM `$database`.`$table` LIMIT 1");
  } catch (PDOException $e) {
    $dbexist = false;
  }

  // Exécution du script d'initialisation de la base si besoin
  if (!$dbexist) {
    try {
      $sql = str_replace(['minichat', 'messages'],
                         [$database,  $table],
                file_get_contents('minichat.sql'));
      $pdo->exec($sql);
    } catch (PDOException $e) {
      die($e->getMessage());
    }
  }

  // On définit la base active
  $pdo->exec("USE `$database`;");

  // ---------------------------------------------------------------------------
  // Récupération des paramètres utiles
  $pseudo   = isset($_SESSION['pseudo']) ? $_SESSION['pseudo'] : '';

  $nbmsg    = $pdo->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
  $lastpage = ceil($nbmsg/$count);
  $page     = isset($_GET['page']) ? max(1, min(intval($_GET['page']), $lastpage)) : 1;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Mini-chat</title>
  <meta name="description" content="Mini-chat : Exercice du cours « Concevez votre site web avec PHP et MySQL » du site OpenClassrooms">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel='stylesheet' href='//fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,700'>
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
<!--[if lt IE 9]>
  <p class="browserupgrade">Vous utilisez un navigateur <strong>obsolète</strong>.<br>Merci de bien vouloir <a href="http://browsehappy.com/">mettre à jour votre navigateur</a>.</p>
  <div class="hidden">
<![endif]-->
<!--[if (!IE)|(gte IE 9)]><!-->
  <div class="wrapper">
<!--<![endif]-->

    <!-- Entête principal -->
    <header>
      <h1 class="text-center">Mini-chat <small>OpenClassrooms</small></h1>
    </header>

    <!-- Formulaire -->
    <section id="formulaire">
    <!-- Message d'erreur -->
<?php if (isset($_SESSION['error'])) { ?>
      <div class="error">
<?php   echo htmlspecialchars($_SESSION['error']);
        unset($_SESSION['error']); ?>
      </div>
<?php } ?>
      <form action="minichat_post.php" method="post">
        <ul>
          <li>
            <label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" id="pseudo" required placeholder="Pseudo"
             <?php echo empty($pseudo) ? 'autofocus' : "value=\"$pseudo\""; ?>>
          </li>
          <li>
            <label for="message">Message</label>
            <textarea name="message" id="message" rows="3" placeholder="Message"
             <?php if (!empty($pseudo)) echo 'autofocus'; ?>></textarea>
          </li>
        </ul>
        <button type="submit" class="btn">Envoyer</button>
      </form>
    </section>

    <!-- Historique des messages -->
    <section id="messages">
      <header>
        <h2>Discussion en cours</h2>
        <a href="?page=1" class="btn">Rafraîchir</a>
      </header>
      <div id="list">

<?php
  // ---------------------------------------------------------------------------
  // Liste chronologique inversée des messages de la page en cours + pagination
  $offset = ($page-1) * $count;
  $sql = "SELECT * FROM `$table` ORDER BY `published` DESC LIMIT $offset, $count";

  if ($nbmsg == 0) {
    echo '<p class="empty">(Aucun message)</p>';
  } else {
    foreach ($pdo->query($sql) as $message) {
      $color     = base_convert(substr(md5($message['pseudo']), -4), 16, 10) % 12 + 1;
      $published = strtotime($message['published']);

?>
        <article class="message c<?php echo $color;?>">
          <header>
            <h4><?php echo strip_tags($message['pseudo']); ?></h4>
            <time datetime="<?php echo $message['published']; ?>">
              <?php echo date('\l\e d/m/Y \à H:i:s', $published); ?>
            </time>
          </header>
          <p><?php echo nl2br(str_replace(['[g]', '[i]', '[s]', '[/g]', '[/i]', '[/s]'],
                                          ['<b>', '<i>', '<u>', '</b>', '</i>', '</u>'],
                                          strip_tags($message['message']))); ?></p>
        </article>
<?php
    }
  }
?>
      </div>
      <footer>
        <p>
          <a href="?page=<?php echo $page-1; ?>" class="prev
            <?php echo ($page === 1) ? 'invisible' : ''; ?>">&lt;</a>

          Page <?php echo $page ?>

          <a href="?page=<?php echo $page+1; ?>" class="next
            <?php echo ($page >= $lastpage) ? 'invisible' : ''; ?>">&gt;</a>
        </p>
      </footer>
    </section>
  </div>
</body>
</html>
