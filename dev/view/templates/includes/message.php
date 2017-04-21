<?php if(isset($msg)): ?>
    <?php if(key($msg) === 'warning'): ?>
        <div class="alert alert-warning alert-dismissible message" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Warning!</strong> <?= $msg['warning']; ?>
        </div>
    <?php endif; ?>

    <?php if(key($msg) === 'info'): ?>
        <div class="alert alert-info alert-dismissible message" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Heads up!</strong> <?= $msg['info']; ?>
        </div>
    <?php endif; ?>

    <?php if(key($msg) === 'success'): ?>
        <div class="alert alert-success  alert-dismissible message" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Well done!</strong> <?= $msg['success']; ?>
        </div>
    <?php endif; ?>

    <?php if(key($msg) === 'danger'): ?>
        <div class="alert alert-danger alert-dismissible message" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Oh snap!</strong> <?= $msg['danger']; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
