<?php include VIEW_PATH . 'includes/header.php'; ?>
<?php include VIEW_PATH . 'includes/intro-image.php'; ?>
<?php include VIEW_PATH . 'includes/message.php'; ?>

<?php if(isset($prop)) :?>
    <!-- Create field for Instructor and Member -->
    <?php if($prop === 'instructor' || $prop === 'member') : ?>
    <div class="container-fluid">
        <?php if($prop === 'instructor') : ?>
            <h2>Details van Nieuwe Instructeur</h2>
        <?php endif; ?>
            
        <?php if($prop === 'member') : ?>
            <h2>Details van Nieuwe Lid</h2>
        <?php endif; ?>
        <form method="post" autocomplete="off" class="form-horizontal">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="firstname" class="col-md-3 control-label">Voornaam:</label>
                        <div class="col-md-9">
                            <input type="text" required class="form-control" name="firstname" id="firstname" placeholder="Voornaam" value="<?= isset($form_data['firstname']) ? $form_data['firstname'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="preprovision" class="col-md-3 control-label">Tussenvoegsel: (Optioneel)</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="preprovision" id="preprovision" placeholder="Tussenvoegsel" value="<?= isset($form_data['prepovision']) ? $form_data['prepovision'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="col-md-3 control-label">Achernaam: </label>
                        <div class="col-md-9">
                            <input type="text" required class="form-control" name="lastname" id="lastname" placeholder="Achternaam" value="<?= isset($form_data['lastname']) ? $form_data['lastname'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dateofbirth" class="col-md-3 control-label">Geboortedatum:</label>
                        <div class="col-md-9">
                            <input type="date" required class="form-control" name="dateofbirth" id="dateofbirth" placeholder="DD-MM-YYYY" value="<?= isset($form_data['dateofbirth']) ? $form_data['dateofbirth'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="loginname" class="col-md-3 control-label">Gebruikersnaam:</label>
                        <div class="col-md-9">
                            <input type="text" required class="form-control" name="loginname" id="loginname" placeholder="Gebruikersnaam" value="<?= isset($form_data['loginname']) ? $form_data['loginname'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-md-3 control-label">Wachtwoord:</label>
                        <div class="col-md-9">
                            <input type="password" class="form-control" name="password" id="loginname" placeholder="Wachtwoord" value="<?= isset($form_data['password']) ? $form_data['password'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gender" class="col-md-3 control-label">Geslacht:</label>
                        <div class="col-md-9">
                            <select class="form-control" required name="gender" id="gender">
                                <option <?= isset($form_data['gender']) ? $form_data['gender']  === 'male' ? 'selected' : '' : ''; ?> value="male">Male</option>
                                <option <?= isset($form_data['gender']) ? $form_data['gender']  === 'female' ? 'selected' : '' : ''; ?>  value="female">Female</option>
                                <option <?= isset($form_data['gender']) ? $form_data['gender']  === 'other ' ? 'selected' : '' : ''; ?> value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="street" class="col-md-3 control-label">Adres:</label>
                        <div class="col-md-9">
                            <input type="text" required class="form-control" name="street" id="street" placeholder="Adres" value="<?= isset($form_data['street']) ? $form_data['street'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="postal_code" class="col-md-3 control-label">Postcode:</label>
                        <div class="col-md-9">
                            <input type="text" required class="form-control" name="postal_code" id="postal_code" placeholder="Postcode" value="<?= isset($form_data['postal_code']) ? $form_data['postal_code'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="place" class="col-md-3 control-label">Woonplaats:</label>
                        <div class="col-md-9">
                            <input type="text" required class="form-control" name="place" id="place" placeholder="Woonplaats" value="<?= isset($form_data['place']) ? $form_data['place'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email_address" class="col-md-3 control-label">Email:</label>
                        <div class="col-md-9">
                            <input type="email" required class="form-control" name="email_address" id="email_address" placeholder="Email" value="<?= isset($form_data['email_address']) ? $form_data['email_address'] : ''; ?>">
                        </div>
                    </div>
                    <?php if($prop === 'instructor') : ?>
                    <div class="form-group">
                        <label for="hiring_date" class="col-md-3 control-label">Hiring Date:</label>
                        <div class="col-md-9">
                            <input required type="date" required class="form-control" name="hiring_date" id="hiring_date" placeholder="DD-MM-YYYY" value="<?= isset($form_data['hiring_date']) ? $form_data['hiring_date'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="salary" class="col-md-3 control-label">Salary:</label>
                        <div class="col-md-9">
                            <input type="number" required step="0.01" min="0.01" required class="form-control" name="salary" id="salary" placeholder="Salary" value="<?= isset($form_data['salary']) ? $form_data['salary'] : ''; ?>">
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn btn-primary">Toevoegen</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <!-- Create field for Training -->
    <?php if($prop === 'training') : ?>
    <div class="container-fluid">
        <h2>Details van nieuwe training</h2>
        <div class="row">
            <div class="col-md-4">
                <form method="post" autocomplete="off" class="form-horizontal">
                    <div class="form-group">
                        <label for="description" class="col-md-3 control-label">Description:</label>
                        <div class="col-md-9">
                            <input type="text" required class="form-control" name="description" id="description" placeholder="Description" value=<?= isset($form_data['description']) ? $form_data['description'] : ''; ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="duration" class="col-md-3 control-label">Duration:</label>
                        <div class="col-md-9">
                            <input type="text" required class="form-control" name="duration" id="duration" placeholder="HH:MM:SS" value=<?= isset($form_data['duration']) ? $form_data['duration'] : ''; ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="extra-costs" class="col-md-3 control-label">Extra Costs:</label>
                        <div class="col-md-9">
                            <input type="number" required step="0.01" min="0.01" class="form-control" name="extra_costs" id="extra-costs" placeholder="Extra Costs" value=<?= isset($form_data['extra_costs']) ? $form_data['extra_costs'] : ''; ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn btn-primary btn-lg">Toevoegen</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php endif;?>
<?php include VIEW_PATH . 'includes/footer.php'; ?>