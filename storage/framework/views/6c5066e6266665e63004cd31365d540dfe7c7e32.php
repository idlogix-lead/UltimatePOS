<div class="box <?php if(!empty($class)): ?> <?php echo e($class, false); ?> <?php else: ?> box-solid <?php endif; ?>" id="accordion">
  <div class="box-header with-border" style="cursor: pointer;">
    <h3 class="box-title">
      <a data-toggle="collapse" data-parent="#accordion" href="#collapseFilter">
        <?php if(!empty($icon)): ?> <?php echo $icon; ?> <?php else: ?> <i class="fa fa-filter" aria-hidden="true"></i> <?php endif; ?> <?php echo e($title ?? '', false); ?>

      </a>
    </h3>
  </div>
  <?php
    if(isMobile()) {
      $closed = true;
    }
  ?>
  <div id="collapseFilter" class="panel-collapse active collapse <?php if(empty($closed)): ?> in <?php endif; ?>" aria-expanded="true">
    <div class="box-body">
      <?php echo e($slot, false); ?>

    </div>
  </div>
</div><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/components/filters.blade.php ENDPATH**/ ?>