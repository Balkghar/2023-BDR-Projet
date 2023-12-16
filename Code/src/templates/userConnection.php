<?php require('header.php') ?>
<?php
if (isset($_SESSION["connected"]) && $_SESSION["connected"] == true) {


?>
   <p>Vous êtes déjà connecté!</p>
<?php
} else {
?>
   <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <label for="lname">Mail :</label><br>
      <input type="text" id="mail" name="mail"><br>
      <label for="lname">Mot de passe :</label><br>
      <input type="password" id="password" name="password"><br>
      <input type="submit" value="Se connecter">
   </form>

<?php }
require('footer.php') ?>