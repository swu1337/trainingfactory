<?php include VIEW_PATH . 'includes/header.php';?>
    <img src="img/boxing.jpg" class="content-img" />
    <img src="img/boxing.jpg" class="content-img" />
    <img src="img/boxing.jpg" class="content-img" />
    <img src="img/boxing.jpg" class="content-img" />
    <img src="img/boxing.jpg" class="content-img" />
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