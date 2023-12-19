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
if (isset($_SESSION["connected"]) and $_SESSION['connected'] == true and isset($_SESSION["userId"]) and $ad['iduser'] != $_SESSION["userId"]) {
?>
   <form action="/action_page.php">
      <input type="hidden" name="id" value="<?php echo ($ad['id']) ?>">
      <label for="startDate">Date de départ :</label>
      <input type="date" id="birthday" name="birthday"><br>
      <label for="endDate">Date de fin :</label>
      <input type="date" id="birthday" name="birthday"><br>
      <input type="submit" value="Demander Location">
   </form>
<?php
}



require('footer.php')

?>