<?php require('header.php') ?>
<h1><?php echo ($ad['title']) ?></h1>
<h2>Date de création : <?php echo ($ad['creationdate']) ?></h2>
<h2>Prix : <?php echo ($ad['price']) ?></h2>
<h3>Rating : <?php
               if ($ad['avg'] != null)
                  echo (round($ad['avg'], 2));
               else
                  echo ("-")
               ?>
</h3>
<p><?php echo ($ad['description']) ?></p>

<?php
if (isset($_SESSION["connected"]) and $_SESSION['connected'] == true and isset($_SESSION["userId"]) and $ad['idprofile'] != $_SESSION["userId"]) {
?>
   <form method="post" action="/makeRent.php">
      <input type="hidden" name="id" value="<?php echo ($ad['id']) ?>">
      <label for="startDate">Date de départ :</label>
      <input type="datetime-local" id="startDate" name="startDate"><br>
      <label for="endDate">Date de fin :</label>
      <input type="datetime-local" id="endDate" name="endDate"><br>
      <select name="paymentMethod" id="paymentMethod">
         <?php
         foreach ($paymentMethod as $text) {
            echo ("<option value=\"" . $text . "\">" . $text . "</option>");
         }
         ?>
      </select><br>
      <textarea id="comment" name="comment" rows="4" cols="50"></textarea><br>
      <input type="submit" value="Demander Location">
   </form>
<?php
}



require('footer.php')

?>