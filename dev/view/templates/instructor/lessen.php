<?php include VIEW_PATH . 'includes/header.php'; ?>
<?php include VIEW_PATH . 'includes/intro-image.php'; ?>
<?= isset($msg) ? $msg : ''; ?>
<div class="container-fluid">
    <h2>Overzicht Lessen</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Datum</th>
            <th>Tijd</th>
            <th>Lokaal</th>
            <th>Sport</th>
            <th>Aantal ingeschreven deelnemers</th>
            <th>Deelnerslijst</th>
            <th>Aanpassen</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($lessen as $l): ?>
                <tr>
                    <td><?= $l->getDate(); ?></td>
                    <td><?= $l->getTime(); ?></td>
                    <td><?= $l->getLocation(); ?></td>
                    <td><?= "sport join";?></td>
                    <td><?= "count join";?></td>
                    <td><a href=<?= "?control=" . $gebruiker->getRole() . "&action=viewmembers&id=" . $l->getLesson_id(); ?>><span class="glyphicon glyphicon-list" aria-hidden="true"></a></span></td>
                    <td><a href=<?= "?control=" . $gebruiker->getRole() . "&action=edit&id=" . $l->getLesson_id(); ?>><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include VIEW_PATH . 'includes/footer.php'; ?>