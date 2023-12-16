<!DOCTYPE html>
<html lang="en">

<head>
  <title>Prêt de chez toi</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>

<body>

  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">Prêt de chez toi</a>
        <?php
        if (isset($_SESSION["connected"]) && $_SESSION["connected"] == true) { ?>

          <button class="btn btn-outline-success my-2 my-sm-0" onclick="location.href='userDeconnection.php';">Se déconnecter</button>
        <?php } else {
        ?>

          <button class="btn btn-outline-success my-2 my-sm-0" onclick="location.href='userConnection.php';">Se connecter</button>
          <button class="btn btn-outline-success my-2 my-sm-0" onclick="location.href='userRegistration.php';">S'inscrire</button>
        <?php } ?>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li class="active"><a href="index.php">Home</a></li>
        </ul>
      </div>
    </div>
  </nav>