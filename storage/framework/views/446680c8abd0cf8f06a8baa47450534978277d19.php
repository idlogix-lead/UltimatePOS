<?php $__env->startSection('title', __('manufacturing::lang.recipe')); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('manufacturing::layouts.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo app('translator')->get('manufacturing::lang.recipe'); ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <?php $__env->startComponent('components.widget', ['class' => 'box-solid']); ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("manufacturing.add_recipe")): ?>
        <?php $__env->slot('tool'); ?>
            <div class="box-tools">
                <button class="btn btn-block btn-primary btn-modal" data-container="#recipe_modal" data-href="<?php echo e(action('\Modules\Manufacturing\Http\Controllers\RecipeController@create'), false); ?>">
                    <i class="fa fa-plus"></i> <?php echo app('translator')->get( 'messages.add' ); ?></button>
            </div>
        <?php $__env->endSlot(); ?>
        <?php endif; ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="recipe_table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all-row"></th>
                        <th><?php echo app('translator')->get( 'manufacturing::lang.recipe' ); ?></th>
                        <th><?php echo app('translator')->get( 'product.category' ); ?></th>
                        <th><?php echo app('translator')->get( 'product.sub_category' ); ?></th>
                        <th><?php echo app('translator')->get( 'lang_v1.quantity' ); ?></th>
                        <th><?php echo app('translator')->get( 'lang_v1.price' ); ?> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('manufacturing::lang.price_updated_live') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?></th>
                        <th><?php echo app('translator')->get( 'sale.unit_price' ); ?></th>
                        <th><?php echo app('translator')->get( 'messages.action' ); ?></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="8">
                            <button type="button" class="btn btn-xs btn-danger" id="mass_update_product_price" ><?php echo app('translator')->get('manufacturing::lang.update_product_price'); ?></button> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('manufacturing::lang.update_product_price_help') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    <?php echo $__env->renderComponent(); ?>
</section>
<!-- /.content -->
<div class="modal fade" id="recipe_modal" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
    <?php echo $__env->make('manufacturing::layouts.partials.common_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\Modules\Manufacturing\Providers/../Resources/views/recipe/index.blade.php ENDPATH**/ ?>