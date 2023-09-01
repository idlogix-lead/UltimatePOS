<table class="table table-bordered table-striped" id="register_report_table">
    <thead>
        <tr>
            <th>@lang('report.open_time')</th>
            <th>@lang('report.close_time')</th>
            <th>@lang('sale.location')</th>
            <th>@lang('report.user')</th>
            <th>@lang('cash_register.total_card_slips')</th>
            <th>@lang('cash_register.total_cheques')</th>
            <th>@lang('cash_register.total_cash')</th>
            <th>@lang('lang_v1.total_bank_transfer')</th>
            <th>@lang('lang_v1.total_advance_payment')</th>
            @if(!isset($registers))
                <th>{{$payment_types['custom_pay_1']}}</th>
                <th>{{$payment_types['custom_pay_2']}}</th>
                <th>{{$payment_types['custom_pay_3']}}</th>
                <th>{{$payment_types['custom_pay_4']}}</th>
                <th>{{$payment_types['custom_pay_5']}}</th>
                <th>{{$payment_types['custom_pay_6']}}</th>
                <th>{{$payment_types['custom_pay_7']}}</th>
            @endif
            <th>@lang('cash_register.other_payments')</th>
            <th>@lang('sale.total')</th>
            @if(!isset($registers))<th>@lang('messages.action')</th>@endif
        </tr>
    </thead>
    @if(isset($registers))
        <tbody>
            @php
                $footer_total_card_payment = 0;
                $footer_total_cheque_payment = 0;
                $footer_total_cash_payment = 0;
                $footer_total_bank_transfer_payment = 0;
                $footer_total_advance_payment = 0;
                $footer_total_other_payments = 0;
                $footer_total = 0;
            @endphp
            @foreach ($registers as $row)
                @php
                    $footer_total_card_payment+= $row->total_card_payment;
                    $footer_total_cheque_payment += $row->total_cheque_payment;
                    $footer_total_cash_payment += $row->total_cash_payment;
                    $footer_total_bank_transfer_payment += $row->total_bank_transfer_payment;
                    $footer_total_advance_payment += $row->total_advance_payment;
                    $footer_total_other_payments += $row->total_other_payment;
                    $total = $row->total_card_payment + $row->total_cheque_payment + $row->total_cash_payment + $row->total_bank_transfer_payment + $row->total_other_payment + $row->total_advance_payment + $row->total_custom_pay_1 + $row->total_custom_pay_2 + $row->total_custom_pay_3 + $row->total_custom_pay_4 + $row->total_custom_pay_5 + $row->total_custom_pay_6 + $row->total_custom_pay_7;
                    $footer_total += $total;
                @endphp 
                <tr>
                    <td>{{date($date_format." h:i A",strtotime($row->created_at))}}</td>
                    <td>{{date($date_format." h:i A",strtotime($row->closed_at))}}</td>
                    <td> {{$row->location_name}} </td>
                    <td> {!!$row->user_name!!} </td>
                    <td> 
                        {{$symbol}}.{{round($row->total_card_payment,2)}} ({{$row->total_card_slips}}) 
                    </td>
                    <td> {{$symbol}}.{{round($row->total_cheque_payment,2)}} ({{$row->total_cheques}}) </td>
                    <td> {{$symbol}}.{{round($row->total_cash_payment,2)}} </td>
                    <td> {{$symbol}}.{{round($row->total_bank_transfer_payment,2)}} </td>
                    <td> {{$symbol}}.{{round($row->total_advance_payment,2)}} </td>
                    {{-- <td> {{$row->total_custom_pay_1}} </td>
                    <td> {{$row->total_custom_pay_2}} </td>
                    <td> {{$row->total_custom_pay_3}} </td>
                    <td> {{$row->total_custom_pay_4}} </td>
                    <td> {{$row->total_custom_pay_5}} </td>
                    <td> {{$row->total_custom_pay_6}} </td>
                    <td> {{$row->total_custom_pay_7}} </td> --}}
                    <td> {{$symbol}}.{{round($row->total_other_payment,2)}} </td>
                    <td> {{$symbol}}.{{round($total,2)}} </td>
                </tr>
            @endforeach
        </tbody>
    @endif
    <tfoot>
        @if(!isset($registers))
            <tr class="bg-gray font-17 text-center footer-total">
                <td colspan="4"><strong>@lang('sale.total'):</strong></td>
                <td class="footer_total_card_payment"></td>
                <td class="footer_total_cheque_payment"></td>
                <td class="footer_total_cash_payment"></td>
                <td class="footer_total_bank_transfer_payment"></td>
                <td class="footer_total_advance_payment"></td>
                <td class="footer_total_custom_pay_1"></td>
                <td class="footer_total_custom_pay_2"></td>
                <td class="footer_total_custom_pay_3"></td>
                <td class="footer_total_custom_pay_4"></td>
                <td class="footer_total_custom_pay_5"></td>
                <td class="footer_total_custom_pay_6"></td>
                <td class="footer_total_custom_pay_7"></td>
                <td class="footer_total_other_payments"></td>
                <td class="footer_total"></td>
                <td></td>
            </tr>
        @else
            <tr class="bg-gray font-17 text-center footer-total">
                <td colspan="4"><strong>@lang('sale.total'):</strong></td>
                <td class="footer_total_card_payment">{{$symbol}}.{{round($footer_total_card_payment,2)}}</td>
                <td class="footer_total_cheque_payment">{{$symbol}}.{{round($footer_total_cheque_payment,2)}}</td>
                <td class="footer_total_cash_payment">{{$symbol}}.{{round($footer_total_cash_payment,2)}}</td>
                <td class="footer_total_bank_transfer_payment">{{$symbol}}.{{round($footer_total_bank_transfer_payment,2)}}</td>
                <td class="footer_total_advance_payment">{{$symbol}}.{{round($footer_total_advance_payment,2)}}</td>
                <td class="footer_total_other_payments">{{$symbol}}.{{round($footer_total_other_payments,2)}}</td>
                <td class="footer_total">{{$symbol}}.{{round($footer_total,2)}}</td>
            </tr>
        @endif
    </tfoot>
</table>