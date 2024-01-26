<?php require('header.php') ?>
<?php
if (isset($_SESSION["connected"]) && $_SESSION["connected"] == true) {


?>
    <p>Vous êtes déjà connecté!</p>
<?php
} else {
?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-group">

            <label for="lname">Mail :</label>
            <input class="form-control" type="email" id="mail" name="mail" required>

        </div>
        <div class="form-group">
            <label for="lname">Mot de passe :</label>
            <input class="form-control" type="password" id="password" name="password" required>
        </div>
        <input class="btn btn-primary" type="submit" value="Se connecter">
    </form>

<?php }
require('footer.php') ?>