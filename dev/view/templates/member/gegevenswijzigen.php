<?php include VIEW_PATH . 'includes/header.php';?>
<div class="content-holder">
    <?php include VIEW_PATH . 'includes/intro-image.php'; ?>;
    <?= isset($msg) ? $msg : ''; ?> 
    <div class="registration-holder">
        <h2>Gegevens wijzigen</h2>
        <p>Wijzig hieronder uw gegevens.</p>
        <form method="POST">
            <div class="left-registration-holder">
            <label>Voornaam *</label><br>
            <input class="registration-input" value="<?= $gebruiker->getFirstname() ?>" name="voornaam"/><br>

            <label>Tussenvoegsel</label><br>
            <input class="registration-input" value="<?= $gebruiker->getPreprovision()?>" name="tussenvoegsel"/><br>

            <label>Achternaam *</label><br>
            <input class="registration-input" value="<?= $gebruiker->getLastname()?>" name="achternaam"/><br>

            <label>Geboortedatum * YYYY/MM/DD</label><br>
            <input class="registration-input" value="<?= $gebruiker->getDateofbirth()?>" name="geboortedatum"/><br>

            <label>Wachtwoord</label><br>
            <input class="registration-input" value="<?= $gebruiker->getPassword()?>" name="wachtwoord" type="password"/><br>

            <p>Het wachtwoord is nodig om in te loggen, moet minstens 6 tekens bevatten.</p>
        </div>
        
        <div class="right-registration-holder">
            <label>Man/Vrouw/Anders *</label><br>
            <input type="radio" name="geslacht" value="male" <?= $gebruiker->getGender() === "male" ? "checked" : "";?>> Man
            <input type="radio" name="geslacht" value="female" <?= $gebruiker->getGender() === "female" ? "checked" : "";?>> Vrouw
            <input type="radio" name="geslacht" value="other" <?= $gebruiker->getGender() === "other" ? "checked" : "";?>> Anders<br>

            <label>Straat *</label><br>
            <input class="registration-input" value="<?= $gebruiker->getStreet()?>" name="straat"/><br>

            <label>Postcode *</label><br>
            <input class="registration-input" value="<?= $gebruiker->getPostal_code()?>" name="postcode"/><br>

            <label>Stad</label><br>
            <input class="registration-input" value="<?= $gebruiker->getPlace()?>" name="stad"/><br>

            <label>Email</label><br>
            <input class="registration-input" value="<?= $gebruiker->getEmail_address()?>" name="email"/><br><br>
            <button>Wijzig</button>
        </div>
        <div class="clearfix"></div>
        </form>
    </div>
</div>
<?php include VIEW_PATH . 'includes/footer.php';?>
