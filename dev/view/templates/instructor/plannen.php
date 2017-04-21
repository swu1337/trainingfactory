<?php include VIEW_PATH . 'includes/header.php'; ?>
<?php include VIEW_PATH . 'includes/intro-image.php'; ?>
<?php include VIEW_PATH . 'includes/message.php'; ?>
<div class="plannen-holder">
    <h2>Plannen van lessen</h2>
    <p>De les die je wilt verzorgen moet je met onderstaand formulier zelf plannen.Lokaal wordt alleen getoond als er ruimte is.</p>
    <form method="post" class="form-horizontal">
        <div class="form-group">
            <label for="datum" class="col-sm-3 control-label">Datum:</label>
            <div class="col-sm-9">
                <input type="text" required name="datum" class="form-control" id="datum" placeholder="DD-MM-YYY" value="<?= isset($f_data['datum']) ? $f_data['datum'] : ''; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="tijd" class="col-sm-3 control-label">Tijd:</label>
            <div class="col-sm-9">
                <input type="text" required name="tijd" class="form-control" id="tijd" placeholder="HH:MM:SS" value="<?= isset($f_data['tijd']) ? $f_data['tijd'] : ''; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="sport" class="col-sm-3 control-label">Sport:</label>
            <div class="col-sm-9">
                <select class="form-control" required name="sport">
                <?php foreach ($trainingen as $training): ?>
                    <option value="<?= $training->getId(); ?>" <?= isset($f_data['sport']) ? $f_data['sport'] == $training->getId() ? 'selected' : '' : ''; ?>><?= $training->getDescription() ; ?></option>
                <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="lokaal" class="col-sm-3 control-label">Lokaal:</label>
            <div class="col-sm-9">
                <input type="text" required name="lokaal" class="form-control" id="lokaal" placeholder="Lokaal" value="<?= isset($f_data['lokaal']) ? $f_data['lokaal'] : ''; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="aantal" class="col-sm-3 control-label">Maximaal aantal deelnemers:</label>
            <div class="col-sm-9">
                <input type="number" required min="1" name="aantal" class="form-control" id="aantal" placeholder="Aantal" value="<?= isset($f_data['aantal']) ? $f_data['aantal'] : ''; ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-default">Les Maken</button>
            </div>
        </div>
    </form>
</div>
<?php include VIEW_PATH . 'includes/footer.php'; ?>
