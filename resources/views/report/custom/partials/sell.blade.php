<div class="table-responsive cus_print">
    <h2 class="table_heading">Revenue</h2> 
    <table class="table table-bordered table-striped" id="profit_by_products_table">
        <thead>
            {{-- <tr>
                <th class="table_heading">Revenue</th>
            </tr> --}}
           <tr>
                {{-- <th>@lang('sale.product')</th> --}}
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        @if(isset($revenue))
            @php
                global $total_revenue;
            @endphp
            <tbody>
                @foreach ($revenue as $item)
                    <tr>
                        <td>{{$item["product"]}}</td>
                        <td>{{isset($symbol)?$symbol:""}}. {{round($item["gross_profit"],2)}}</td>
                    </tr>
                    @php
                        $total_revenue += $item["gross_profit"];
                    @endphp
                @endforeach
            </tbody>
        @endif
        <tfoot>
            <tr class="bg-gray font-17 footer-total">
                <td><strong>@lang('sale.total'):</strong></td>
                <td class="sell_total">{{isset($symbol)?$symbol.". ".round($total_revenue,2):""}}</td>
            </tr>
        </tfoot>
    </table>

</div>