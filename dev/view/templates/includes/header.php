<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Training Factory</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css" type="text/css">
    </head>
    <body>
        <nav class="navbar navbar-default no-border-radius">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header navbar-padding">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-wrapper" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"><img alt="Brand" src="https://placeholdit.imgix.net/~text?txtsize=13&txt=75%C3%9775&w=100&h=100"></a>
                </div>

                <!-- Navigation for a member -->
                <?php if(isset($gebruiker) && $gebruiker->getRole() === 'member'):?>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-collapse-wrapper">
                    <h2 class="navbar-text">Training Centrum Den Haag</h2>
                    <ul class="nav navbar-nav">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Inschrijven op les</a></li>
                        <li><a href="#">Overzicht inschrijvingen</a></li>
                        <li><a href="#">Gegevens lid wijzigen</a></li>
                    </ul>
                    <div class="navbar-right">
                        <p class="nav-text lead text-right"><?= $gebruiker->getName(); ?></p>
                        <p class="nav-text text-right">- <?= $gebruiker->getRole(); ?> -</p>
                        <a class="btn btn-danger pull-right" href=<?= "?control=" . $gebruiker->getRole() . "&action=uitloggen"?>>Logout</a>
                    </div>
                </div>
                <?php endif;?>

                <!-- Navigation for a instructor -->
                <?php if(isset($gebruiker) && $gebruiker->getRole() === 'instructor'):?>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-collapse-wrapper">
                    <h2 class="navbar-text">Training Centrum Den Haag</h2>
                    <ul class="nav navbar-nav">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Plannen Lessen</a></li>
                        <li><a href="#">Lessen Beheer</a></li>
                    </ul>
                    <div class="navbar-right">
                        <p class="nav-text lead text-right"><?= $gebruiker->getName(); ?></p>
                        <p class="nav-text text-right">- <?= $gebruiker->getRole(); ?> -</p>
                        <a class="btn btn-danger pull-right" href=<?= "?control=" . $gebruiker->getRole() . "&action=uitloggen"?>>Logout</a>
                    </div>
                </div>
                <?php endif;?>

                <!-- Navigation for a instructor -->
                <?php if(isset($gebruiker) && $gebruiker->getRole() === 'admin'):?>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="navbar-collapse-wrapper">
                        <h2 class="navbar-text">Training Centrum Den Haag</h2>
                        <ul class="nav navbar-nav">
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Instructeurs</a></li>
                            <li><a href="#">Leden</a></li>
                            <li><a href="#">Trainingen</a></li>
                        </ul>
                        <div class="navbar-right">
                            <p class="nav-text lead text-right"><?= $gebruiker->getName(); ?></p>
                            <p class="nav-text text-right">- <?= $gebruiker->getRole(); ?> -</p>
                            <a class="btn btn-danger pull-right" href=<?= "?control=" . $gebruiker->getRole() . "&action=uitloggen"?>>Logout</a>
                        </div>
                    </div>
                <?php endif;?>

                <!-- Default Navigation -->
                <?php if(!isset($gebruiker)):?>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-collapse-wrapper">
                    <h2 class="navbar-text">Training Centrum Den Haag</h2>
                    <ul class="nav navbar-nav">
                        <li><a href="?control=bezoeker&action=default">Home</a></li>
                        <li><a href="?control=bezoeker&action=aanbod">Trainings Aanbod</a></li>
                        <li><a href="?control=bezoeker&action=registreren">Lid worden</a></li>
                        <li><a href="?control=bezoeker&action=gedragsregels">Gedragsregels</a></li>
                        <li><a href="?control=bezoeker&action=contact">Locatie & Contact</a></li>
                    </ul>
                    <form class="navbar-form navbar-right" method="post" autocomplete="off">
                        <div class="form-group">
                            <input type="text" name="ln" class="form-control" placeholder="Loginname" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="pw" class="form-control" placeholder="Password" required>
                        </div>
                        <button type="submit" class="btn btn-default">Login</button>
                    </form>
                </div>
                <?php endif;?>
            </div>
        </nav>
        <section>