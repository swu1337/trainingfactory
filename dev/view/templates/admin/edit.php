<?php include VIEW_PATH . 'includes/header.php';?>
<?php include VIEW_PATH . 'includes/intro-image.php';?>
<?= isset($msg) ? $msg : ''; ?>
<!-- Edit field for Instructor -->
<?php if(isset($instructor)) : ?>
    <div class="container-fluid">
        <h2>Details van Training <?= $instructor->getName(); ?></h2>
        <div class="row">
            <div class="col-md-4">
                <form method="post" autocomplete="off" class="form-horizontal">
                    <div class="form-group">
                        <label for="description" class="col-md-2 control-label">Description:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="description" id="description" placeholder="Description" value=<?= $training->getDescription(); ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="duration" class="col-md-2 control-label">Duration:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="duration" id="duration" placeholder="Duration" value=<?= $training->getDuration(); ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="extra-costs" class="col-md-2 control-label">Duration:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="extra_cost" id="extra-costs" placeholder="Extra Costs" value=<?= $training->getExtra_costs(); ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <button type="submit" class="btn btn-primary">Wijzig</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Edit field for Member -->
<?php if(isset($member)) : ?>
    <div class="container-fluid">
        <h2>Details van <?= $member->getName(); ?></h2>
        <div class="row">
            <div class="col-md-4">
                <form method="post" autocomplete="off" class="form-horizontal">
                    <div class="form-group">
                        <label for="dateofbirth" class="col-md-3 control-label">Geboortedatum:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="dateofbirth" id="dateofbirth" placeholder="Geboortedatum" value="<?= $member->getDateofbirth(); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="loginname" class="col-md-3 control-label">Gebruikersnaam:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="loginname" id="loginname" placeholder="Gebruikersnaam" value="<?= $member->getLoginname(); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gender" class="col-md-3 control-label">Geslacht:</label>
                        <div class="col-md-9">
                            <select class="form-control" name="gender" id="gender">
                                <option <?= $member->getGender() === 'male' ? 'selected' : ''; ?> value="male">Male</option>
                                <option <?= $member->getGender() === 'female' ? 'selected' : ''; ?>  value="female">Female</option>
                                <option <?= $member->getGender() === 'other' ? 'selected' : ''; ?> value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="street" class="col-md-3 control-label">Adres:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="street" id="street" placeholder="Adres" value="<?= $member->getStreet(); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="postal_code" class="col-md-3 control-label">Postcode:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="postal_code" id="postal_code" placeholder="Postcode" value="<?= $member->getPostal_code(); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="place" class="col-md-3 control-label">Woonplaats:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="place" id="place" placeholder="Woonplaats" value="<?= $member->getPlace(); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email_address" class="col-md-3 control-label">Email:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="email_address" id="email_address" placeholder="Email" value="<?= $member->getEmail_address(); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn btn-primary">Wijzig</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2 class="lead">Geregistreerd lessen:</h2>
                <form method="post" autocomplete="off" class="form-horizontal" action="#">
                    <div class="form-group">
                        <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Datum</th>
                            <th>Tijd</th>
                            <th>Locatie</th>
                            <th>Sport</th>
                            <th>Kosten</th>
                            <th>Betaald</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($registrations)) :?>
                            <?php foreach($registrations as $registration) :?>
                            <tr>
                                <td><?= $registration->getDate();?></td>
                                <td><?= $registration->getTime();?></td>
                                <td><?= $registration->getLocation();?></td>
                                <td><?= $registration->getDescription();?></td>
                                <td><?= $registration->getExtra_costs();?></td>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"  <?= $registration->getPayment() === 'paid' ? 'checked' : ''; ?> value="paid">
                                        </label>
                                    </div>
                               </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                                <h3 class="lead">Het lid heeft geen registratie voor een les</h3>
                            <?php endif;?>
                        </tbody>
                    </table>
                    </div>
                    <?php if(isset($registrations)) :?>
                        <div class="form-group">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary btn-lg">Betaald wijzigen</button>
                            </div>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Edit field for Training -->
<?php if(isset($training)) : ?>
    <div class="container-fluid">
        <h2>Details van Training <?= $training->getDescription(); ?></h2>
        <div class="row">
            <div class="col-md-4">
                <form method="post" autocomplete="off" class="form-horizontal">
                    <div class="form-group">
                        <label for="description" class="col-md-3 control-label">Description:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="description" id="description" placeholder="Description" value=<?= $training->getDescription(); ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="duration" class="col-md-3 control-label">Duration:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="duration" id="duration" placeholder="Duration" value=<?= $training->getDuration(); ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="extra-costs" class="col-md-3 control-label">Extra Costs:</label>
                        <div class="col-md-9">
                            <input type="number"  step="0.01" min="0.01" class="form-control" name="extra_costs" id="extra-costs" placeholder="Extra Costs" value=<?= $training->getExtra_costs(); ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn btn-primary btn-lg">Wijzig</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include VIEW_PATH . 'includes/footer.php';?>