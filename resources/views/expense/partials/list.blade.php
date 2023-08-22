<table class="table table-bordered table-striped" id="expense_table">
    <thead>
        <tr>
            @if(!isset($expenses))<th>@lang('messages.action')</th>@endif
            <th>@lang('messages.date')</th>
            <th>@lang('purchase.ref_no')</th>
            <th>@lang('lang_v1.recur_details')</th>
            <th>@lang('expense.expense_category')</th>
            <th>@lang('product.sub_category')</th>
            <th>@lang('business.location')</th>
            <th>@lang('sale.payment_status')</th>
            <th>@lang('product.tax')</th>
            <th>@lang('sale.total_amount')</th>
            <th>@lang('purchase.payment_due')
            <th>@lang('expense.expense_for')</th>
            <th>@lang('contact.contact')</th>
            <th>@lang('expense.expense_note')</th>
            <th>@lang('lang_v1.added_by')</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total_due = 0;
            $total_amount = 0;

            $paid_status = 0;
            $due_status = 0;
            $partial_status = 0;
        @endphp
        @if (isset($expenses))
            @foreach ($expenses as $row)
                <tr>
                    <td>{{date($format,strtotime($row->transaction_date))}}</td>
                    <td>
                        @php
                            $ref_no = $row->ref_no;
                            if (! empty($row->is_recurring)) {
                                $ref_no .= ' &nbsp;<small class="label bg-red label-round no-print" title="'.__('lang_v1.recurring_expense').'"><i class="fas fa-recycle"></i></small>';
                            }

                            if (! empty($row->recur_parent_id)) {
                                $ref_no .= ' &nbsp;<small class="label bg-info label-round no-print" title="'.__('lang_v1.generated_recurring_expense').'"><i class="fas fa-recycle"></i></small>';
                            }

                            if ($row->type == 'expense_refund') {
                                $ref_no .= ' &nbsp;<small class="label bg-gray">'.__('lang_v1.refund').'</small>';
                            }

                            echo $ref_no;
                        @endphp    
                    </td>
                    <td>
                        @php
                            $details = '<small>';
                            if ($row->is_recurring == 1) {
                                $type = $row->recur_interval == 1 ? Str::singular(__('lang_v1.'.$row->recur_interval_type)) : __('lang_v1.'.$row->recur_interval_type);
                                $recur_interval = $row->recur_interval.$type;

                                $details .= __('lang_v1.recur_interval').': '.$recur_interval;
                                if (! empty($row->recur_repetitions)) {
                                    $details .= ', '.__('lang_v1.no_of_repetitions').': '.$row->recur_repetitions;
                                }
                                if ($row->recur_interval_type == 'months' && ! empty($row->subscription_repeat_on)) {
                                    $details .= '<br><small class="text-muted">'.
                                    __('lang_v1.repeat_on').': '.str_ordinal($row->subscription_repeat_on);
                                }
                            } elseif (! empty($row->recur_parent_id)) {
                                $details .= __('lang_v1.recurred_from').': '.$row->recurring_parent->ref_no;
                            }
                            $details .= '</small>';

                            echo $details;
                        @endphp
                    </td>
                    <td>{{$row->category}}</td>
                    <td>{{$row->sub_category}}</td>
                    <td>{{$row->location_name}}</td>
                    <td>
                        {{$row->payment_status}}
                        @php
                            if($row->payment_status == "paid"){
                                $paid_status++;
                            }elseif($row->payment_status == "due"){
                                $due_status++;
                            }elseif($row->payment_status == "partial"){
                                $partial_status++;
                            }
                        @endphp
                    </td>
                    <td>{{$row->tax}}</td>
                    <td>
                        @php
                            $final_total = $row->final_total;
                            if($row->type=="expense_refund"){
                                $final_total*=-1;
                            }
                            $total_amount+=$final_total;
                        @endphp
                        <span class="display_currency final-total" data-currency_symbol="true" >
                            {{$symbol.". ". round($final_total,2)}}
                        </span>
                    </td>
                    <td>
                        @php
                            $due = $row->final_total - $row->amount_paid;

                            if ($row->type == 'expense_refund') {
                                $due = -1 * $due;
                            }
                            $total_due+=$due;
                            echo '<span class="display_currency payment_due" data-currency_symbol="true">'.$symbol.". ".round($due, 2).'</span>';
                        @endphp
                    </td>
                    <td>{{$row->expense_for}}</td>
                    <td>{{$row->contact_name}}</td>
                    <td>{{$row->additional_notes}}</td>
                    <td>{{$row->added_by}}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr class="bg-gray font-17 text-center footer-total">
            <td colspan="6"><strong>@lang('sale.total'):</strong></td>
            <td class="footer_payment_status_count">
                @php
                    if($paid_status > 0){
                        echo "<span>Paid - ".$paid_status."</span>";
                    }
                    if($due_status > 0){
                        echo "<br><span>Due - ".$due_status."</span>";
                    }
                    if($partial_status > 0){
                        echo "<br><span>Partial - ".$partial_status."</span>";
                    }
                @endphp
            </td>
            <td></td>
            <td class="footer_expense_total">{{isset($expenses)?$symbol.". ".round($total_amount, 2):""}}</td>
            <td class="footer_total_due">{{isset($expenses)?$symbol.". ".round($total_due, 2):""}}</td>
            <td colspan="4"></td>
        </tr>
    </tfoot>
</table>