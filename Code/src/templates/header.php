<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <title>Prêt de chez toi</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="../script/script.js"></script>
    <link type="text/css" rel="stylesheet" href="/script/style.css" />
</head>

<body class="d-flex flex-column h-100">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="/">Prêt de chez toi</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <?php
                    if (isset($_SESSION["connected"]) && $_SESSION["connected"] == true) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="userAd.php">Mes annonces</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="userRental.php">Mes locations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="userRentalOwner.php">Locations pour mes annonces</a>
                        </li>
                    <?php } ?>
                </ul>
                <?php
                if (isset($_SESSION["connected"]) && $_SESSION["connected"] == true) { ?>
                    <button class="btn btn-outline-success my-2 my-sm-0" onclick="location.href='account.php';">Mon compte
                    </button>
                    <button class="btn btn-outline-success my-2 my-sm-0" onclick="location.href='userDeconnection.php';">Se
                        déconnecter
                    </button>
                <?php } else {
                ?>
                    <button class="btn btn-outline-success my-2 my-sm-0" onclick="location.href='userConnection.php';">Se
                        connecter
                    </button>

                    <button class="btn btn-outline-success my-2 my-sm-0" onclick="location.href='userRegistration.php';">
                        S'inscrire
                    </button>
                <?php } ?>

            </div>
        </nav>
    </header>

    <main class="container" role="main">
        <div class="content">
            <br>
            <?php
            function showCarousel($ad)
            {
                if ($ad['pictures'] != null) {
                    // Trim each element to remove leading and trailing whitespaces
                    $pictures = array_map('trim', explode(',', str_replace("\"", "", trim($ad['pictures'], '{}'))));

            ?>
                    <div id="carouselPictures<?= $ad['id'] ?>" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner div-carousel">

                            <?php foreach ($pictures as $picIndex => $picture) { ?>
                                <div class="carousel-item <?php echo ($picIndex === 0) ? 'active' : ''; ?>">
                                    <img src="<?= $picture ?>" class="d-block mx-auto img-carousel" alt="Ad Picture">
                                </div>
                            <?php } ?>

                        </div>
                        <a class="carousel-control-prev" href="#carouselPictures<?= $ad['id'] ?>" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselPictures<?= $ad['id'] ?>" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <br>
            <?php
                }
            }
            function convertDateToHumanReadable($date)
            {
                // source : https://stackoverflow.com/questions/70930824/php-8-1-strftime-is-deprecated
                // "date_default_timezone_set" may be required by your server
                date_default_timezone_set('Europe/Zurich');

                // make a DateTime object 
                // the "now" parameter is for get the current date, 
                // but that work with a date recived from a database 
                // ex. replace "now" by '2022-04-04 05:05:05'
                $dateTimeObj = new DateTime($date, new DateTimeZone('Europe/Zurich'));

                // format the date according to your preferences
                // the 3 params are [ DateTime object, ICU date scheme, string locale ]
                $dateFormatted =
                    IntlDateFormatter::formatObject(
                        $dateTimeObj,
                        'eee d MMMM y à HH:mm',
                        'fr'
                    );

                // test :
                return ucwords($dateFormatted);
            }
            ?>