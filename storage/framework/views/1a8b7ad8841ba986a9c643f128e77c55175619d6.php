<?php $__env->startSection('title', __('lang_v1.login')); ?>

<?php $__env->startSection('content'); ?>
    <div class="login-form col-md-12 col-xs-12 right-col-content">
        <p class="form-header text-white"><?php echo app('translator')->get('lang_v1.login'); ?></p>
        <form method="POST" action="<?php echo e(route('login'), false); ?>" id="login-form">
            <?php echo e(csrf_field(), false); ?>

            <div class="form-group has-feedback <?php echo e($errors->has('username') ? ' has-error' : '', false); ?>">
                <?php
                    $username = old('username');
                    $password = null;
                    if(config('app.env') == 'demo'){
                        $username = 'admin';
                        $password = '123456';

                        $demo_types = array(
                            'all_in_one' => 'admin',
                            'super_market' => 'admin',
                            'pharmacy' => 'admin-pharmacy',
                            'electronics' => 'admin-electronics',
                            'services' => 'admin-services',
                            'restaurant' => 'admin-restaurant',
                            'superadmin' => 'superadmin',
                            'woocommerce' => 'woocommerce_user',
                            'essentials' => 'admin-essentials',
                            'manufacturing' => 'manufacturer-demo',
                        );

                        if( !empty($_GET['demo_type']) && array_key_exists($_GET['demo_type'], $demo_types) ){
                            $username = $demo_types[$_GET['demo_type']];
                        }
                    }
                ?>
                <input id="username" type="text" class="form-control" name="username" value="<?php echo e($username, false); ?>" required autofocus placeholder="<?php echo app('translator')->get('lang_v1.username'); ?>">
                <span class="fa fa-user form-control-feedback"></span>
                <?php if($errors->has('username')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('username'), false); ?></strong>
                    </span>
                <?php endif; ?>
            </div>
            <div class="form-group has-feedback <?php echo e($errors->has('password') ? ' has-error' : '', false); ?>">
                <input id="password" type="password" class="form-control" name="password"
                value="<?php echo e($password, false); ?>" required placeholder="<?php echo app('translator')->get('lang_v1.password'); ?>">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <?php if($errors->has('password')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('password'), false); ?></strong>
                    </span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : '', false); ?>> <?php echo app('translator')->get('lang_v1.remember_me'); ?>
                    </label>
                </div>
            </div>
            <br>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-flat btn-login"><?php echo app('translator')->get('lang_v1.login'); ?></button>
                <?php if(config('app.env') != 'demo'): ?>
                <a href="<?php echo e(route('password.request'), false); ?>" class="pull-right">
                    <?php echo app('translator')->get('lang_v1.forgot_your_password'); ?>
                </a>
            <?php endif; ?>
            </div>
        </form>
    </div>
    <?php if(config('app.env') == 'demo'): ?>
    <div class="col-md-12 col-xs-12" style="padding-bottom: 30px;">
        <?php $__env->startComponent('components.widget', ['class' => 'box-primary', 'header' => '<h4 class="text-center">Demo Shops <small><i> Demos are for example purpose only, this application <u>can be used in many other similar businesses.</u></i></small></h4>']); ?>

            <a href="?demo_type=all_in_one" class="btn btn-app bg-olive demo-login" data-toggle="tooltip" title="Showcases all feature available in the application." data-admin="<?php echo e($demo_types['all_in_one'], false); ?>"> <i class="fas fa-star"></i> All In One</a>

            <a href="?demo_type=pharmacy" class="btn bg-maroon btn-app demo-login" data-toggle="tooltip" title="Shops with products having expiry dates." data-admin="<?php echo e($demo_types['pharmacy'], false); ?>"><i class="fas fa-medkit"></i>Pharmacy</a>

            <a href="?demo_type=services" class="btn bg-orange btn-app demo-login" data-toggle="tooltip" title="For all service providers like Web Development, Restaurants, Repairing, Plumber, Salons, Beauty Parlors etc." data-admin="<?php echo e($demo_types['services'], false); ?>"><i class="fas fa-wrench"></i>Multi-Service Center</a>

            <a href="?demo_type=electronics" class="btn bg-purple btn-app demo-login" data-toggle="tooltip" title="Products having IMEI or Serial number code."  data-admin="<?php echo e($demo_types['electronics'], false); ?>" ><i class="fas fa-laptop"></i>Electronics & Mobile Shop</a>

            <a href="?demo_type=super_market" class="btn bg-navy btn-app demo-login" data-toggle="tooltip" title="Super market & Similar kind of shops." data-admin="<?php echo e($demo_types['super_market'], false); ?>" ><i class="fas fa-shopping-cart"></i> Super Market</a>

            <a href="?demo_type=restaurant" class="btn bg-red btn-app demo-login" data-toggle="tooltip" title="Restaurants, Salons and other similar kind of shops." data-admin="<?php echo e($demo_types['restaurant'], false); ?>"><i class="fas fa-utensils"></i> Restaurant</a>
            <hr>

            <i class="icon fas fa-plug"></i> Premium optional modules:<br><br>

            <a href="?demo_type=superadmin" class="btn bg-red-active btn-app demo-login" data-toggle="tooltip" title="SaaS & Superadmin extension Demo" data-admin="<?php echo e($demo_types['superadmin'], false); ?>"><i class="fas fa-university"></i> SaaS / Superadmin</a>

            <a href="?demo_type=woocommerce" class="btn bg-woocommerce btn-app demo-login" data-toggle="tooltip" title="WooCommerce demo user - Open web shop in minutes!!" style="color:white !important" data-admin="<?php echo e($demo_types['woocommerce'], false); ?>"> <i class="fab fa-wordpress"></i> WooCommerce</a>

            <a href="?demo_type=essentials" class="btn bg-navy btn-app demo-login" data-toggle="tooltip" title="Essentials & HRM (human resource management) Module Demo" style="color:white !important" data-admin="<?php echo e($demo_types['essentials'], false); ?>">
                    <i class="fas fa-check-circle"></i>
                    Essentials & HRM</a>
                    
            <a href="?demo_type=manufacturing" class="btn bg-orange btn-app demo-login" data-toggle="tooltip" title="Manufacturing module demo" style="color:white !important" data-admin="<?php echo e($demo_types['manufacturing'], false); ?>">
                    <i class="fas fa-industry"></i>
                    Manufacturing Module</a>

            <a href="?demo_type=superadmin" class="btn bg-maroon btn-app demo-login" data-toggle="tooltip" title="Project module demo" style="color:white !important" data-admin="<?php echo e($demo_types['superadmin'], false); ?>">
                    <i class="fas fa-project-diagram"></i>
                    Project Module</a>

            <a href="?demo_type=services" class="btn btn-app demo-login" data-toggle="tooltip" title="Advance repair module demo" style="color:white !important; background-color: #bc8f8f" data-admin="<?php echo e($demo_types['services'], false); ?>">
                    <i class="fas fa-wrench"></i>
                    Advance Repair Module</a>

            <a href="<?php echo e(url('docs'), false); ?>" target="_blank" class="btn btn-app" data-toggle="tooltip" title="Advance repair module demo" style="color:white !important; background-color: #2dce89">
                    <i class="fas fa-network-wired"></i>
                    Connector Module / API Documentation</a>
        <?php echo $__env->renderComponent(); ?>   
    </div>
    <?php endif; ?> 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#change_lang').change( function(){
            window.location = "<?php echo e(route('login'), false); ?>?lang=" + $(this).val();
        });

        $('a.demo-login').click( function (e) {
           e.preventDefault();
           $('#username').val($(this).data('admin'));
           $('#password').val("<?php echo e($password, false); ?>");
           $('form#login-form').submit();
        });
    })
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/auth/login.blade.php ENDPATH**/ ?>