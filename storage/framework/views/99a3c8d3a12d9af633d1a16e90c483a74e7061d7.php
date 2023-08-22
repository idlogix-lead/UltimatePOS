<div class="box <?php echo e($class ?? 'box-solid', false); ?>" <?php if(!empty($id)): ?> id="<?php echo e($id, false); ?>" <?php endif; ?>>
    <?php if(empty($header)): ?>
        <?php if(!empty($title) || !empty($tool)): ?>
        <div class="box-header">
            <?php echo $icon ?? ''; ?>

            <h3 class="box-title"><?php echo e($title ?? '', false); ?></h3>
            <?php echo $tool ?? ''; ?>


            <?php if(isset($help_text)): ?>
                <br/>
                <small><?php echo $help_text; ?></small>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="box-header">
            <?php echo $header; ?>

        </div>
    <?php endif; ?>

    <div class="box-body">
        <?php echo e($slot, false); ?>

    </div>
    <!-- /.box-body -->
</div><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/components/widget.blade.php ENDPATH**/ ?>