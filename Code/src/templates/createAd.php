<?php
include('header.php');
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   <div class="form-group">
      <label for="fname">Titre :</label>
      <input class="form-control" type="text" id="title" name="title">
   </div>

   <div class="form-group">
      <label for="lname">Description :</label>
      <textarea class="form-control" id="description" name="description" rows="4" cols="50"></textarea>

   </div>
   <div class="form-group">
      <label for="lname">Prix :</label>
      <input class="form-control" type="number" step="0.05" id="price" name="price">
   </div>


   <div class="form-group">

      <label for="startDate">Catégorie :</label>
      <select class="form-control" name="category" id="category">
         <?php
         foreach ($categories as $category) {
            echo ("<option value=\"" . $category['name'] . "\">" . $category['name'] . "</option>");
         }
         ?>
      </select>
   </div>

   <div class="form-group">

      <label for="startDate">Interval de location :</label>
      <select class="form-control" name="interval" id="interval">
         <?php
         foreach ($priceIntervals as $priceInterval) {
            echo ("<option value=\"" . $priceInterval . "\">" . $priceInterval . "</option>");
         }
         ?>
      </select>
   </div>

   <div class="form-group">
      <label for="startDate">Zip de la ville de votre objet :</label>
      <select class="form-control" name="zipCity" id="zipCity">
         <?php
         foreach ($cities as $city) {
            echo ("<option value=\"" . $city['zip'] . "\">" . $city['name'] . " / " . $city['zip'] . "</option>");
         }
         ?>
      </select>
   </div>

   <div class="form-group">
      <label for="lname">Rue :</label>
      <input class="form-control" type="text" id="street" name="street">
   </div>

   <div class="form-group">
      <label for="lname">Numéro de rue :</label>
      <input class="form-control" type="text" id="streetNumber" name="streetNumber">
   </div>
   <input class="btn btn-primary" type="submit" value="Créer">
</form>
<?php
include('footer.php');
