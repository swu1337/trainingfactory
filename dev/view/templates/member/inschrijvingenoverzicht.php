<?php include VIEW_PATH . 'includes/header.php';?>
<div class="content-holder">
    <?php include VIEW_PATH . 'includes/intro-image.php'; ?>
    <?= isset($msg) ? $msg : ''; ?> 
    <div class="text-holder">
        <h2>Overzicht inschrijvingen</h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Datum</th>
                <th>Tijd</th>
                <th>Sport</th>
                <th>Aantal ingeschreven deelnemers</th>
                <th>extra kosten (EUR)</th>
                <th>Uitschrijven</th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($registrations)): ?>
            <?php $z = 1; foreach ($registrations as $r): ?>
                <tr>
                    <td><?= $r->getLesson_id(); ?></td>
                    <td><?= $r->getDate(); ?></td>
                    <td><?= $r->getDuration(); ?></td>
                    <td><?= $r->getDescription(); ?></td>
                    <td><?= $r->getCurrent_amount(); ?></td>
                    <td><?= !empty($r->getExtra_costs())? '&euro; ' . $r->getExtra_costs() : '-'; ?></td>
                    <td><a href="#"></a></span></td>
                </tr>
            <?php $z++; endforeach; ?>
            <?php else: ?>
                <p class="lead text-center">Data No Found</p>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php include VIEW_PATH . 'includes/footer.php';?>