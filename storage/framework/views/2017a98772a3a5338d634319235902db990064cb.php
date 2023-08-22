<?php $__env->startSection('title', __('home.home')); ?>

<?php $__env->startSection('content'); ?>

<!-- Content Header (Page header) -->
<section class="content-header content-header-custom">
    <h1><?php echo e(__('home.welcome_message', ['name' => Session::get('user.first_name')]), false); ?>

    </h1>
</section>
<!-- Main content -->
<section class="content content-custom no-print">
    <br>
    <?php if(auth()->user()->can('dashboard.data')): ?>
        <?php if($is_admin || true): ?>
        	<div class="row">
                <div class="col-md-4 col-xs-12">
                    <?php if(count($all_locations) > 1): ?>
                        <?php echo Form::select('dashboard_location', $all_locations, null, ['class' => 'form-control select2', 'placeholder' => __('lang_v1.select_location'), 'id' => 'dashboard_location']); ?>

                    <?php endif; ?>
                </div>
        		<div class="col-md-8 col-xs-12">
                    <div class="form-group pull-right">
                          <div class="input-group">
                            <button type="button" class="btn btn-primary" id="dashboard_date_filter">
                              <span>
                                <i class="fa fa-calendar"></i> <?php echo e(__('messages.filter_by_date'), false); ?>

                              </span>
                              <i class="fa fa-caret-down"></i>
                            </button>
                          </div>
                    </div>
        		</div>
        	</div>
    	   <br>
    	   <div class="row">
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                   <div class="info-box info-box-new-style">
                        <span class="info-box-icon bg-aqua"><i class="ion ion-ios-cart-outline"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text"><?php echo e(__('home.total_sell'), false); ?></span>
                          <span class="info-box-number total_sell"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                        </div>
                        <!-- /.info-box-content -->
                   </div>
                  <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                    <div class="info-box info-box-new-style">
                       <span class="info-box-icon bg-green">
                            <i class="ion ion-ios-paper-outline"></i>
                            
                       </span>

                        <div class="info-box-content">
                          <span class="info-box-text"><?php echo e(__('lang_v1.net'), false); ?> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('lang_v1.net_home_tooltip') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?></span>
                          <span class="info-box-number net"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                  <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                    <div class="info-box info-box-new-style">
                       <span class="info-box-icon bg-yellow">
                            <i class="ion ion-ios-paper-outline"></i>
                            <i class="fa fa-exclamation"></i>
                       </span>

                        <div class="info-box-content">
                          <span class="info-box-text"><?php echo e(__('home.invoice_due'), false); ?></span>
                          <span class="info-box-number invoice_due"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                  <!-- /.info-box -->
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                    <div class="info-box info-box-new-style">
                       <span class="info-box-icon bg-red text-white">
                            <i class="fas fa-exchange-alt"></i>
                       </span>

                        <div class="info-box-content">
                          <span class="info-box-text"><?php echo e(__('lang_v1.total_sell_return'), false); ?></span>
                          <span class="info-box-number total_sell_return"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                        </div>
                        <!-- /.info-box-content -->
                        <p class="mb-0 text-muted fs-10 mt-5"><?php echo e(__('lang_v1.total_sell_return'), false); ?>: <span class="total_sr"></span><br>
                            <?php echo e(__('lang_v1.total_sell_return_paid'), false); ?><span class="total_srp"></span></p>
                    </div>
                  <!-- /.info-box -->
                </div>
    	    <!-- /.col -->
            </div>
          	<div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                   <div class="info-box info-box-new-style">
                        <span class="info-box-icon bg-aqua"><i class="ion ion-cash"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text"><?php echo e(__('home.total_purchase'), false); ?></span>
                          <span class="info-box-number total_purchase"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                        </div>
                        <!-- /.info-box-content -->
                   </div>
                   <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                   <div class="info-box info-box-new-style">
                        <span class="info-box-icon bg-yellow">
                            <i class="fa fa-dollar"></i>
                            <i class="fa fa-exclamation"></i>
                        </span>

                        <div class="info-box-content">
                          <span class="info-box-text"><?php echo e(__('home.purchase_due'), false); ?></span>
                          <span class="info-box-number purchase_due"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                        </div>
                        <!-- /.info-box-content -->
                   </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                    <div class="info-box info-box-new-style">
                       <span class="info-box-icon bg-red text-white">
                            <i class="fas fa-undo-alt"></i>
                       </span>

                        <div class="info-box-content">
                          <span class="info-box-text"><?php echo e(__('lang_v1.total_purchase_return'), false); ?></span>
                          <span class="info-box-number total_purchase_return"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                        </div>
                        <!-- /.info-box-content -->
                         <p class="mb-0 text-muted fs-10 mt-5"><?php echo e(__('lang_v1.total_purchase_return'), false); ?>: <span class="total_pr"></span><br>
                            <?php echo e(__('lang_v1.total_purchase_return_paid'), false); ?><span class="total_prp"></span></p>
                    </div>
                  <!-- /.info-box -->
                </div>

                <!-- expense -->
                <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
                    <div class="info-box info-box-new-style">
                        <span class="info-box-icon bg-red">
                          <i class="fas fa-minus-circle"></i>
                        </span>

                        <div class="info-box-content">
                          <span class="info-box-text">
                            <?php echo e(__('lang_v1.expense'), false); ?>

                          </span>
                          <span class="info-box-number total_expense"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                  <!-- /.info-box -->
                </div>
            </div>
            <?php if(!empty($widgets['after_sale_purchase_totals'])): ?>
                <?php $__currentLoopData = $widgets['after_sale_purchase_totals']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $widget; ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endif; ?> 
        <!-- end is_admin check -->
         <?php if(auth()->user()->can('sell.view') || auth()->user()->can('direct_sell.view')): ?>
            <?php if(!empty($all_locations)): ?>
              	<!-- sales chart start -->
              	<div class="row">
              		<div class="col-sm-12">
                        <?php $__env->startComponent('components.widget', ['class' => 'box-primary', 'title' => __('home.sells_last_30_days')]); ?>
                          <?php echo $sells_chart_1->container(); ?>

                        <?php echo $__env->renderComponent(); ?>
              		</div>
              	</div>
            <?php endif; ?>
            <?php if(!empty($widgets['after_sales_last_30_days'])): ?>
                <?php $__currentLoopData = $widgets['after_sales_last_30_days']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $widget; ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php if(!empty($all_locations)): ?>
              	<div class="row">
              		<div class="col-sm-12">
                        <?php $__env->startComponent('components.widget', ['class' => 'box-primary', 'title' => __('home.sells_current_fy')]); ?>
                          <?php echo $sells_chart_2->container(); ?>

                        <?php echo $__env->renderComponent(); ?>
              		</div>
              	</div>
            <?php endif; ?>
        <?php endif; ?>
      	<!-- sales chart end -->
        <?php if(!empty($widgets['after_sales_current_fy'])): ?>
            <?php $__currentLoopData = $widgets['after_sales_current_fy']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $widget; ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
      	<!-- products less than alert quntity -->
      	<div class="row">
            <?php if(auth()->user()->can('sell.view') || auth()->user()->can('direct_sell.view')): ?>
                <div class="col-sm-6">
                    <?php $__env->startComponent('components.widget', ['class' => 'box-warning']); ?>
                      <?php $__env->slot('icon'); ?>
                        <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
                      <?php $__env->endSlot(); ?>
                      <?php $__env->slot('title'); ?>
                        <?php echo e(__('lang_v1.sales_payment_dues'), false); ?> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('lang_v1.tooltip_sales_payment_dues') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
                      <?php $__env->endSlot(); ?>
                        <div class="row">
                            <?php if(count($all_locations) > 1): ?>
                                <div class="col-md-6 col-sm-6 col-md-offset-6 mb-10">
                                    <?php echo Form::select('sales_payment_dues_location', $all_locations, null, ['class' => 'form-control select2', 'placeholder' => __('lang_v1.select_location'), 'id' => 'sales_payment_dues_location']); ?>

                                </div>
                            <?php endif; ?>
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped" id="sales_payment_dues_table" style="width: 100%;">
                                    <thead>
                                      <tr>
                                        <th><?php echo app('translator')->get( 'contact.customer' ); ?></th>
                                        <th><?php echo app('translator')->get( 'sale.invoice_no' ); ?></th>
                                        <th><?php echo app('translator')->get( 'home.due_amount' ); ?></th>
                                        <th><?php echo app('translator')->get( 'messages.action' ); ?></th>
                                      </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    <?php echo $__env->renderComponent(); ?>
                </div>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase.view')): ?>
                <div class="col-sm-6">
                    <?php $__env->startComponent('components.widget', ['class' => 'box-warning']); ?>
                    <?php $__env->slot('icon'); ?>
                    <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
                    <?php $__env->endSlot(); ?>
                    <?php $__env->slot('title'); ?>
                    <?php echo e(__('lang_v1.purchase_payment_dues'), false); ?> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('tooltip.payment_dues') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
                    <?php $__env->endSlot(); ?>
                    <div class="row">
                        <?php if(count($all_locations) > 1): ?>
                            <div class="col-md-6 col-sm-6 col-md-offset-6 mb-10">
                                <?php echo Form::select('purchase_payment_dues_location', $all_locations, null, ['class' => 'form-control select2', 'placeholder' => __('lang_v1.select_location'), 'id' => 'purchase_payment_dues_location']); ?>

                            </div>
                        <?php endif; ?>
                        <div class="col-md-12">
                            <table class="table table-bordered table-striped" id="purchase_payment_dues_table" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th><?php echo app('translator')->get( 'purchase.supplier' ); ?></th>
                                    <th><?php echo app('translator')->get( 'purchase.ref_no' ); ?></th>
                                    <th><?php echo app('translator')->get( 'home.due_amount' ); ?></th>
                                    <th><?php echo app('translator')->get( 'messages.action' ); ?></th>
                                  </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <?php echo $__env->renderComponent(); ?>
                </div>
            <?php endif; ?>
        </div>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stock_report.view')): ?>
            <div class="row">
                <div class="<?php if((session('business.enable_product_expiry') != 1) && auth()->user()->can('stock_report.view')): ?> col-sm-12 <?php else: ?> col-sm-6 <?php endif; ?>">
                    <?php $__env->startComponent('components.widget', ['class' => 'box-warning']); ?>
                      <?php $__env->slot('icon'); ?>
                        <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
                      <?php $__env->endSlot(); ?>
                      <?php $__env->slot('title'); ?>
                        <?php echo e(__('home.product_stock_alert'), false); ?> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('tooltip.product_stock_alert') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
                      <?php $__env->endSlot(); ?>
                      <div class="row">
                            <?php if(count($all_locations) > 1): ?>
                                <div class="col-md-6 col-sm-6 col-md-offset-6 mb-10">
                                    <?php echo Form::select('stock_alert_location', $all_locations, null, ['class' => 'form-control select2', 'placeholder' => __('lang_v1.select_location'), 'id' => 'stock_alert_location']); ?>

                                </div>
                            <?php endif; ?>
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped" id="stock_alert_table" style="width: 100%;">
                                    <thead>
                                      <tr>
                                        <th><?php echo app('translator')->get( 'sale.product' ); ?></th>
                                        <th><?php echo app('translator')->get( 'business.location' ); ?></th>
                                        <th><?php echo app('translator')->get( 'report.current_stock' ); ?></th>
                                      </tr>
                                    </thead>
                                </table>
                            </div>
                      </div>
                    <?php echo $__env->renderComponent(); ?>
                </div>
                <?php if(session('business.enable_product_expiry') == 1): ?>
                    <div class="col-sm-6">
                        <?php $__env->startComponent('components.widget', ['class' => 'box-warning']); ?>
                          <?php $__env->slot('icon'); ?>
                            <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
                          <?php $__env->endSlot(); ?>
                          <?php $__env->slot('title'); ?>
                            <?php echo e(__('home.stock_expiry_alert'), false); ?> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('tooltip.stock_expiry_alert', [ 'days' =>session('business.stock_expiry_alert_days', 30) ]) . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
                          <?php $__env->endSlot(); ?>
                          <input type="hidden" id="stock_expiry_alert_days" value="<?php echo e(\Carbon::now()->addDays(session('business.stock_expiry_alert_days', 30))->format('Y-m-d'), false); ?>">
                          <table class="table table-bordered table-striped" id="stock_expiry_alert_table">
                            <thead>
                              <tr>
                                  <th><?php echo app('translator')->get('business.product'); ?></th>
                                  <th><?php echo app('translator')->get('business.location'); ?></th>
                                  <th><?php echo app('translator')->get('report.stock_left'); ?></th>
                                  <th><?php echo app('translator')->get('product.expires_in'); ?></th>
                              </tr>
                            </thead>
                          </table>
                        <?php echo $__env->renderComponent(); ?>
                    </div>
                <?php endif; ?>
      	    </div>
        <?php endif; ?>
        <?php if(auth()->user()->can('so.view_all') || auth()->user()->can('so.view_own')): ?>
            <div class="row" <?php if(!auth()->user()->can('dashboard.data')): ?>style="margin-top: 190px !important;"<?php endif; ?>>
                <div class="col-sm-12">
                    <?php $__env->startComponent('components.widget', ['class' => 'box-warning']); ?>
                        <?php $__env->slot('icon'); ?>
                            <i class="fas fa-list-alt text-yellow fa-lg" aria-hidden="true"></i>
                        <?php $__env->endSlot(); ?>
                        <?php $__env->slot('title'); ?>
                            <?php echo e(__('lang_v1.sales_order'), false); ?>

                        <?php $__env->endSlot(); ?>
                        <div class="row">
                        <?php if(count($all_locations) > 1): ?>
                            <div class="col-md-4 col-sm-6 col-md-offset-8 mb-10">
                                <?php echo Form::select('so_location', $all_locations, null, ['class' => 'form-control select2', 'placeholder' => __('lang_v1.select_location'), 'id' => 'so_location']); ?>

                            </div>
                        <?php endif; ?>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped ajax_view" id="sales_order_table">
                                        <thead>
                                            <tr>
                                                <th><?php echo app('translator')->get('messages.action'); ?></th>
                                                <th><?php echo app('translator')->get('messages.date'); ?></th>
                                                <th><?php echo app('translator')->get('restaurant.order_no'); ?></th>
                                                <th><?php echo app('translator')->get('sale.customer_name'); ?></th>
                                                <th><?php echo app('translator')->get('lang_v1.contact_no'); ?></th>
                                                <th><?php echo app('translator')->get('sale.location'); ?></th>
                                                <th><?php echo app('translator')->get('sale.status'); ?></th>
                                                <th><?php echo app('translator')->get('lang_v1.shipping_status'); ?></th>
                                                <th><?php echo app('translator')->get('lang_v1.quantity_remaining'); ?></th>
                                                <th><?php echo app('translator')->get('lang_v1.added_by'); ?></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php echo $__env->renderComponent(); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if(!empty($common_settings['enable_purchase_requisition']) && (auth()->user()->can('purchase_requisition.view_all') || auth()->user()->can('purchase_requisition.view_own')) ): ?>
            <div class="row" <?php if(!auth()->user()->can('dashboard.data')): ?>style="margin-top: 190px !important;"<?php endif; ?>>
                <div class="col-sm-12">
                    <?php $__env->startComponent('components.widget', ['class' => 'box-warning']); ?>
                      <?php $__env->slot('icon'); ?>
                          <i class="fas fa-list-alt text-yellow fa-lg" aria-hidden="true"></i>
                      <?php $__env->endSlot(); ?>
                      <?php $__env->slot('title'); ?>
                          <?php echo app('translator')->get('lang_v1.purchase_requisition'); ?>
                      <?php $__env->endSlot(); ?>
                        <div class="row">
                        <?php if(count($all_locations) > 1): ?>
                            <div class="col-md-4 col-sm-6 col-md-offset-8 mb-10">
                                <?php echo Form::select('pr_location', $all_locations, null, ['class' => 'form-control select2', 'placeholder' => __('lang_v1.select_location'), 'id' => 'pr_location']); ?>

                            </div>
                        <?php endif; ?>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped ajax_view" id="purchase_requisition_table" style="width: 100%;">
                                      <thead>
                                          <tr>
                                            <th><?php echo app('translator')->get('messages.action'); ?></th>
                                            <th><?php echo app('translator')->get('messages.date'); ?></th>
                                            <th><?php echo app('translator')->get('purchase.ref_no'); ?></th>
                                            <th><?php echo app('translator')->get('purchase.location'); ?></th>
                                            <th><?php echo app('translator')->get('sale.status'); ?></th>
                                            <th><?php echo app('translator')->get('lang_v1.required_by_date'); ?></th>
                                            <th><?php echo app('translator')->get('lang_v1.added_by'); ?></th>
                                          </tr>
                                      </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php echo $__env->renderComponent(); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if(!empty($common_settings['enable_purchase_order']) && (auth()->user()->can('purchase_order.view_all') || auth()->user()->can('purchase_order.view_own')) ): ?>
            <div class="row" <?php if(!auth()->user()->can('dashboard.data')): ?>style="margin-top: 190px !important;"<?php endif; ?>>
                <div class="col-sm-12">
                    <?php $__env->startComponent('components.widget', ['class' => 'box-warning']); ?>
                      <?php $__env->slot('icon'); ?>
                          <i class="fas fa-list-alt text-yellow fa-lg" aria-hidden="true"></i>
                      <?php $__env->endSlot(); ?>
                      <?php $__env->slot('title'); ?>
                          <?php echo app('translator')->get('lang_v1.purchase_order'); ?>
                      <?php $__env->endSlot(); ?>
                        <div class="row">
                        <?php if(count($all_locations) > 1): ?>
                            <div class="col-md-4 col-sm-6 col-md-offset-8 mb-10">
                                <?php echo Form::select('po_location', $all_locations, null, ['class' => 'form-control select2', 'placeholder' => __('lang_v1.select_location'), 'id' => 'po_location']); ?>

                            </div>
                        <?php endif; ?>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped ajax_view" id="purchase_order_table" style="width: 100%;">
                                      <thead>
                                          <tr>
                                              <th><?php echo app('translator')->get('messages.action'); ?></th>
                                              <th><?php echo app('translator')->get('messages.date'); ?></th>
                                              <th><?php echo app('translator')->get('purchase.ref_no'); ?></th>
                                              <th><?php echo app('translator')->get('purchase.location'); ?></th>
                                              <th><?php echo app('translator')->get('purchase.supplier'); ?></th>
                                              <th><?php echo app('translator')->get('sale.status'); ?></th>
                                              <th><?php echo app('translator')->get('lang_v1.quantity_remaining'); ?></th>
                                              <th><?php echo app('translator')->get('lang_v1.added_by'); ?></th>
                                          </tr>
                                      </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php echo $__env->renderComponent(); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if(auth()->user()->can('access_pending_shipments_only') || auth()->user()->can('access_shipping') || auth()->user()->can('access_own_shipping') ): ?>
            <?php $__env->startComponent('components.widget', ['class' => 'box-warning']); ?>
              <?php $__env->slot('icon'); ?>
                  <i class="fas fa-list-alt text-yellow fa-lg" aria-hidden="true"></i>
              <?php $__env->endSlot(); ?>
              <?php $__env->slot('title'); ?>
                  <?php echo app('translator')->get('lang_v1.pending_shipments'); ?>
              <?php $__env->endSlot(); ?>
                <div class="row">
                    <?php if(count($all_locations) > 1): ?>
                        <div class="col-md-4 col-sm-6 col-md-offset-8 mb-10">
                            <?php echo Form::select('pending_shipments_location', $all_locations, null, ['class' => 'form-control select2', 'placeholder' => __('lang_v1.select_location'), 'id' => 'pending_shipments_location']); ?>

                        </div>
                    <?php endif; ?>
                    <div class="col-md-12">  
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped ajax_view" id="shipments_table">
                                <thead>
                                    <tr>
                                        <th><?php echo app('translator')->get('messages.action'); ?></th>
                                        <th><?php echo app('translator')->get('messages.date'); ?></th>
                                        <th><?php echo app('translator')->get('sale.invoice_no'); ?></th>
                                        <th><?php echo app('translator')->get('sale.customer_name'); ?></th>
                                        <th><?php echo app('translator')->get('lang_v1.contact_no'); ?></th>
                                        <th><?php echo app('translator')->get('sale.location'); ?></th>
                                        <th><?php echo app('translator')->get('lang_v1.shipping_status'); ?></th>
                                        <?php if(!empty($custom_labels['shipping']['custom_field_1'])): ?>
                                            <th>
                                                <?php echo e($custom_labels['shipping']['custom_field_1'], false); ?>

                                            </th>
                                        <?php endif; ?>
                                        <?php if(!empty($custom_labels['shipping']['custom_field_2'])): ?>
                                            <th>
                                                <?php echo e($custom_labels['shipping']['custom_field_2'], false); ?>

                                            </th>
                                        <?php endif; ?>
                                        <?php if(!empty($custom_labels['shipping']['custom_field_3'])): ?>
                                            <th>
                                                <?php echo e($custom_labels['shipping']['custom_field_3'], false); ?>

                                            </th>
                                        <?php endif; ?>
                                        <?php if(!empty($custom_labels['shipping']['custom_field_4'])): ?>
                                            <th>
                                                <?php echo e($custom_labels['shipping']['custom_field_4'], false); ?>

                                            </th>
                                        <?php endif; ?>
                                        <?php if(!empty($custom_labels['shipping']['custom_field_5'])): ?>
                                            <th>
                                                <?php echo e($custom_labels['shipping']['custom_field_5'], false); ?>

                                            </th>
                                        <?php endif; ?>
                                        <th><?php echo app('translator')->get('sale.payment_status'); ?></th>
                                        <th><?php echo app('translator')->get('restaurant.service_staff'); ?></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div> 
                </div>
            <?php echo $__env->renderComponent(); ?>
        <?php endif; ?>

        <?php if(auth()->user()->can('account.access') && config('constants.show_payments_recovered_today') == true): ?>
            <?php $__env->startComponent('components.widget', ['class' => 'box-warning']); ?>
              <?php $__env->slot('icon'); ?>
                  <i class="fas fa-money-bill-alt text-yellow fa-lg" aria-hidden="true"></i>
              <?php $__env->endSlot(); ?>
              <?php $__env->slot('title'); ?>
                  <?php echo app('translator')->get('lang_v1.payment_recovered_today'); ?>
              <?php $__env->endSlot(); ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="cash_flow_table">
                        <thead>
                            <tr>
                                <th><?php echo app('translator')->get( 'messages.date' ); ?></th>
                                <th><?php echo app('translator')->get( 'account.account' ); ?></th>
                                <th><?php echo app('translator')->get( 'lang_v1.description' ); ?></th>
                                <th><?php echo app('translator')->get( 'lang_v1.payment_method' ); ?></th>
                                <th><?php echo app('translator')->get( 'lang_v1.payment_details' ); ?></th>
                                <th><?php echo app('translator')->get('account.credit'); ?></th>
                                <th><?php echo app('translator')->get( 'lang_v1.account_balance' ); ?> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('lang_v1.account_balance_tooltip') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?></th>
                                <th><?php echo app('translator')->get( 'lang_v1.total_balance' ); ?> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('lang_v1.total_balance_tooltip') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="bg-gray font-17 footer-total text-center">
                                <td colspan="5"><strong><?php echo app('translator')->get('sale.total'); ?>:</strong></td>
                                <td class="footer_total_credit"></td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php echo $__env->renderComponent(); ?>
        <?php endif; ?>

        <?php if(!empty($widgets['after_dashboard_reports'])): ?>
          <?php $__currentLoopData = $widgets['after_dashboard_reports']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $widget; ?>

          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

    <?php endif; ?>
   <!-- can('dashboard.data') end -->
