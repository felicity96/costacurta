<?php require_once("../resources/config.php"); ?>
<?php $studi = get_studi(); ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Lo studio del dott. Andrea Costacurta, psichiatra e psicoterapeuta a Padova">
        <meta name="keywords" content="Andrea Costacurta, psichiatra, psicoterapeuta, Padova, PD">
        <meta name="author" content="Anna Cisotto Bertocco">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="Cache-control" content="no-cache" />
        <title>Andrea Costacurta</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <!-- Bootstrap stylesheet -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!-- Bootstrap Scripts -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <!-- Google fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
        <!-- Fontawesome icons -->
        <script src="https://kit.fontawesome.com/8284f330c3.js" crossorigin="anonymous"></script>
        <!-- Animation library Animate -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    </head>
    <body>

        <div id="main">

            <!-- NAVBAR -->
            <?php include(TEMPLATE_FRONT . DS . "navbar.php"); ?>

            <!-- MAIN CONTENT -->
            <?php show_main_content() ?>
        </div>

        <!-- FOOTER -->
        <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>
      
    </body>
</html>