@extends('layouts.app')
@section('title', __( 'report.profit_loss' ))

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'report.profit_loss' )
    </h1>
</section>
<style>
    @media  print {
        .cus_print{
            background-color:green;
            width:100%;
            overflow-x: hidden;
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
    }
    .currency{
        text-align:right;
    }
</style>
<!-- Main content -->
<section class="content">
    <div class="print_section">
        <!-- <h2>{{session()->get('business.name')}} - @lang( 'report.profit_loss' )</h2> -->
        <div style="text-align:center;">
            <h3><label for="">Business: </label>{{session()->get('business.name')}}</h3>
            <h4 ><label for="">Location: </label><span class="bus_loc"></span></h4>
            <h4>@lang( 'report.profit_loss' )</h4>
            <p ><label for="">Date Range: </label><span class="date_range_disp"></span></p>
        </div>
    </div>
    <div class="row no-print">
        <div class="col-md-3 col-md-offset-7 col-xs-6">
            <div class="input-group">
                <span class="input-group-addon bg-light-blue"><i class="fa fa-map-marker"></i></span>
                 <select class="form-control select2" id="profit_loss_location_filter">
                    @foreach($business_locations as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2 col-xs-6">
            <div class="form-group pull-right">
                <div class="input-group">
                  <button type="button" class="btn btn-primary" id="custom_profit_loss_date_filter">
                    <span>
                      <i class="fa fa-calendar"></i> {{ __('messages.filter_by_date') }}
                    </span>
                    <i class="fa fa-caret-down"></i>
                  </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row no-print">
        <div class="col-sm-12">
            <button type="button" class="btn btn-primary pull-right" 
            aria-label="Print" onclick="window.print();"
            ><i class="fa fa-print"></i> @lang( 'messages.print' )</button>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
        <!-- Custom Tabs -->
            @include('report.custom.partials.sell')
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            @include('report.custom.partials.expense')
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            @include('report.custom.partials.netprofit')
        </div>
    </div>

</section>
<!-- /.content -->
@stop
@section('javascript')
<script type="text/javascript">
     function updateCustomProfitLoss(){
        var req = {
            "start_date" : $('#custom_profit_loss_date_filter').data('daterangepicker').startDate.format('YYYY-MM-DD'),
            "end_date" : $('#custom_profit_loss_date_filter').data('daterangepicker').endDate.format('YYYY-MM-DD'),
            "location_id" : $('#profit_loss_location_filter').val()
        }
        var date_range = (req.start_date+" - "+req.end_date);
        var loc = $('#profit_loss_location_filter option:selected').text()
        $('.bus_loc').text(loc);
        $('.date_range_disp').text(date_range);

        $.post("{{route('getsalestotal.custom')}}",req,function(data){
            $('#expense_table_custom').dataTable().fnDestroy();
            $('#profit_by_products_table').dataTable().fnDestroy();
            table = $('#expense_table_custom').DataTable( {
                paging:false, 
                searching: false,
                data:data[1],
                columns: [
                    { data: 'category'},
                    { data: 'sub_category'},
                    { data: 'total_expense', className: "currency", render: $.fn.dataTable.render.number( ',', '.', 2, '{{auth()->user()->business->currency->symbol}} ')},
                ]
            });
            profit_by_products_table = $('#profit_by_products_table').DataTable({
                paging:false,
                searching: false,
                processing: true,
                serverSide: false,
                "ajax": {
                    "url": "/reports/custom/profitloss",
                    "data": function ( d ) {
                        d.start_date = $('#custom_profit_loss_date_filter')
                            .data('daterangepicker')
                            .startDate.format('YYYY-MM-DD');
                        d.end_date = $('#custom_profit_loss_date_filter')
                            .data('daterangepicker')
                            .endDate.format('YYYY-MM-DD');
                        d.location_id = $('#profit_loss_location_filter').val();
                    }
                },
                columns: [
                    { data: 'product'},
                    { data: 'total_sale', "searchable": false, className: "currency", render: $.fn.dataTable.render.number( ',', '.', 2, '{{auth()->user()->business->currency->symbol}} ')},
                ],
                footerCallback: function ( row, data, start, end, display ) {
                    var val = 0;
                    // console.log("Haris");
                    // console.log(data);
                    for (var r in data){
                        // console.log($(data[r].total_sale)[0]);
                        val += $(data[r].total_sale)[0] ? 
                        parseFloat($(data[r].total_sale)[0]) : 0;
                    }
                    $('.sell_total').html(__currency_trans_from_en(val));
                }
            });
            
            var total_expense = 0;
            $.each(data[1],function(key,value){
                total_expense += parseFloat(value.total_expense);
            })
            let total = (Math.round(data[0].total_sale* 100.00)/100.00);
            let net_profit = parseFloat(total) - total_expense;
            // console.log(net_profit);
            $('.net_total').html(__currency_trans_from_en(net_profit));
            // $('.expense_total').each(function(){
            //     this.html(__currency_trans_from_en(total_expense));
            // });
            $('.expense_total').html(__currency_trans_from_en(total_expense));
            // $('.sell_total').html(__currency_trans_from_en(total));
            
        });

     }
    

    $(document).ready( function() {
        $('#expense_table_custom').dataTable().on("search",function(){
            alert();
        })
        if ($('#custom_profit_loss_date_filter').length == 1) {
            $('#custom_profit_loss_date_filter').daterangepicker(dateRangeSettings, function(start, end) {
                $('#custom_profit_loss_date_filter span').html(
                    start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format)
                );
                updateCustomProfitLoss();
            });
            $('#custom_profit_loss_date_filter').on('cancel.daterangepicker', function(ev, picker) {
                $('#custom_profit_loss_date_filter').html(
                    '<i class="fa fa-calendar"></i> ' + LANG.filter_by_date
                );
            });
            updateCustomProfitLoss();
        }
        $('#profit_loss_location_filter').change(function() {
            updateCustomProfitLoss();
        });
        
        //for detailed sales
        
            
    });
</script>

@endsection
