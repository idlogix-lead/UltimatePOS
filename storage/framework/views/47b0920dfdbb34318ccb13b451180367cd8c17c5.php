<?php $__env->startSection('title', __('expense.expenses')); ?>

<?php $__env->startSection('content'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo app('translator')->get('expense.expenses'); ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php $__env->startComponent('components.filters', ['title' => __('report.filters')]); ?>
                <?php if(auth()->user()->can('all_expense.access')): ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <?php echo Form::label('location_id',  __('purchase.business_location') . ':'); ?>

                            <?php echo Form::select('location_id', $business_locations, null, ['class' => 'form-control select2', 'style' => 'width:100%']); ?>

                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <?php echo Form::label('expense_for', __('expense.expense_for').':'); ?>

                            <?php echo Form::select('expense_for', $users, null, ['class' => 'form-control select2', 'style' => 'width:100%']); ?>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <?php echo Form::label('expense_contact_filter',  __('contact.contact') . ':'); ?>

                            <?php echo Form::select('expense_contact_filter', $contacts, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')]); ?>

                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-md-3">
                    <div class="form-group">
                        <?php echo Form::label('expense_category_id',__('expense.expense_category').':'); ?>

                        <?php echo Form::select('expense_category_id', $categories, null, ['placeholder' =>
                        __('report.all'), 'class' => 'form-control select2', 'style' => 'width:100%', 'id' => 'expense_category_id']); ?>

                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <?php echo Form::label('expense_sub_category_id_filter',__('product.sub_category').':'); ?>

                        <?php echo Form::select('expense_sub_category_id_filter', $sub_categories, null, ['placeholder' =>
                        __('report.all'), 'class' => 'form-control select2', 'style' => 'width:100%', 'id' => 'expense_sub_category_id_filter']); ?>

                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <?php echo Form::label('expense_date_range', __('report.date_range') . ':'); ?>

                        <?php echo Form::text('date_range', null, ['placeholder' => __('lang_v1.select_a_date_range'), 'class' => 'form-control', 'id' => 'expense_date_range', 'readonly']); ?>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <?php echo Form::label('expense_payment_status',  __('purchase.payment_status') . ':'); ?>

                        <?php echo Form::select('expense_payment_status', ['paid' => __('lang_v1.paid'), 'due' => __('lang_v1.due'), 'partial' => __('lang_v1.partial')], null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')]); ?>

                    </div>
                </div>
            <?php echo $__env->renderComponent(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php $__env->startComponent('components.widget', ['class' => 'box-primary', 'title' => __('expense.all_expenses')]); ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('expense.add')): ?>
                    <?php $__env->slot('tool'); ?>
                        <div class="box-tools">
                            <a class="btn btn-block btn-primary" href="<?php echo e(action([\App\Http\Controllers\ExpenseController::class, 'create']), false); ?>">
                            <i class="fa fa-plus"></i> <?php echo app('translator')->get('messages.add'); ?></a>
                        </div>
                    <?php $__env->endSlot(); ?>
                <?php endif; ?>
                <div class="table-responsive">
                    <?php echo $__env->make("expense.partials.list", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            <?php echo $__env->renderComponent(); ?>
        </div>
    </div>

</section>
<!-- /.content -->
<!-- /.content -->
<div class="modal fade payment_modal" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
</div>

<div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
 <script src="<?php echo e(asset('js/payment.js?v=' . $asset_v), false); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/expense/index.blade.php ENDPATH**/ ?>