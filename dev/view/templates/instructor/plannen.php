<?php include VIEW_PATH . 'includes/header.php';?>
<?php include VIEW_PATH . 'includes/intro-image.php'; ?>
<div class="plannen-holder">
    <h2>Plannen van lessen</h2>
    <p>De les die je wilt verzorgen moet je met onderstaand formulier zelf plannen.Lokaal wordt alleen getoond als er ruimte is.</p>
    <form method="POST">
        <label>Datum:</label><br>
        <input class="registration-input" name="datum" placeholder="YYYY-MM-DD"/><br>
        
        <label>Tijd:</label><br>
        <input class="registration-input" name="tijd" placeholder="HH:MM"/><br>
        
        <label>Sport:</label><br>
        <select class="registration-input" name="sport"/>
            <?php foreach ($trainingen as $training):?>
                <option><?= $training->getDescription();?> </option>
            <?php endforeach; ?>
        </select><br>
        
        <label>Lokaal:</label><br>
        <select class="registration-input" name="lokaal"/>
            <?php foreach ($lessen as $les):?>
                <option><?= $les->getLocation();?> </option>
            <?php endforeach; ?>
        </select><br>

        <label>Maximaal aantal deelnemers:</label><br>
        <select class="registration-input" name="aantal"/>
            <?php foreach ($lessen as $les):?>
                <option><?= $les->getMax_persons();?> </option>
            <?php endforeach; ?>
        </select><br><br>
            
            <button name="verzenden">Les maken</button>
    </form>
</div>
<?php include VIEW_PATH . 'includes/footer.php';?>
