<div class="table-responsive">
    <table class="table table-bordered table-striped" id="netprofit">

        <tfoot>
            <tr class="bg-gray profit font-17 footer-total">
                <td><span>Total Discount:</span></td>
                <td class="discount_total currency">{{isset($symbol)?$symbol.". ".round($discount_total,2):""}}</td>
            </tr>
        </tfoot>
    </table>

</div>
<div class="table-responsive">
    <table class="table table-bordered table-striped" id="netprofit">

        <tfoot>
            <tr class="bg-gray profit font-17 footer-total">
                <td><span>{{ __('report.net_profit') }} ({{ __('lang_v1.gross_profit') }} - @lang('report.total_expense') - Total Discount):</span></td>
                <td class="net_total currency">{{isset($symbol)?$symbol.". ".round(($total_revenue-$total_cost-$total_expense-$discount_total-$production_cost),2):""}}</td>
            </tr>
        </tfoot>
    </table>

</div>