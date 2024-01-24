<?php require('header.php') ?>
    <form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-group">
            <label for="fname">Titre :</label>
            <input class="form-control" type="text" value="<?php echo($ad['title']) ?>" id="title" name="title">
        </div>
        <div class="form-group">
            <?php
            if ($ad['pictures'] != null) {
                $pictures = array_map('trim', explode(',', trim(trim($ad['pictures'], '{}'), "\"\"")));

                foreach ($pictures as $picture) {
                    ?>
                    <img src="<?= $picture ?>" class="d-block img-carousel" alt="Ad Picture">
                    <input type="checkbox" name="deletePictures[]" value="<?= $picture ?>"/>
                    <label for="deletePictures">Supprimer</label>
                    <?php
                }
            }
            ?>

        </div>
        <div class="form-group">
            <label for="fname">Ajouter des image(s) :</label>
            <input type="file" name="files[]" id="files[]" multiple>
        </div>
        <div class="form-group">
            <label for="lname">Description :</label>
            <textarea class="form-control" id="description" name="description" rows="4"
                      cols="50"><?php echo($ad['description']) ?></textarea>

        </div>
        <div class="form-group">
            <label for="lname">Prix :</label>
            <input class="form-control" value="<?php echo($ad['price']) ?>" type="number" step="0.05" id="price"
                   name="price">
        </div>


        <div class="form-group">

            <label for="startDate">Catégorie :</label>
            <select class="form-control" name="category" id="category">
                <?php
                foreach ($categories as $category) {
                    if ($ad['namecategory'] == $category['name']) {
                        echo("<option selected=\"selected\" value=\"" . $category['name'] . "\">" . $category['name'] . "</option>");
                    } else {
                        echo("<option value=\"" . $category['name'] . "\">" . $category['name'] . "</option>");
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group">

            <label for="startDate">Interval de location :</label>
            <select class="form-control" name="interval" id="interval">
                <?php
                foreach ($priceIntervals as $priceInterval) {
                    if ($ad['priceinterval'] == $priceInterval) {
                        echo("<option selected=\"selected\" value=\"" . $priceInterval . "\">" . $priceInterval . "</option>");
                    } else {
                        echo("<option value=\"" . $priceInterval . "\">" . $priceInterval . "</option>");
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="startDate">Zip de la ville de votre objet :</label>
            <select class="form-control" name="zipCity" id="zipCity">
                <?php
                foreach ($cities as $city) {

                    if ($ad['zipcity'] == $city['zip']) {
                        echo("<option selected=\"selected\" value=\"" . $city['zip'] . "\">" . $city['name'] . " / " . $city['zip'] . "</option>");
                    } else {
                        echo("<option value=\"" . $city['zip'] . "\">" . $city['name'] . " / " . $city['zip'] . "</option>");
                    }
                }
                ?>
            </select>
        </div>
        <input type="hidden" id="idaddr" name="idaddr" value="<?php echo($ad['idaddr']) ?>">
        <input type="hidden" id="id" name="id" value="<?php echo($ad['id']) ?>">
        <div class="form-group">
            <label for="lname">Rue :</label>
            <input class="form-control" value="<?php echo($ad['street']) ?>" type="text" id="street" name="street">
        </div>

        <div class="form-group">
            <label for="lname">Numéro de rue :</label>
            <input class="form-control" value="<?php echo($ad['streetnumber']) ?>" type="text" id="streetNumber"
                   name="streetNumber">
        </div>
        <input class="btn btn-primary" type="submit" value="Modifier">
    </form>
<?php require('footer.php') ?>