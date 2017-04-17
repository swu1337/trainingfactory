<?php include VIEW_PATH . 'includes/header.php';?>
<?php include VIEW_PATH . 'includes/intro-image.php';?>
<?= isset($msg) ? $msg : ''; ?>
    <div class="container-fluid">
        <h2>Overzicht Instructeurs</h2>
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
            <?php if(isset($instructors)): ?>
            <?php $z = 1; foreach ($instructors as $i): ?>
                <tr>
                    <td><?= $z; ?></td>
                    <td><?= $i->getName(); ?></td>
                    <td><?= $i->getEmail_address(); ?></td>
                    <td><?= $i->getStreet(); ?></td>
                    <td><?= $i->getPlace(); ?></td>
                    <td><?= $i->getLoginname(); ?></td>
                    <td><a href=<?= "?control=" . $gebruiker->getRole() . "&action=edit&id=" . $i->getId() . "&prop=instructor"; ?>><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
                    <td><a href=<?= "?control=" . $gebruiker->getRole() . "&action=delete&id=" . $i->getId() . "&prop=instructor"; ?>><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
                </tr>
            <?php $z++; endforeach; ?>
            <?php else: ?>
                <p class="lead text-center">Geen Data Gevonden</p>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php include VIEW_PATH . 'includes/footer.php';?>