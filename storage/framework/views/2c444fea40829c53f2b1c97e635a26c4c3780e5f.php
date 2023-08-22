<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale(), false); ?>">
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token(), false); ?>">

    <title><?php echo $__env->yieldContent('title'); ?> - <?php echo e(config('app.name', 'POS'), false); ?></title> 

    <?php echo $__env->make('layouts.partials.css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <?php $request = app('Illuminate\Http\Request'); ?>
    <?php if(session('status') && session('status.success')): ?>
        <input type="hidden" id="status_span" data-status="<?php echo e(session('status.success'), false); ?>" data-msg="<?php echo e(session('status.msg'), false); ?>">
    <?php endif; ?>
    <div class="container-fluid">
        <div class="row eq-height-row">
            <div class="col-md-5 col-sm-5 hidden-xs left-col eq-height-col" >
                <div class="left-col-content login-header"> 
                    <div style="margin-top: 50%;">
                    <a href="/">
                    <?php if(file_exists(public_path('uploads/logo.png'))): ?>
                        <img src="/uploads/logo.png" class="img-rounded" alt="Logo" width="150">
                    <?php else: ?>
                       <?php echo e(config('app.name', 'ultimatePOS'), false); ?>

                    <?php endif; ?> 
                    </a>
                    <br/>
                    <?php if(!empty(config('constants.app_title'))): ?>
                        <small><?php echo e(config('constants.app_title'), false); ?></small>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12 right-col eq-height-col">
                <div class="row">
                <div class="col-md-3 col-xs-4" style="text-align: left;">
                    <select class="form-control input-sm" id="change_lang" style="margin: 10px;">
                    <?php $__currentLoopData = config('constants.langs'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key, false); ?>" 
                            <?php if( (empty(request()->lang) && config('app.locale') == $key) 
                            || request()->lang == $key): ?> 
                                selected 
                            <?php endif; ?>
                        >
                            <?php echo e($val['full_name'], false); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-9 col-xs-8" style="text-align: right;padding-top: 10px;">
                    <?php if(!($request->segment(1) == 'business' && $request->segment(2) == 'register')): ?>
                        <!-- Register Url -->
                        <?php if(config('constants.allow_registration')): ?>
                            <a href="<?php echo e(route('business.getRegister'), false); ?><?php if(!empty(request()->lang)): ?><?php echo e('?lang=' . request()->lang, false); ?> <?php endif; ?>" class="btn bg-maroon btn-flat" ><b><?php echo e(__('business.not_yet_registered'), false); ?></b> <?php echo e(__('business.register_now'), false); ?></a>
                            <!-- pricing url -->
                            <?php if(Route::has('pricing') && config('app.env') != 'demo' && $request->segment(1) != 'pricing'): ?>
                                &nbsp; <a href="<?php echo e(action([\Modules\Superadmin\Http\Controllers\PricingController::class, 'index']), false); ?>"><?php echo app('translator')->get('superadmin::lang.pricing'); ?></a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if($request->segment(1) != 'login'): ?>
                        &nbsp; &nbsp;<span class="text-white"><?php echo e(__('business.already_registered'), false); ?> </span><a href="<?php echo e(action([\App\Http\Controllers\Auth\LoginController::class, 'login']), false); ?><?php if(!empty(request()->lang)): ?><?php echo e('?lang=' . request()->lang, false); ?> <?php endif; ?>"><?php echo e(__('business.sign_in'), false); ?></a>
                    <?php endif; ?>
                </div>
                
                <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
        </div>
    </div>

    
    <?php echo $__env->make('layouts.partials.javascripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <!-- Scripts -->
    <script src="<?php echo e(asset('js/login.js?v=' . $asset_v), false); ?>"></script>
    
    <?php echo $__env->yieldContent('javascript'); ?>

    <script type="text/javascript">
        $(document).ready(function(){
            $('.select2_register').select2();

            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

</html><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/layouts/auth2.blade.php ENDPATH**/ ?>