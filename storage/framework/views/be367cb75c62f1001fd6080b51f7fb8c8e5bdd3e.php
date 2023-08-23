<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css?v='.$asset_v), false); ?>">
    <?php echo $__env->make('layouts.partials.css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body>
    <?php echo $__env->yieldContent('content'); ?>
    
</body>
</html>
<?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/report/api/layout.blade.php ENDPATH**/ ?>