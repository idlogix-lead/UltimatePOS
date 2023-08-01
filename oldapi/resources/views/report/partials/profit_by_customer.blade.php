<div class="table-responsive">
    <table class="table table-bordered table-striped table-text-center" id="profit_by_customer_table">
        <thead>
            <tr>
                <th>@lang('contact.customer')</th>
                <th>@lang('lang_v1.gross_profit')</th>
            </tr>
        </thead>
        {{-- api report section added haris --}}
        @if(isset($profit))
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach($profit as $record)
                    <tr>
                        <td>
                            {{$record->customer}}
                        </td>
                        <td>
                            {{ round(intval(strip_tags($record->gross_profit)),2) }}
                            @php
                                $total += intval(strip_tags($record->gross_profit));
                            @endphp
                        </td>
                    </tr>
                @endforeach
            </tbody>
        @endif
        <tfoot>
            <tr class="bg-gray font-17 footer-total">
                <td><strong>@lang('sale.total'):</strong></td>
                <td><span class="display_currency footer_total" data-currency_symbol ="true">{{isset($total)?$total:null}}</span></td>
            </tr>
        </tfoot>
    </table>
</div>