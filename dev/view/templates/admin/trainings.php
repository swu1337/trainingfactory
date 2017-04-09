<?php include VIEW_PATH . 'includes/header.php';?>
<?php include VIEW_PATH . 'includes/intro-image.php';?>
    <div class="container-fluid">
        <h2>Overzicht Trainingen</h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Description</th>
                <th>Duration</th>
                <th>Extra costs</th>
                <th>Details</th>
                <th>Verwijderen</th>
            </tr>
            </thead>
            <tbody>
            <?php $z = 1; foreach ($trainings as $t): ?>
                <tr>
                    <td><?= $z; ?></td>
                    <td><?= $t->getDescription(); ?></td>
                    <td><?= $t->getDuration(); ?></td>
                    <td><?= !empty($t->getExtra_costs())? '&euro; ' . $t->getExtra_costs() : '-'; ?></td>
                    <td><a href=<?= "?control=" . $gebruiker->getRole() . "&action=edit&id=" . $t->getId() . "&prop=training"; ?>><span class="glyphicon glyphicon-pencil" aria-hidden="true"></a></span></td>
                    <td><a href=<?= "?control=" . $gebruiker->getRole() . "&action=delete&id=" . $t->getId() ."&prop=training"; ?>><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
                </tr>
            <?php $z++; endforeach; ?>
            </tbody>
        </table>
    </div>
<?php include VIEW_PATH . 'includes/footer.php';?>