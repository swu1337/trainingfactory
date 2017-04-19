<?php include VIEW_PATH . 'includes/header.php'; ?>
<?php include VIEW_PATH . 'includes/intro-image.php'; ?>
<?= isset($msg) ? $msg : ''; ?>
    <div class="plannen-holder">
        <h2>Wijzigen van lessen</h2>
        <form method="post" class="form-horizontal">
            <div class="form-group">
                <label for="datum" class="col-sm-3 control-label">Datum:</label>
                <div class="col-sm-9">
                    <input type="text" required name="datum" class="form-control" id="datum" placeholder="DD-MM-YYY" value="<?= $lesson->getDate(); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="tijd" class="col-sm-3 control-label">Tijd:</label>
                <div class="col-sm-9">
                    <input type="text" required name="tijd" class="form-control" id="tijd" placeholder="HH:MM:SS" value="<?= $lesson->getTime(); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="sport" class="col-sm-3 control-label">Sport:</label>
                <div class="col-sm-9">
                    <select class="form-control" required name="sport">
                        <?php foreach ($trainingen as $training): ?>
                            <option value="<?= $training->getId(); ?>" <?= $lesson->getTraining_id() == $training->getId() ? 'selected' : ''; ?>><?= $training->getDescription(); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="sport" class="col-sm-3 control-label">Instructeur:</label>
                <div class="col-sm-9">
                    <select class="form-control" required name="instructeur">
                        <?php foreach ($instructors as $instructor): ?>
                            <option value="<?= $instructor->getId(); ?>" <?= $lesson->getInstructor_id() == $instructor->getId() ? 'selected' : ''; ?>><?= $instructor->getName(); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="lokaal" class="col-sm-3 control-label">Lokaal:</label>
                <div class="col-sm-9">
                    <input type="text" required name="lokaal" class="form-control" id="lokaal" placeholder="Lokaal" value="<?= $lesson->getLocation(); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="aantal" class="col-sm-3 control-label">Maximaal aantal deelnemers:</label>
                <div class="col-sm-9">
                    <input type="number" required min="1" name="aantal" class="form-control" id="aantal" placeholder="Aantal" value="<?= $lesson->getMax_persons(); ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-default">Les Wijzigen</button>
                </div>
            </div>
        </form>
    </div>
<?php include VIEW_PATH . 'includes/footer.php'; ?>