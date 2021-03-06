<?php include VIEW_PATH . 'includes/header.php'; ?>
<?php include VIEW_PATH . 'includes/intro-image.php'; ?>
<?php include VIEW_PATH . 'includes/message.php'; ?>
    <div class="container-fluid">
        <h2>Overzicht Leden</h2>
        <div class="row row-gutter">
             <a class="btn btn-success" href=<?= "?control=" . $gebruiker->getRole() . "&action=create&prop=member"; ?>>Nieuw <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
        </div>
        <div class="row row-gutter">
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
                <?php if(isset($members)): ?>
                <?php $z = 1; foreach ($members as $m): ?>
                    <tr>
                        <td><?= $z; ?></td>
                        <td><?= $m->getName(); ?></td>
                        <td><?= $m->getEmail_address(); ?></td>
                        <td><?= $m->getStreet(); ?></td>
                        <td><?= $m->getPlace(); ?></td>
                        <td><?= $m->getLoginname(); ?></td>
                        <td><a href=<?= "?control=" . $gebruiker->getRole() . "&action=edit&id=" . $m->getId() . "&prop=member"; ?>><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
                        <td><a href=<?= "?control=" . $gebruiker->getRole() . "&action=delete&id=" . $m->getId() . "&prop=member"; ?>><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
                    </tr>
                <?php $z++; endforeach; ?>
                <?php else: ?>
                    <p class="lead text-center">Geen Data Gevonden</p>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php include VIEW_PATH . 'includes/footer.php'; ?>