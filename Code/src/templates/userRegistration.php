<?php require('header.php') ?>


<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="form-group">
        <label for="fname">Prénom :</label>
        <input class="form-control" type="text" id="firstname" name="firstname" required>
    </div>

    <div class="form-group">
        <label for="lname">Nom :</label>
        <input class="form-control" type="text" id="lastname" name="lastname" required>
    </div>
    <div class="form-group">
        <label for="lname">Mail :</label>
        <input class="form-control" type="text" id="mail" name="mail" required>
    </div>
    <div class="form-group">
        <label for="lname">Mot de passe :</label>
        <input class="form-control" type="password" id="password" name="password" required>
    </div>

    <div class="form-group">
        <label for="lname">Numéro de téléphone :</label>
        <input class="form-control" type="tel" id="phoneNumber" name="phoneNumber" required>
    </div>

    <div class="form-group">
        <label for="startDate">Ville :</label>
        <select class="form-control" name="city" id="city" required>
            <?php
            foreach ($cities as $city) {
                echo ("<option value=\"" . $city['zip'] . "\">" . $city['name'] . " / " . $city['zip'] . "</option>");
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="lname">Rue :</label>
        <input class="form-control" type="text" id="street" name="street" required>
    </div>

    <div class="form-group">
        <label for="lname">Numéro de rue :</label>
        <input class="form-control" type="text" id="street" name="streetNumber" required>
    </div>
    <input class="btn btn-primary" type="submit" value="S'inscrire">
</form>


<?php require('footer.php') ?>