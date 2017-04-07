<?php include VIEW_PATH . 'includes/header.php';?>
<?php include VIEW_PATH . 'includes/intro-image.php';?>
    <div class="container-fluid">
        <h2>Overzicht Leden</h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Naam</th>
                <th>Email</th>
                <th>Adres</th>
                <th>Woonplaats</th>
                <th>Gebruikersnaam</th>
                <th>Details</th>
                <th>Verwijderen</th>
            </tr>
            </thead>
            <tbody>
            <?php $z = 1; foreach ($members as $m): ?>
                <tr>
                    <td><?= $z; ?></td>
                    <td><?= $m->getName(); ?></td>
                    <td><?= $m->getEmail_address(); ?></td>
                    <td><?= $m->getStreet(); ?></td>
                    <td><?= $m->getPlace(); ?></td>
                    <td><?= $m->getLoginname(); ?></td>
                    <td><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></td>
                    <td><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></td>
                </tr>
            <?php $z++; endforeach; ?>
            </tbody>
        </table>
    </div>
<?php include VIEW_PATH . 'includes/footer.php';?>