<?php $request = app('Illuminate\Http\Request'); ?>
<!-- Main Header -->
  <header class="main-header no-print">
    <a href="<?php echo e(route('home'), false); ?>" class="logo">
      
      <span class="logo-lg"><?php echo e(Session::get('business.name'), false); ?> <i class="fa fa-circle text-success" id="online_indicator"></i></span> 

    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        &#9776;
        <span class="sr-only">Toggle navigation</span>
      </a>

      <?php if(Module::has('Superadmin')): ?>
        <?php if ($__env->exists('superadmin::layouts.partials.active_subscription')) echo $__env->make('superadmin::layouts.partials.active_subscription', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>

        <?php if(!empty(session('previous_user_id')) && !empty(session('previous_username'))): ?>
            <a href="<?php echo e(route('sign-in-as-user', session('previous_user_id')), false); ?>" class="btn btn-flat btn-danger m-8 btn-sm mt-10"><i class="fas fa-undo"></i> <?php echo app('translator')->get('lang_v1.back_to_username', ['username' => session('previous_username')] ); ?></a>
        <?php endif; ?>

      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">

        <?php if(Module::has('Essentials')): ?>
          <?php if ($__env->exists('essentials::layouts.partials.header_part')) echo $__env->make('essentials::layouts.partials.header_part', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        <div class="btn-group">
          <button id="header_shortcut_dropdown" type="button" class="btn btn-success dropdown-toggle btn-flat pull-left m-8 btn-sm mt-10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-plus-circle fa-lg"></i>
          </button>
          <ul class="dropdown-menu">
            <?php if(config('app.env') != 'demo'): ?>
              <li><a href="<?php echo e(route('calendar'), false); ?>">
                  <i class="fas fa-calendar-alt" aria-hidden="true"></i> <?php echo app('translator')->get('lang_v1.calendar'); ?>
              </a></li>
            <?php endif; ?>
            <?php if(Module::has('Essentials')): ?>
              <li><a href="#" class="btn-modal" data-href="<?php echo e(action([\Modules\Essentials\Http\Controllers\ToDoController::class, 'create']), false); ?>" data-container="#task_modal">
                  <i class="fas fa-clipboard-check" aria-hidden="true"></i> <?php echo app('translator')->get( 'essentials::lang.add_to_do' ); ?>
              </a></li>
            <?php endif; ?>
            <!-- Help Button -->
            <?php if(auth()->user()->hasRole('Admin#' . auth()->user()->business_id)): ?>
              <li><a id="start_tour" href="#">
                  <i class="fas fa-question-circle" aria-hidden="true"></i> <?php echo app('translator')->get('lang_v1.application_tour'); ?>
              </a></li>
            <?php endif; ?>
          </ul>
        </div>
        <button id="btnCalculator" title="<?php echo app('translator')->get('lang_v1.calculator'); ?>" type="button" class="btn btn-success btn-flat pull-left m-8 btn-sm mt-10 popover-default hidden-xs" data-toggle="popover" data-trigger="click" data-content='<?php echo $__env->make("layouts.partials.calculator", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>' data-html="true" data-placement="bottom">
            <strong><i class="fa fa-calculator fa-lg" aria-hidden="true"></i></strong>
        </button>
        
        <?php if($request->segment(1) == 'pos'): ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_cash_register')): ?>
          <button type="button" id="register_details" title="<?php echo e(__('cash_register.register_details'), false); ?>" data-toggle="tooltip" data-placement="bottom" class="btn btn-success btn-flat pull-left m-8 btn-sm mt-10 btn-modal" data-container=".register_details_modal" 
          data-href="<?php echo e(action([\App\Http\Controllers\CashRegisterController::class, 'getRegisterDetails']), false); ?>">
            <strong><i class="fa fa-briefcase fa-lg" aria-hidden="true"></i></strong>
          </button>
          <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('close_cash_register')): ?>
          <button type="button" id="close_register" title="<?php echo e(__('cash_register.close_register'), false); ?>" data-toggle="tooltip" data-placement="bottom" class="btn btn-danger btn-flat pull-left m-8 btn-sm mt-10 btn-modal" data-container=".close_register_modal" 
          data-href="<?php echo e(action([\App\Http\Controllers\CashRegisterController::class, 'getCloseRegister']), false); ?>">
            <strong><i class="fa fa-window-close fa-lg"></i></strong>
          </button>
          <?php endif; ?>
        <?php endif; ?>

        <?php if(in_array('pos_sale', $enabled_modules)): ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sell.create')): ?>
            <a href="<?php echo e(action([\App\Http\Controllers\SellPosController::class, 'create']), false); ?>" title="<?php echo app('translator')->get('sale.pos_sale'); ?>" data-toggle="tooltip" data-placement="bottom" class="btn btn-flat pull-left m-8 btn-sm mt-10 btn-success">
              <strong><i class="fa fa-th-large"></i> &nbsp; <?php echo app('translator')->get('sale.pos_sale'); ?></strong>
            </a>
          <?php endif; ?>
        <?php endif; ?>

        <?php if(Module::has('Repair')): ?>
          <?php if ($__env->exists('repair::layouts.partials.header')) echo $__env->make('repair::layouts.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('profit_loss_report.view')): ?>
          <button type="button" id="view_todays_profit" title="<?php echo e(__('home.todays_profit'), false); ?>" data-toggle="tooltip" data-placement="bottom" class="btn btn-success btn-flat pull-left m-8 btn-sm mt-10">
            <strong><i class="fas fa-money-bill-alt fa-lg"></i></strong>
          </button>
        <?php endif; ?>

        <div class="m-8 pull-left mt-15 hidden-xs" style="color: #fff;"><strong><?php echo e(\Carbon::createFromTimestamp(strtotime('now'))->format(session('business.date_format')), false); ?></strong></div>

        <ul class="nav navbar-nav">
          <?php echo $__env->make('layouts.partials.header-notifications', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <?php
                $profile_photo = auth()->user()->media;
              ?>
              <?php if(!empty($profile_photo)): ?>
                <img src="<?php echo e($profile_photo->display_url, false); ?>" class="user-image" alt="User Image">
              <?php endif; ?>
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span><?php echo e(Auth::User()->first_name, false); ?> <?php echo e(Auth::User()->last_name, false); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <?php if(!empty(Session::get('business.logo'))): ?>
                  <img src="<?php echo e(asset( 'uploads/business_logos/' . Session::get('business.logo') ), false); ?>" alt="Logo">
                <?php endif; ?>
                <p>
                  <?php echo e(Auth::User()->first_name, false); ?> <?php echo e(Auth::User()->last_name, false); ?>

                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo e(action([\App\Http\Controllers\UserController::class, 'getProfile']), false); ?>" class="btn btn-default btn-flat"><?php echo app('translator')->get('lang_v1.profile'); ?></a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo e(action([\App\Http\Controllers\Auth\LoginController::class, 'logout']), false); ?>" class="btn btn-default btn-flat"><?php echo app('translator')->get('lang_v1.sign_out'); ?></a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>
    </nav>
  </header><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/layouts/partials/header.blade.php ENDPATH**/ ?>