<?php include VIEW_PATH . 'includes/header.php';?>
<div class="content-holder">
    <?php include VIEW_PATH . 'includes/intro-image.php'; ?>
    <?= isset($msg) ? $msg : ''; ?>
    <div class="text-holder">
        <h2>Overzicht inschrijvingen</h2>
        <div class="table-responsive">
            <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Datum</th>
                <th>Duratie</th>
                <th>Sport</th>
                <th>Aantal ingeschreven deelnemers</th>
                <th>Extra kosten</th>
                <th>Uitschrijven</th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($registrations)): ?>
            <?php $z = 1; foreach ($registrations as $r): ?>
                <tr>
                    <th><?= $z; ?></th>
                    <td><?= $r->getDate(); ?></td>
                    <td><?= $r->getDuration(); ?></td>
                    <td><?= $r->getDescription(); ?></td>
                    <td><?= $r->getRegistered(); ?></td>
                    <td><?= !empty($r->getExtra_costs())? '&euro; ' . $r->getExtra_costs() : '-'; ?></td>
                    <td><a href=<?= "?control=" . $gebruiker->getRole() . "&action=uitschrijven&id=" . $r->getId(); ?>><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></a></td>
                </tr>
            <?php $z++; endforeach; ?>
            <?php else: ?>
                <p class="lead text-center">Geen Data Gevonden</p>
            <?php endif; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
<?php include VIEW_PATH . 'includes/footer.php';?>