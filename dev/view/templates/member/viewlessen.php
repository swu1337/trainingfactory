<?php include VIEW_PATH . 'includes/header.php'; ?>
<?php include VIEW_PATH . 'includes/intro-image.php'; ?>
<?php include VIEW_PATH . 'includes/message.php'; ?>
    <div class="container-fluid">
        <h2>Inschrijven op les</h2>
        <div class="row">
            <div class="col-md-12">
                <ul class="list-inline">
                    <?php if($schedule): foreach($schedule as $s): ?>
                        <li>
                            <a href=<?= "?control=" . $gebruiker->getRole() . "&action=viewles&date=$s"; ?>>
                                <p class="lead"><?= strtotime($s) ? date('D d M', strtotime($s)) : $s; ?></p>
                            </a>
                        </li>
                    <?php endforeach; endif; ?>
                </ul>
            </div>
        </div>
        <div class="row">
            <?php if(!empty($lessonsbyday)): ?>
                <?php foreach($lessonsbyday as $lbd): ?>
                <div class="col-md-12">
                    <a href=<?= "?control=" . $gebruiker->getRole() . "&action=inschrijven&id=" . $lbd->getLesson_id(); ?>><h3><?= $lbd->description; ?></h3></a>
                    <h4><?= $lbd->getTime(); ?></h4>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-md-12">
                    <h2 class="lead">No Lesson For You</h2>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php include VIEW_PATH . 'includes/footer.php'; ?>