<div class="table-responsive">
    <table class="table table-bordered table-striped table-text-center" id="profit_by_day_table">
        <thead>
            <tr>
                <th>@lang('lang_v1.days')</th>
                <th>@lang('lang_v1.gross_profit')</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
            @endphp
            @foreach($days as $day)
                <tr>
                    <td>@lang('lang_v1.' . $day)</td>
                    <td><span class="gross-profit" data-orig-value="{{$profits[$day] ?? 0}}">{{isset($profits[$day])?round(intval(strip_tags($profits[$day])),2):0}}</span></td>
                </tr>
                @php
                    $total += $profits[$day] ?? 0;
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-gray font-17 footer-total">
                <td><strong>@lang('sale.total'):</strong></td>
                <td><span class="display_currency footer_total" data-currency_symbol ="true">{{isset($total)?round(intval($total),2):null}}</span></td>
            </tr>
        </tfoot>
    </table>
</div>