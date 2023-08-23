<?php $__env->startSection('title', __('report.expense_report')); ?>

<?php $__env->startSection('content'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo e(__('report.expense_report'), false); ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row no-print">
        <div class="col-md-12">
            <?php $__env->startComponent('components.filters', ['title' => __('report.filters')]); ?>
              <?php echo Form::open(['url' => action([\App\Http\Controllers\ReportController::class, 'getExpenseReport']), 'method' => 'get' ]); ?>

                <div class="col-md-4">
                    <div class="form-group">
                        <?php echo Form::label('location_id',  __('purchase.business_location') . ':'); ?>

                        <?php echo Form::select('location_id', $business_locations, null, ['class' => 'form-control select2', 'style' => 'width:100%']); ?>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <?php echo Form::label('category_id', __('category.category').':'); ?>

                        <?php echo Form::select('category', $categories, null, ['placeholder' =>
                        __('report.all'), 'class' => 'form-control select2', 'style' => 'width:100%', 'id' => 'category_id']); ?>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <?php echo Form::label('trending_product_date_range', __('report.date_range') . ':'); ?>

                        <?php echo Form::text('date_range', null , ['placeholder' => __('lang_v1.select_a_date_range'), 'class' => 'form-control', 'id' => 'trending_product_date_range', 'readonly']); ?>

                    </div>
                </div>
                <div class="col-sm-12">
                  <button type="submit" class="btn btn-primary pull-right"><?php echo app('translator')->get('report.apply_filters'); ?></button>
                </div> 
                <?php echo Form::close(); ?>

            <?php echo $__env->renderComponent(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?php $__env->startComponent('components.widget', ['class' => 'box-primary']); ?>
                <?php echo $chart->container(); ?>

            <?php echo $__env->renderComponent(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
        <?php $__env->startComponent('components.widget', ['class' => 'box-primary']); ?>
            <table class="table" id="expense_report_table">
                <thead>
                    <tr>
                        <th><?php echo app('translator')->get( 'expense.expense_categories' ); ?></th>
                        <th><?php echo app('translator')->get( 'report.total_expense' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $total_expense = 0;
                    ?>
                    <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($expense['category'] ?? __('report.others'), false); ?></td>
                            <td><span class="display_currency" data-currency_symbol="true"><?php echo e($expense['total_expense'], false); ?></span></td>
                        </tr>
                        <?php
                            $total_expense += $expense['total_expense'];
                        ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td><?php echo app('translator')->get('sale.total'); ?></td>
                        <td><span class="display_currency" data-currency_symbol="true"><?php echo e($total_expense, false); ?></span></td>
                    </tr>
                </tfoot>
            </table>
        <?php echo $__env->renderComponent(); ?>
        </div>
    </div>

</section>
<!-- /.content -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script src="<?php echo e(asset('js/report.js?v=' . $asset_v), false); ?>"></script>
    <?php echo $chart->script(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/report/expense_report.blade.php ENDPATH**/ ?>