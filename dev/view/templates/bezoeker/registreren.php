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
            <input type="text" required class="registration-input" name="voornaam" value="<?= isset($formdata['voornaam']) ? $formdata['voornaam'] : ''; ?>" /><br>

            <label>Tussenvoegsel</label><br>
            <input type="text" class="registration-input" name="tussenvoegsel" value="<?= isset($formdata['tussenvoegsel']) ? $formdata['tussenvoegsel'] : ''; ?>" /><br>

            <label>Achternaam *</label><br>
            <input type="text" required class="registration-input" name="achternaam" value="<?= isset($formdata['achternaam']) ? $formdata['achternaam'] : ''; ?>" /><br>

            <label>Geboortedatum * DD-MM-YYYY</label><br>
            <input type="text" required class="registration-input" name="geboortedatum" value="<?= isset($formdata['geboortedatum']) ? $formdata['geboortedatum'] : ''; ?>" /><br>

            <label>Gebruikersnaam *</label><br>
            <input type="text" required class="registration-input" name="gebruikersnaam" value="<?= isset($formdata['gebruikersnaam']) ? $formdata['gebruikersnaam'] : ''; ?>" /><br>

            <label>Wachtwoord</label><br>
            <input type="password" class="registration-input" name="wachtwoord" type="password" /><br>

            <p>Het wachtwoord is nodig om in te loggen, moet minstens 6 tekens bevatten.</p>
        </div>
        
        <div class="right-registration-holder">
            <label>Man/Vrouw/Anders *</label><br>
            <input type="radio" name="geslacht" value="male" <?= isset($formdata['geslacht']) ? $formdata['geslacht'] === "male" ? 'checked' : '' : ''; ?>> Man
            <input type="radio" name="geslacht" value="female" <?= isset($formdata['geslacht']) ? $formdata['geslacht'] === "female" ? 'checked' : '' : ''; ?>> Vrouw
            <input type="radio" name="geslacht" value="other" <?= isset($formdata['geslacht']) ? $formdata['geslacht'] === "other" ? 'checked' : '' : ''; ?>> Anders<br>

            <label>Straat *</label><br>
            <input type="text" required class="registration-input" name="straat" value="<?= isset($formdata['straat']) ? $formdata['straat'] : ''; ?>" /><br>

            <label>Postcode *</label><br>
            <input type="text" required class="registration-input" name="postcode" value="<?= isset($formdata['postcode']) ? $formdata['postcode'] : ''; ?>" /><br>

            <label>Stad *</label><br>
            <input type="text" required class="registration-input" name="stad" value="<?= isset($formdata['stad']) ? $formdata['stad'] : ''; ?>" /><br>

            <label>Email *</label><br>
            <input type="email" required class="registration-input" name="email" value="<?= isset($formdata['email']) ? $formdata['email'] : ''; ?>"/><br><br>
            <button type="submit">Registreer</button>
        </div>
        <div class="clearfix"></div>
        </form>
    </div>
</div>
<?php include VIEW_PATH . 'includes/footer.php'; ?>