<?php $__env->startSection('title', __('lang_v1.backup')); ?>

<?php $__env->startSection('content'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo app('translator')->get('lang_v1.backup'); ?>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    
  <?php if(session('notification') || !empty($notification)): ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php if(!empty($notification['msg'])): ?>
                    <?php echo e($notification['msg'], false); ?>

                <?php elseif(session('notification.msg')): ?>
                    <?php echo e(session('notification.msg'), false); ?>

                <?php endif; ?>
              </div>
          </div>  
      </div>     
  <?php endif; ?>

  <div class="row">
    <div class="col-sm-12">
      <?php $__env->startComponent('components.widget', ['class' => 'box-primary']); ?>
        <?php $__env->slot('tool'); ?>
          <div class="box-tools">
            <a id="create-new-backup-button" href="<?php echo e(url('backup/create'), false); ?>" class="btn btn-primary pull-right"
                     style="margin-bottom:2em;"><i
                          class="fa fa-plus"></i> <?php echo app('translator')->get('lang_v1.create_new_backup'); ?>
            </a>
          </div>
        <?php $__env->endSlot(); ?>
        <?php if(count($backups)): ?>
                <table class="table table-striped table-bordered">
                  <thead>
                  <tr>
                      <th><?php echo app('translator')->get('lang_v1.file'); ?></th>
                      <th><?php echo app('translator')->get('lang_v1.size'); ?></th>
                      <th><?php echo app('translator')->get('lang_v1.date'); ?></th>
                      <th><?php echo app('translator')->get('lang_v1.age'); ?></th>
                      <th><?php echo app('translator')->get('messages.actions'); ?></th>
                  </tr>
                  </thead>
                    <tbody>
                    <?php $__currentLoopData = $backups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $backup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($backup['file_name'], false); ?></td>
                            <td><?php echo e(humanFilesize($backup['file_size']), false); ?></td>
                            <td>
                                <?php echo e(Carbon::createFromTimestamp($backup['last_modified'])->toDateTimeString(), false); ?>

                            </td>
                            <td>
                                <?php echo e(Carbon::createFromTimestamp($backup['last_modified'])->diffForHumans(Carbon::now()), false); ?>

                            </td>
                            <td>
                              <a class="btn btn-xs btn-success"
                                   href="<?php echo e(action([\App\Http\Controllers\BackUpController::class, 'download'], [$backup['file_name']]), false); ?>"><i
                                        class="fa fa-cloud-download"></i> <?php echo app('translator')->get('lang_v1.download'); ?></a>
                                <a class="btn btn-xs btn-danger link_confirmation" data-button-type="delete"
                                   href="<?php echo e(action([\App\Http\Controllers\BackUpController::class, 'delete'], [$backup['file_name']]), false); ?>"><i class="fa fa-trash-o"></i>
                                    <?php echo app('translator')->get('messages.delete'); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
              </table>
            <?php else: ?>
                <div class="well">
                    <h4>There are no backups</h4>
                </div>
            <?php endif; ?>
            <br>
            <strong><?php echo app('translator')->get('lang_v1.auto_backup_instruction'); ?>:</strong><br>
            <code><?php echo e($cron_job_command, false); ?></code> <br>
            <strong><?php echo app('translator')->get('lang_v1.backup_clean_command_instruction'); ?>:</strong><br>
            <code><?php echo e($backup_clean_cron_job_command, false); ?></code>
      <?php echo $__env->renderComponent(); ?>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/backup/index.blade.php ENDPATH**/ ?>