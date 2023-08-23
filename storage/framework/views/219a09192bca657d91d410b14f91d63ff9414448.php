
<div class="row">
        <div class="col-xs-6">
            <?php $__env->startComponent('components.widget', ['title' => __('purchase.purchases')]); ?>
                <table class="table table-striped">
                    <tr>
                        <th><?php echo e(__('report.total_purchase'), false); ?>:</th>
                        <td>
                            <span class="total_purchase">
                                <i class="fas fa-sync fa-spin fa-fw"></i>
                                <span <?php echo e(isset($api)?"":"hidden", false); ?>><?php echo e(isset($symbol)?$symbol:null, false); ?> <?php echo e(isset($api["purchase"]["total_purchase_exc_tax"])?round($api["purchase"]["total_purchase_exc_tax"],2):0, false); ?></span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th><?php echo e(__('report.purchase_inc_tax'), false); ?>:</th>
                        <td>
                             <span class="purchase_inc_tax">
                                <i class="fas fa-sync fa-spin fa-fw"></i>
                                <span <?php echo e(isset($api)?"":"hidden", false); ?>><?php echo e(isset($symbol)?$symbol:null, false); ?> <?php echo e(isset($api["purchase"]["total_purchase_inc_tax"])?round($api["purchase"]["total_purchase_inc_tax"],2):0, false); ?></span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th><?php echo e(__('lang_v1.total_purchase_return_inc_tax'), false); ?>:</th>
                        <td>
                             <span class="purchase_return_inc_tax">
                                <i class="fas fa-sync fa-spin fa-fw"></i>
                                <span <?php echo e(isset($api)?"":"hidden", false); ?>><?php echo e(isset($symbol)?$symbol:null, false); ?> <?php echo e(isset($api["total_purchase_return"])?round($api["total_purchase_return"],2):0, false); ?></span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th><?php echo e(__('report.purchase_due'), false); ?>: <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('tooltip.purchase_due') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?></th>
                        <td>
                             <span class="purchase_due">
                                <i class="fas fa-sync fa-spin fa-fw"></i>
                                <span <?php echo e(isset($api)?"":"hidden", false); ?>><?php echo e(isset($symbol)?$symbol:null, false); ?> <?php echo e(isset($api["purchase"]["purchase_due"])?round($api["purchase"]["purchase_due"],2):0, false); ?></span>
                            </span>
                        </td>
                    </tr>
                </table>
            <?php echo $__env->renderComponent(); ?>
        </div>

        <div class="col-xs-6">
            <?php $__env->startComponent('components.widget', ['title' => __('sale.sells')]); ?>
                <table class="table table-striped">
                    <tr>
                        <th><?php echo e(__('report.total_sell'), false); ?>:</th>
                        <td>
                            <span class="total_sell">
                                <i class="fas fa-sync fa-spin fa-fw"></i>
                                <span <?php echo e(isset($api)?"":"hidden", false); ?>><?php echo e(isset($symbol)?$symbol:null, false); ?> <?php echo e(isset($api["sell"]["total_sell_exc_tax"])?round($api["sell"]["total_sell_exc_tax"],2):0, false); ?></span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th><?php echo e(__('report.sell_inc_tax'), false); ?>:</th>
                        <td>
                             <span class="sell_inc_tax">
                                <i class="fas fa-sync fa-spin fa-fw"></i>
                                <span <?php echo e(isset($api)?"":"hidden", false); ?>><?php echo e(isset($symbol)?$symbol:null, false); ?> <?php echo e(isset($api["sell"]["total_sell_inc_tax"])?round($api["sell"]["total_sell_inc_tax"],2):0, false); ?></span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th><?php echo e(__('lang_v1.total_sell_return_inc_tax'), false); ?>:</th>
                        <td>
                             <span class="total_sell_return">
                                <i class="fas fa-sync fa-spin fa-fw"></i>
                                <span <?php echo e(isset($api)?"":"hidden", false); ?>><?php echo e(isset($symbol)?$symbol:null, false); ?> <?php echo e(isset($api["total_sell_return"])?round($api["total_sell_return"],2):0, false); ?></span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th><?php echo e(__('report.sell_due'), false); ?>: <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('tooltip.sell_due') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?></th>
                        <td>
                            <span class="sell_due">
                                <i class="fas fa-sync fa-spin fa-fw"></i>
                                <span <?php echo e(isset($api)?"":"hidden", false); ?>><?php echo e(isset($symbol)?$symbol:null, false); ?> <?php echo e(isset($api["sell"]["invoice_due"])?round($api["sell"]["total_sell_inc_tax"],2):0, false); ?></span>
                            </span>
                        </td>
                    </tr>
                </table>
            <?php echo $__env->renderComponent(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?php $__env->startComponent('components.widget'); ?>
                <?php $__env->slot('title'); ?>
                    <?php echo e(__('lang_v1.overall'), false); ?> 
                    ((<?php echo app('translator')->get('business.sale'); ?> - <?php echo app('translator')->get('lang_v1.sell_return'); ?>) - (<?php echo app('translator')->get('lang_v1.purchase'); ?> - <?php echo app('translator')->get('lang_v1.purchase_return'); ?>) ) 
                    <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('tooltip.over_all_sell_purchase') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
                <?php $__env->endSlot(); ?>
                <h3 class="text-muted">
                    <?php echo e(__('report.sell_minus_purchase'), false); ?>: 
                    <span class="sell_minus_purchase">
                        <i class="fas fa-sync fa-spin fa-fw"></i>
                        <span <?php echo e(isset($api)?"":"hidden", false); ?>><?php echo e(isset($symbol)?$symbol:null, false); ?> <?php echo e(isset($api["difference"]["total"])?round($api["difference"]["total"],2):0, false); ?></span>
                    </span>
                </h3>

                <h3 class="text-muted">
                    <?php echo e(__('report.difference_due'), false); ?>: 
                    <span class="difference_due">
                        <i class="fas fa-sync fa-spin fa-fw"></i>
                        <span <?php echo e(isset($api)?"":"hidden", false); ?>><?php echo e(isset($symbol)?$symbol:null, false); ?> <?php echo e(isset($api["difference"]["due"])?round($api["difference"]["due"],2):0, false); ?></span>
                    </span>
                </h3>
            <?php echo $__env->renderComponent(); ?>
        </div>
    </div><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/report/partials/purchase_sell.blade.php ENDPATH**/ ?>