</section>
<!-- /.content -->
<div class="modal fade payment_modal" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
</div>
<div class="modal fade edit_pso_status_modal" tabindex="-1" role="dialog"></div>
<div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
    <script src="<?php echo e(asset('js/home.js?v=' . $asset_v), false); ?>"></script>
    <script src="<?php echo e(asset('js/payment.js?v=' . $asset_v), false); ?>"></script>
    <?php if ($__env->exists('sales_order.common_js')) echo $__env->make('sales_order.common_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if ($__env->exists('purchase_order.common_js')) echo $__env->make('purchase_order.common_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if(!empty($all_locations)): ?>
        <?php echo $sells_chart_1->script(); ?>

        <?php echo $sells_chart_2->script(); ?>

    <?php endif; ?>
    <script type="text/javascript">
        $(document).ready( function(){
        sales_order_table = $('#sales_order_table').DataTable({
          processing: true,
          serverSide: true,
          scrollY: "75vh",
          scrollX:        true,
          scrollCollapse: true,
          aaSorting: [[1, 'desc']],
          "ajax": {
              "url": '<?php echo e(action([\App\Http\Controllers\SellController::class, 'index']), false); ?>?sale_type=sales_order',
              "data": function ( d ) {
                    d.for_dashboard_sales_order = true;

                    if ($('#so_location').length > 0) {
                        d.location_id = $('#so_location').val();
                    }
                }
          },
          columnDefs: [ {
              "targets": 7,
              "orderable": false,
              "searchable": false
          } ],
          columns: [
              { data: 'action', name: 'action'},
              { data: 'transaction_date', name: 'transaction_date'  },
              { data: 'invoice_no', name: 'invoice_no'},
              { data: 'conatct_name', name: 'conatct_name'},
              { data: 'mobile', name: 'contacts.mobile'},
              { data: 'business_location', name: 'bl.name'},
              { data: 'status', name: 'status'},
              { data: 'shipping_status', name: 'shipping_status'},
              { data: 'so_qty_remaining', name: 'so_qty_remaining', "searchable": false},
              { data: 'added_by', name: 'u.first_name'},
          ]
        });

        <?php if(auth()->user()->can('account.access') && config('constants.show_payments_recovered_today') == true): ?>

            // Cash Flow Table
            cash_flow_table = $('#cash_flow_table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                        "url": "<?php echo e(action([\App\Http\Controllers\AccountController::class, 'cashFlow']), false); ?>",
                        "data": function ( d ) {
                            d.type = 'credit';
                            d.only_payment_recovered = true;
                        }
                    },
                "ordering": false,
                "searching": false,
                columns: [
                    {data: 'operation_date', name: 'operation_date'},
                    {data: 'account_name', name: 'account_name'},
                    {data: 'sub_type', name: 'sub_type'},
                    {data: 'method', name: 'TP.method'},
                    {data: 'payment_details', name: 'payment_details', searchable: false},
                    {data: 'credit', name: 'amount'},
                    {data: 'balance', name: 'balance'},
                    {data: 'total_balance', name: 'total_balance'},
                ],
                "fnDrawCallback": function (oSettings) {
                    __currency_convert_recursively($('#cash_flow_table'));
                },
                "footerCallback": function ( row, data, start, end, display ) {
                    var footer_total_credit = 0;

                    for (var r in data){
                        footer_total_credit += $(data[r].credit).data('orig-value') ? parseFloat($(data[r].credit).data('orig-value')) : 0;
                    }
                    $('.footer_total_credit').html(__currency_trans_from_en(footer_total_credit));
                }
            });
        <?php endif; ?>

        $('#so_location').change( function(){
            sales_order_table.ajax.reload();
        });
        <?php if(!empty($common_settings['enable_purchase_order'])): ?>
          //Purchase table
          purchase_order_table = $('#purchase_order_table').DataTable({
              processing: true,
              serverSide: true,
              aaSorting: [[1, 'desc']],
              scrollY: "75vh",
              scrollX:        true,
              scrollCollapse: true,
              ajax: {
                  url: '<?php echo e(action([\App\Http\Controllers\PurchaseOrderController::class, 'index']), false); ?>',
                  data: function(d) {
                      d.from_dashboard = true;

                        if ($('#po_location').length > 0) {
                            d.location_id = $('#po_location').val();
                        }
                  },
              },
              columns: [
                  { data: 'action', name: 'action', orderable: false, searchable: false },
                  { data: 'transaction_date', name: 'transaction_date' },
                  { data: 'ref_no', name: 'ref_no' },
                  { data: 'location_name', name: 'BS.name' },
                  { data: 'name', name: 'contacts.name' },
                  { data: 'status', name: 'transactions.status' },
                  { data: 'po_qty_remaining', name: 'po_qty_remaining', "searchable": false},
                  { data: 'added_by', name: 'u.first_name' }
              ]
            })

            $('#po_location').change( function(){
                purchase_order_table.ajax.reload();
            });
        <?php endif; ?>

        <?php if(!empty($common_settings['enable_purchase_requisition'])): ?>
          //Purchase table
          purchase_requisition_table = $('#purchase_requisition_table').DataTable({
              processing: true,
              serverSide: true,
              aaSorting: [[1, 'desc']],
              scrollY: "75vh",
              scrollX:        true,
              scrollCollapse: true,
              ajax: {
                  url: '<?php echo e(action([\App\Http\Controllers\PurchaseRequisitionController::class, 'index']), false); ?>',
                  data: function(d) {
                      d.from_dashboard = true;

                        if ($('#pr_location').length > 0) {
                            d.location_id = $('#pr_location').val();
                        }
                  },
              },
              columns: [
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                    { data: 'transaction_date', name: 'transaction_date' },
                    { data: 'ref_no', name: 'ref_no' },
                    { data: 'location_name', name: 'BS.name' },
                    { data: 'status', name: 'status' },
                    { data: 'delivery_date', name: 'delivery_date' },
                    { data: 'added_by', name: 'u.first_name' },
              ]
            })

            $('#pr_location').change( function(){
                purchase_requisition_table.ajax.reload();
            });

            $(document).on('click', 'a.delete-purchase-requisition', function(e) {
                e.preventDefault();
                swal({
                    title: LANG.sure,
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                }).then(willDelete => {
                    if (willDelete) {
                        var href = $(this).attr('href');
                        $.ajax({
                            method: 'DELETE',
                            url: href,
                            dataType: 'json',
                            success: function(result) {
                                if (result.success == true) {
                                    toastr.success(result.msg);
                                    purchase_requisition_table.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            },
                        });
                    }
                });
            });
        <?php endif; ?>

        sell_table = $('#shipments_table').DataTable({
            processing: true,
            serverSide: true,
            aaSorting: [[1, 'desc']],
            scrollY:        "75vh",
            scrollX:        true,
            scrollCollapse: true,
            "ajax": {
                "url": '<?php echo e(action([\App\Http\Controllers\SellController::class, 'index']), false); ?>',
                "data": function ( d ) {
                    d.only_pending_shipments = true;
                    if ($('#pending_shipments_location').length > 0) {
                        d.location_id = $('#pending_shipments_location').val();
                    }
                }
            },
            columns: [
                { data: 'action', name: 'action', searchable: false, orderable: false},
                { data: 'transaction_date', name: 'transaction_date'  },
                { data: 'invoice_no', name: 'invoice_no'},
                { data: 'conatct_name', name: 'conatct_name'},
                { data: 'mobile', name: 'contacts.mobile'},
                { data: 'business_location', name: 'bl.name'},
                { data: 'shipping_status', name: 'shipping_status'},
                <?php if(!empty($custom_labels['shipping']['custom_field_1'])): ?>
                    { data: 'shipping_custom_field_1', name: 'shipping_custom_field_1'},
                <?php endif; ?>
                <?php if(!empty($custom_labels['shipping']['custom_field_2'])): ?>
                    { data: 'shipping_custom_field_2', name: 'shipping_custom_field_2'},
                <?php endif; ?>
                <?php if(!empty($custom_labels['shipping']['custom_field_3'])): ?>
                    { data: 'shipping_custom_field_3', name: 'shipping_custom_field_3'},
                <?php endif; ?>
                <?php if(!empty($custom_labels['shipping']['custom_field_4'])): ?>
                    { data: 'shipping_custom_field_4', name: 'shipping_custom_field_4'},
                <?php endif; ?>
                <?php if(!empty($custom_labels['shipping']['custom_field_5'])): ?>
                    { data: 'shipping_custom_field_5', name: 'shipping_custom_field_5'},
                <?php endif; ?>
                { data: 'payment_status', name: 'payment_status'},
                { data: 'waiter', name: 'ss.first_name', <?php if(empty($is_service_staff_enabled)): ?> visible: false <?php endif; ?> }
            ],
            "fnDrawCallback": function (oSettings) {
                __currency_convert_recursively($('#sell_table'));
            },
            createdRow: function( row, data, dataIndex ) {
                $( row ).find('td:eq(4)').attr('class', 'clickable_td');
            }
        });

        $('#pending_shipments_location').change( function(){
            sell_table.ajax.reload();
        });
    });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/home/index.blade.php ENDPATH**/ ?>