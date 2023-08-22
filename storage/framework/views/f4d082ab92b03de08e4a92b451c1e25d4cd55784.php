<?php $request = app('Illuminate\Http\Request'); ?>

<?php if($request->segment(1) == 'pos' && ($request->segment(2) == 'create' || $request->segment(3) == 'edit'
 || $request->segment(2) == 'payment')): ?>
    <?php
        $pos_layout = true;
    ?>
<?php else: ?>
    <?php
        $pos_layout = false;
    ?>
<?php endif; ?>

<?php
    $whitelist = ['127.0.0.1', '::1'];
?>

<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale(), false); ?>" dir="<?php echo e(in_array(session()->get('user.language', config('app.locale')), config('constants.langs_rtl')) ? 'rtl' : 'ltr', false); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="<?php echo e(csrf_token(), false); ?>">

        <title><?php echo $__env->yieldContent('title'); ?> - <?php echo e(Session::get('business.name'), false); ?></title>
        
        <?php echo $__env->make('layouts.partials.css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->yieldContent('css'); ?>
    </head>

    <body class="<?php if($pos_layout): ?> hold-transition lockscreen <?php else: ?> hold-transition skin-<?php if(!empty(session('business.theme_color'))): ?><?php echo e(session('business.theme_color'), false); ?><?php else: ?><?php echo e('blue-light', false); ?><?php endif; ?> sidebar-mini <?php endif; ?>">
        <div class="wrapper thetop">
            <script type="text/javascript">
                if(localStorage.getItem("upos_sidebar_collapse") == 'true'){
                    var body = document.getElementsByTagName("body")[0];
                    body.className += " sidebar-collapse";
                }
            </script>
            <?php if(!$pos_layout): ?>
                <?php echo $__env->make('layouts.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->make('layouts.partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php else: ?>
                <?php echo $__env->make('layouts.partials.header-pos', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <?php if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)): ?>
                <input type="hidden" id="__is_localhost" value="true">
            <?php endif; ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="<?php if(!$pos_layout): ?> content-wrapper <?php endif; ?>">
                <!-- empty div for vuejs -->
                <div id="app">
                    <?php echo $__env->yieldContent('vue'); ?>
                </div>
                <!-- Add currency related field-->
                <input type="hidden" id="__code" value="<?php echo e(session('currency')['code'], false); ?>">
                <input type="hidden" id="__symbol" value="<?php echo e(session('currency')['symbol'], false); ?>">
                <input type="hidden" id="__thousand" value="<?php echo e(session('currency')['thousand_separator'], false); ?>">
                <input type="hidden" id="__decimal" value="<?php echo e(session('currency')['decimal_separator'], false); ?>">
                <input type="hidden" id="__symbol_placement" value="<?php echo e(session('business.currency_symbol_placement'), false); ?>">
                <input type="hidden" id="__precision" value="<?php echo e(session('business.currency_precision', 2), false); ?>">
                <input type="hidden" id="__quantity_precision" value="<?php echo e(session('business.quantity_precision', 2), false); ?>">
                <!-- End of currency related field-->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_export_buttons')): ?>
                    <input type="hidden" id="view_export_buttons">
                <?php endif; ?>
                <?php if(isMobile()): ?>
                    <input type="hidden" id="__is_mobile">
                <?php endif; ?>
                <?php if(session('status')): ?>
                    <input type="hidden" id="status_span" data-status="<?php echo e(session('status.success'), false); ?>" data-msg="<?php echo e(session('status.msg'), false); ?>">
                <?php endif; ?>
                <?php echo $__env->yieldContent('content'); ?>

                <div class='scrolltop no-print'>
                    <div class='scroll icon'><i class="fas fa-angle-up"></i></div>
                </div>

                <?php if(config('constants.iraqi_selling_price_adjustment')): ?>
                    <input type="hidden" id="iraqi_selling_price_adjustment">
                <?php endif; ?>

                <!-- This will be printed -->
                <section class="invoice print_section" id="receipt_section">
                </section>
                
            </div>
            <?php echo $__env->make('home.todays_profit_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!-- /.content-wrapper -->

            <?php if(!$pos_layout): ?>
                <?php echo $__env->make('layouts.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php else: ?>
                <?php echo $__env->make('layouts.partials.footer_pos', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <audio id="success-audio">
              <source src="<?php echo e(asset('/audio/success.ogg?v=' . $asset_v), false); ?>" type="audio/ogg">
              <source src="<?php echo e(asset('/audio/success.mp3?v=' . $asset_v), false); ?>" type="audio/mpeg">
            </audio>
            <audio id="error-audio">
              <source src="<?php echo e(asset('/audio/error.ogg?v=' . $asset_v), false); ?>" type="audio/ogg">
              <source src="<?php echo e(asset('/audio/error.mp3?v=' . $asset_v), false); ?>" type="audio/mpeg">
            </audio>
            <audio id="warning-audio">
              <source src="<?php echo e(asset('/audio/warning.ogg?v=' . $asset_v), false); ?>" type="audio/ogg">
              <source src="<?php echo e(asset('/audio/warning.mp3?v=' . $asset_v), false); ?>" type="audio/mpeg">
            </audio>
        </div>

        <?php if(!empty($__additional_html)): ?>
            <?php echo $__additional_html; ?>

        <?php endif; ?>

        <?php echo $__env->make('layouts.partials.javascripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="modal fade view_modal" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel"></div>

        <?php if(!empty($__additional_views) && is_array($__additional_views)): ?>
            <?php $__currentLoopData = $__additional_views; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $additional_view): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if ($__env->exists($additional_view)) echo $__env->make($additional_view, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </body>

</html><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/layouts/app.blade.php ENDPATH**/ ?>