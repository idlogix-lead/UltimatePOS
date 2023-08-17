<div class="table-responsive cus_print">
    <h2 class="table_heading">Cost of Sales</h2>
    <table class="table table-bordered table-striped " id="cost_table_custom">
        <thead>
            {{-- <tr >
                <th   class="table_heading">Cost of Sales</th>
                
            </tr> --}}
            <tr>
                <th>Category</th>
                <th>@lang('product.sub_category')</th>
                <th>Amount</th>
            </tr>
        </thead>
        @if(isset($expenses))
            <tbody>
                @php
                    global $total_cost;
                @endphp
                @foreach ($expenses as $item)
                    @if($item["category"] == "Material Consumed")
                        <tr>
                            <td>{{$item["category"]}}</td>
                            <td>{{$item["sub_category"]}}</td>
                            <td>{{isset($symbol)?$symbol:""}}. {{round($item["total_expense"],2)}}</td>
                        </tr>
                        @php
                            $total_cost += $item["total_expense"];
                        @endphp
                    @endif
                @endforeach
            </tbody>
        @endif
        <tfoot>
            <tr class="bg-gray font-17 footer-total">
                <td></td>
                <td><strong>@lang('sale.total'):</strong></td>
                <td class="cost_total">{{isset($symbol)?$symbol.". ".round($total_cost,2):""}}</td>
            </tr>
        </tfoot>
    </table>

</div>

<div class="table-responsive cus_print">
    <table class="table table-bordered table-striped" id="custom_gross_profit_table">
        <tfoot>
            <tr class="bg-gray profit font-14 footer-total">
                <td><span>{{ __('lang_v1.gross_profit') }} (Sales Total - Cost of Sales Total):</span></td>
                <td class="gross_profit currency">{{isset($symbol)?$symbol.". ".(round($total_revenue,2)-round($total_cost,2)):""}}</td>
            </tr>
        </tfoot>
    </table>

</div>

<div class="table-responsive cus_print">
    <h2 class="table_heading">Expenses</h2> 
    <table class="table table-bordered table-striped mt-0" id="expense_table_custom">
        <thead>
            <tr>
                <th>Category</th>
                <th>@lang('product.sub_category')</th>
                <th>Amount</th>
            </tr>
        </thead>
        @if(isset($expenses))
            <tbody>
                @php
                    global $total_expense;
                @endphp
                @foreach ($expenses as $item)
                    @if($item["category"] != "Material Consumed")
                        <tr>
                            <td>{{$item["category"]}}</td>
                            <td>{{$item["sub_category"]}}</td>
                            <td>{{isset($symbol)?$symbol:""}}. {{round($item["total_expense"],2)}}</td>
                        </tr>
                        @php
                            $total_expense += $item["total_expense"];
                        @endphp
                    @endif
                @endforeach
            </tbody>
        @endif
        <tfoot>
            <tr class="bg-gray font-17 footer-total">
                <td></td>
                <td><strong>@lang('sale.total'):</strong></td>
                <td class="expense_total">{{isset($symbol)?$symbol.". ".round($total_expense,2):""}}</td>
            </tr>
        </tfoot>
    </table>

</div>
