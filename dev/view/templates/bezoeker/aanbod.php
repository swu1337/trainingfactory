<?php include VIEW_PATH . 'includes/header.php'; ?>
    <div class="content-holder">
        <?php include VIEW_PATH . 'includes/intro-image.php'; ?>
    </div>
    <div class="registration-holder">
        <h2>Hier zijn alle cursussen die wij aanbieden</h2>
        <article>
            <ul class="training-holder">
                <?php foreach($soortTrainingen as $soortTraining):?>
                    <li>
                        Soort training: <?= $soortTraining->getDescription();?><br>
                        Tijdsduur: <?= $soortTraining->getDuration();?><br>
                        Extra kosten: <?= $soortTraining->getExtra_costs();?>
                    </li>
               <?php  endforeach;?>
            </ul>
        </article>
    </div>
<?php include VIEW_PATH . 'includes/footer.php';?>