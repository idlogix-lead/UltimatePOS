<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
</head>
<body>
    <div style="width:100%;line-height: 1;">
        <!-- <div class="" style="text-align:right;">
            <span style="text-align:left;"></span>
            <span ></span>
        </div> -->
        <table style="width:100%;border:0px solid #ddd;">
            <tr>
                <td style="text-align:left;border:0px solid #ddd;"><label for="">Printed By: </label> <?php echo e($data["user"], false); ?></td>
                <td style="text-align:right;border:0px solid #ddd;"><label for="">Date Range: </label> 
                    <?php if(isset($data["start_date"]) && $data["end_date"]): ?>
                        <?php echo e(date($data["date_format"],strtotime($data["start_date"])), false); ?> - <?php echo e(date($data["date_format"],strtotime($data["end_date"])), false); ?>

                    <?php else: ?>
                        No Date Range Selected
                    <?php endif; ?>
                </td>
            </tr>
        </table>
        
        <div style="text-align:center;">
            <h2><label for="">Business: </label><?php echo e($data["name"], false); ?></h2>
            <h4><label for="">Location: </label><?php echo e($data["location"]["name"], false); ?>(<?php echo e($data["location"]["location_id"], false); ?>)</h4>
        </div>
    </div>
<?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/report/partials/api/header.blade.php ENDPATH**/ ?>