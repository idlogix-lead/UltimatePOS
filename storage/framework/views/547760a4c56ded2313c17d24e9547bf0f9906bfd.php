

<?php $__env->startSection('content'); ?>
    
    <style>
        .cus_print{
            width:100%;
            overflow-x: hidden;
            padding-top:0px;
            padding-bottom:0px;
            margin:0px;
        }
        table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_desc_disabled:after{
            display:none;
        }
        .table  th {
            background-color: #3c8dbc !important;
            border-color: #3c8dbc!important;
            color:white !important;
        }
        .table_heading{
            background-color:#000080 !important;
            color:white !important;
            width:30%;
            margin-bottom:0px;
            padding:5px;
        }
        .dt-buttons{
            display:none;
        }
        .cus_print table{
            width:100% !important;
        }
        .dataTables_info{
            display:none;
        }
        .contetnt{
            padding:0px;
        }
        .table .profit td span{
            font-weight: bold;
            color: white !important;
        }
        .table .profit td,.table .profit td {
            background-color: #424242 !important;
            border:0px solid  #424242 !important;
            color: white !important;
            padding: 5px;
        }
        
        .table td{
            width:30%;
        }
        .currency{
            text-align:right;
        }
    </style>
    <?php
        global $total_revenue,$total_cost,$total_expense ;
        $total_revenue =0;
        $total_cost = 0;
        $total_expense = 0;
    ?>
    <div class="row">
        <div class="col-md-12">
            <?php echo $__env->make('report.custom.partials.sell', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php echo $__env->make('report.custom.partials.expense', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php echo $__env->make('report.custom.partials.netprofit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
   
<?php echo $__env->make('report.api.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/report/custom/api/profit_loss.blade.php ENDPATH**/ ?>