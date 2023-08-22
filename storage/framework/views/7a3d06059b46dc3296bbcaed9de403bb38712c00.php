<table class="table table-bordered table-striped" id="expense_table">
    <thead>
        <tr>
            <?php if(!isset($expenses)): ?><th><?php echo app('translator')->get('messages.action'); ?></th><?php endif; ?>
            <th><?php echo app('translator')->get('messages.date'); ?></th>
            <th><?php echo app('translator')->get('purchase.ref_no'); ?></th>
            <th><?php echo app('translator')->get('lang_v1.recur_details'); ?></th>
            <th><?php echo app('translator')->get('expense.expense_category'); ?></th>
            <th><?php echo app('translator')->get('product.sub_category'); ?></th>
            <th><?php echo app('translator')->get('business.location'); ?></th>
            <th><?php echo app('translator')->get('sale.payment_status'); ?></th>
            <th><?php echo app('translator')->get('product.tax'); ?></th>
            <th><?php echo app('translator')->get('sale.total_amount'); ?></th>
            <th><?php echo app('translator')->get('purchase.payment_due'); ?>
            <th><?php echo app('translator')->get('expense.expense_for'); ?></th>
            <th><?php echo app('translator')->get('contact.contact'); ?></th>
            <th><?php echo app('translator')->get('expense.expense_note'); ?></th>
            <th><?php echo app('translator')->get('lang_v1.added_by'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
            $total_due = 0;
            $total_amount = 0;

            $paid_status = 0;
            $due_status = 0;
            $partial_status = 0;
        ?>
        <?php if(isset($expenses)): ?>
            <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e(date($format,strtotime($row->transaction_date)), false); ?></td>
                    <td>
                        <?php
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
                        ?>    
                    </td>
                    <td>
                        <?php
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
                        ?>
                    </td>
                    <td><?php echo e($row->category, false); ?></td>
                    <td><?php echo e($row->sub_category, false); ?></td>
                    <td><?php echo e($row->location_name, false); ?></td>
                    <td>
                        <?php echo e($row->payment_status, false); ?>

                        <?php
                            if($row->payment_status == "paid"){
                                $paid_status++;
                            }elseif($row->payment_status == "due"){
                                $due_status++;
                            }elseif($row->payment_status == "partial"){
                                $partial_status++;
                            }
                        ?>
                    </td>
                    <td><?php echo e($row->tax, false); ?></td>
                    <td>
                        <?php
                            $final_total = $row->final_total;
                            if($row->type=="expense_refund"){
                                $final_total*=-1;
                            }
                            $total_amount+=$final_total;
                        ?>
                        <span class="display_currency final-total" data-currency_symbol="true" >
                            <?php echo e($symbol.". ". round($final_total,2), false); ?>

                        </span>
                    </td>
                    <td>
                        <?php
                            $due = $row->final_total - $row->amount_paid;

                            if ($row->type == 'expense_refund') {
                                $due = -1 * $due;
                            }
                            $total_due+=$due;
                            echo '<span class="display_currency payment_due" data-currency_symbol="true">'.$symbol.". ".round($due, 2).'</span>';
                        ?>
                    </td>
                    <td><?php echo e($row->expense_for, false); ?></td>
                    <td><?php echo e($row->contact_name, false); ?></td>
                    <td><?php echo e($row->additional_notes, false); ?></td>
                    <td><?php echo e($row->added_by, false); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr class="bg-gray font-17 text-center footer-total">
            <td colspan="6"><strong><?php echo app('translator')->get('sale.total'); ?>:</strong></td>
            <td class="footer_payment_status_count">
                <?php
                    if($paid_status > 0){
                        echo "<span>Paid - ".$paid_status."</span>";
                    }
                    if($due_status > 0){
                        echo "<br><span>Due - ".$due_status."</span>";
                    }
                    if($partial_status > 0){
                        echo "<br><span>Partial - ".$partial_status."</span>";
                    }
                ?>
            </td>
            <td></td>
            <td class="footer_expense_total"><?php echo e(isset($expenses)?$symbol.". ".round($total_amount, 2):"", false); ?></td>
            <td class="footer_total_due"><?php echo e(isset($expenses)?$symbol.". ".round($total_due, 2):"", false); ?></td>
            <td colspan="4"></td>
        </tr>
    </tfoot>
</table><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/expense/partials/list.blade.php ENDPATH**/ ?>