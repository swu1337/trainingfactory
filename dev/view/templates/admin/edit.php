<?php include VIEW_PATH . 'includes/header.php';?>
<?php include VIEW_PATH . 'includes/intro-image.php';?>
<div class="container-fluid">
    <h2>Details van Training <?= $training->getDescription(); ?></h2>
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
<?php include VIEW_PATH . 'includes/footer.php';?>