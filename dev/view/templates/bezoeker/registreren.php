<?php include VIEW_PATH . 'includes/header.php'; ?>
<div class="content-holder">
    <?php include VIEW_PATH . 'includes/intro-image.php'; ?>
    <?= $msg ;?>
    <div class="registration-holder">
        <h2>Lid Worden</h2>
        <p>Om gebruik te maken van de lessen moet je bij ons bekend zijn.
            <br>Vul hieronder alle gegevens in en registreer jezelf.</p>
        <form method="POST">
            <div class="left-registration-holder">
            <label>Voornaam *</label><br>
            <input class="registration-input" name="voornaam"/><br>

            <label>Tussenvoegsel</label><br>
            <input class="registration-input" name="tussenvoegsel"/><br>

            <label>Achternaam *</label><br>
            <input class="registration-input" name="achternaam"/><br>

            <label>Geboortedatum * YYYY/MM/DD</label><br>
            <input class="registration-input" name="geboortedatum"/><br>

            <label>Gebruikersnaam *</label><br>
            <input class="registration-input" name="gebruikersnaam"/><br>

            <label>Wachtwoord</label><br>
            <input class="registration-input" name="wachtwoord" type="password"/><br>

            <p>Het wachtwoord is nodig om in te loggen, moet minstens 6 tekens bevatten.</p>
        </div>
        
        <div class="right-registration-holder">
            <label>Man/Vrouw/Anders *</label><br>
            <input type="radio" name="geslacht" value="male"> Man
            <input type="radio" name="geslacht" value="female"> Vrouw
            <input type="radio" name="geslacht" value="other"> Anders<br>

            <label>Straat *</label><br>
            <input class="registration-input" name="straat"/><br>

            <label>Postcode *</label><br>
            <input class="registration-input" name="postcode"/><br>

            <label>Stad</label><br>
            <input class="registration-input" name="stad"/><br>

            <label>Email</label><br>
            <input class="registration-input" name="email"/><br><br>
            <button>Registreer</button>
        </div>
        <div class="clearfix"></div>
        </form>
    </div>
</div>
<?php include VIEW_PATH . 'includes/footer.php'; ?>