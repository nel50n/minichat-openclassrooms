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
      <form action="minichat_post.php" method="post">
        <ul>
          <li>
            <label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" id="pseudo" required placeholder="Pseudo" autofocus>
          </li>
          <li>
            <label for="message">Message</label>
            <textarea name="message" id="message" rows="3" placeholder="Message"></textarea>
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
        <article class="message c1">
          <header>
            <h4>Someone</h4>
            <time>le 01/03/2015 à 18:27:02</time>
          </header>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquet dolor vel.</p>
        </article>
        <article class="message c2">
          <header>
            <h4>Another One</h4>
            <time>le 01/03/2015 à 18:27:02</time>
          </header>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquet dolor vel.</p>
        </article>
        <article class="message c1">
          <header>
            <h4>Someone</h4>
            <time>le 01/03/2015 à 18:27:02</time>
          </header>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquet dolor vel.</p>
        </article>
      </div>
      <footer>
        <p>Page 1</p>
      </footer>
    </section>
  </div>
</body>
</html>
