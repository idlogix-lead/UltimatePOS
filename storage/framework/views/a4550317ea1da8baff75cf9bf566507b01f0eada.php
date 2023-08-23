<section class="no-print">
    <nav class="navbar navbar-default bg-white m-4">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo e(action('\Modules\Manufacturing\Http\Controllers\RecipeController@index'), false); ?>"><i class="fas fa-industry"></i> <?php echo e(__('manufacturing::lang.manufacturing'), false); ?></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manufacturing.access_recipe')): ?>
                        <li <?php if(request()->segment(1) == 'manufacturing' && in_array(request()->segment(2), ['recipe', 'add-ingredient'])): ?> class="active" <?php endif; ?>><a href="<?php echo e(action('\Modules\Manufacturing\Http\Controllers\RecipeController@index'), false); ?>"><?php echo app('translator')->get('manufacturing::lang.recipe'); ?></a></li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manufacturing.access_production')): ?>
                        <li <?php if(request()->segment(2) == 'production'): ?> class="active" <?php endif; ?>><a href="<?php echo e(action('\Modules\Manufacturing\Http\Controllers\ProductionController@index'), false); ?>"><?php echo app('translator')->get('manufacturing::lang.production'); ?></a></li>

                        <li <?php if(request()->segment(1) == 'manufacturing' && request()->segment(2) == 'settings'): ?> class="active" <?php endif; ?>><a href="<?php echo e(action('\Modules\Manufacturing\Http\Controllers\SettingsController@index'), false); ?>"><?php echo app('translator')->get('messages.settings'); ?></a></li>

                        <li <?php if(request()->segment(2) == 'report'): ?> class="active" <?php endif; ?>><a href="<?php echo e(action('\Modules\Manufacturing\Http\Controllers\ProductionController@getManufacturingReport'), false); ?>"><?php echo app('translator')->get('manufacturing::lang.manufacturing_report'); ?></a></li>
                    <?php endif; ?>
                </ul>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</section><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\Modules\Manufacturing\Providers/../Resources/views/layouts/nav.blade.php ENDPATH**/ ?>