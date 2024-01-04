<?php require('header.php'); ?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   <div class="form-group">
      <label for="fname">Prénom :</label>
      <input class="form-control" type="text" id="firstname" name="firstname" value="<?php echo ($user['firstname']); ?>">
   </div>

   <div class="form-group">
      <label for="lname">Nom :</label>
      <input class="form-control" type="text" id="lastname" name="lastname" value="<?php echo ($user['lastname']); ?>">
   </div>
   <div class="form-group">
      <label for="lname">Mail :</label>
      <input class="form-control" type="text" id="mail" name="mail" value="<?php echo ($user['mail']); ?>">
   </div>
   <div class="form-group">
      <label for="lname">Numéro de téléphone :</label>
      <input class="form-control" type="tel" id="phoneNumber" name="phoneNumber" value="<?php echo ($user['phonenumber']); ?>">
   </div>
   <div>
      <label for="startDate">Ville :</label>
      <select class="form-control" name="zipCity" id="zipCity">

         <option id="default" value=""></option>
         <?php
         foreach ($cities as $city) {
            if ($city['zip'] == $user['zip']) {
               $tmp = "selected=\"selected\"";
            } else {
               $tmp = "";
            }
            echo ("<option id=\"" . $city['canton'] . "\"" . $tmp . " value=\"" . $city['zip'] . "\">" . $city['zip'] . " / " . $city['name'] . "</option>");
         }
         ?>
      </select>
   </div>

   <div class="form-group">
      <label for="lname">Rue :</label>
      <input class="form-control" type="text" id="street" name="street" value="<?php echo ($user['street']); ?>">
   </div>

   <div class="form-group">
      <label for="lname">Numéro de rue :</label>
      <input class="form-control" type="text" id="street" name="streetNumber" value="<?php echo ($user['streetnumber']); ?>">
   </div>

   <input class="btn btn-primary" type="submit" value="Modifier">
</form>


<?php require('footer.php'); ?>