<?php require('header.php') ?>


    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-group">
            <label for="fname">Prénom :</label>
            <input class="form-control" type="text" id="firstname" name="firstname">
        </div>

        <div class="form-group">
            <label for="lname">Nom :</label>
            <input class="form-control" type="text" id="lastname" name="lastname">
        </div>
        <div class="form-group">
            <label for="lname">Mail :</label>
            <input class="form-control" type="text" id="mail" name="mail">
        </div>
        <div class="form-group">
            <label for="lname">Mot de passe :</label>
            <input class="form-control" type="password" id="password" name="password">
        </div>

        <div class="form-group">
            <label for="lname">Numéro de téléphone :</label>
            <input class="form-control" type="tel" id="phoneNumber" name="phoneNumber">
        </div>

        <div class="form-group">
            <label for=" lname">Zip de votre ville :</label>
            <input class="form-control" type="text" id="zipCity" name="zipCity">
        </div>

        <div class="form-group">
            <label for="lname">Rue :</label>
            <input class="form-control" type="text" id="street" name="street">
        </div>

        <div class="form-group">
            <label for="lname">Numéro de rue :</label>
            <input class="form-control" type="text" id="street" name="streetNumber">
        </div>
        <input class="btn btn-primary" type="submit" value="S'inscrire">
    </form>


<?php require('footer.php') ?>