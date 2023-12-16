<?php require('header.php') ?>


<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   <label for="fname">Prénom :</label><br>
   <input type="text" id="firstname" name="firstname"><br>
   <label for="lname">Nom :</label><br>
   <input type="text" id="lastname" name="lastname"><br>
   <label for="lname">Mail :</label><br>
   <input type="text" id="mail" name="mail"><br>
   <label for="lname">Mot de passe :</label><br>
   <input type="password" id="password" name="password"><br>
   <label for="lname">Numéro de téléphone :</label><br>
   <input type="tel" id="phoneNumber" name="phoneNumber"><br>
   <label for=" lname">Zip de votre ville :</label><br>
   <input type="text" id="zipCity" name="zipCity"><br>
   <label for="lname">Rue :</label><br>
   <input type="text" id="street" name="street"><br>
   <label for="lname">Numéro de rue :</label><br>
   <input type="text" id="street" name="streetNumber"><br>
   <input type="submit" value="S'inscrire">
</form>


<?php require('footer.php') ?>