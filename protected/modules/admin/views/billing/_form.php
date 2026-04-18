<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$form = ActiveForm::begin(['id' => 'billing-form']);
?>

<div class="model-form widgets button_margin">
    <h1 class="widgets_title">Billing / Create Order</h1>
    <div class="widgets_content common_form event_form">
        <div class="_2divs">
            <?= $form->field($model, 'customer_name')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'date')->textInput(['type' => 'date']) ?>
        </div>
        <div class="_2divs">
            <?= $form->field($model, 'payment_method')->dropDownList([
                'cash' => 'Cash',
                'card' => 'Card',
                'upi' => 'UPI'
            ], ['prompt' => 'Select Payment']) ?>
            <?= $form->field($model, 'phone')->textInput(['maxlength' => 20]) ?>
        </div>
        <div class="_2divs">
            <?= $form->field($model, 'id_proof')->dropDownList([
                'aadhar' => 'Aadhar',
                'dl' => 'Driving Licence',
                'pan' => 'PAN'
            ], ['prompt' => 'Select Any Id proof']) ?>
            <?= $form->field($model, 'id_proof_number')->textInput(['maxlength' => 255]) ?>
        </div>
        <div class="_2divs">
            <?= $form->field($model, 'whatsapp')->textInput(['maxlength' => 20]) ?>
            <?= $form->field($model, 'address')->textarea(['rows' => 4]) ?>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <h3>Items</h3>
                <table id="items-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Product Name</th>
                            <th>MRP Price (Rs)</th>
                            <th>Price (Rs)</th>
                            <th>Quantity</th>
                            <th>Discount (%)</th>
                            <th>Discount Price (Rs)</th>
                            <th>Total (Rs)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="item-row">
                            <td class="sno">1</td>
                            <td style="min-width:220px;">
                                <select class="product-select form-control" style="width:100%"></select>
                                <input type="hidden" class="product-id" />
                            </td>
                            <td><input type="text" class="form-control mrp" readonly /></td>
                            <td><input type="number" step="0.01" class="form-control price" /></td>
                            <td><input type="number" class="form-control qty" value="1" min="0" /></td>
                            <td><input type="number" class="form-control discount" value="0" min="0" /></td>
                            <td><input type="text" class="form-control discount-price" readonly /></td>
                            <td><input type="text" class="form-control total-price" readonly /></td>
                            <td><button type="button" class="btn btn-danger btn-sm remove-row">Del</button></td>
                        </tr>
                    </tbody>
                </table>



                <div class="_4divs" style="margin-top:20px;">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="button" id="add-item" class="btn btn-success" style="width:100%">+ Add Item</button>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Total Quantity :</label>
                        <input type="text" id="total-quantity" class="form-control" readonly />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Total Amount (Rs) :</label>
                        <input type="text" id="total-amount" class="form-control" readonly />
                    </div>
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <?= Html::activeHiddenInput($model, 'final_total', ['id' => 'final-total']) ?>
                        <?= Html::button('Submit', ['id' => 'billing-submit', 'class' => 'btn btn-primary', 'style' => 'width:100%']) ?>
                    </div>
                </div>

                <!-- Packing & Roundoff -->
                <div class="_4divs" style="margin-top:15px;">
                    <div class="form-group">
                        <label class="control-label">Packing Charge (%) :</label>
                        <?= Html::textInput('packing_percent', 0, ['class' => 'form-control', 'id' => 'packing-percent']) ?>
                        <?= Html::activeHiddenInput($model, 'packing_charge', ['id' => 'billingform-packing_charge']) ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Charge (Rs) :</label>
                        <input type="text" id="packing-charge" class="form-control" readonly />
                    </div>
                    <div class="form-group">
                        <label class="control-label">RoundOff Amount (Rs) :</label>
                        <input type="text" id="roundoff-amount" class="form-control" readonly />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php ActiveForm::end(); ?>

<?php
$productSearchUrl = Url::to(['billing/product-search']);
$ajaxSaveUrl = Url::to(['billing/ajax-save']);
$orderIndexUrl = Url::to(['order/index']);

$js = <<<'JS'
function recalcRow($row){
    var price = parseFloat($row.find('.price').val()) || 0;
    var qty = parseFloat($row.find('.qty').val()) || 0;
    var discount = parseFloat($row.find('.discount').val()) || 0;
    var discountPrice = price * (discount/100);
    var total = qty * (price - discountPrice);
    $row.find('.discount-price').val(discountPrice.toFixed(2));
    $row.find('.total-price').val(total.toFixed(2));
    recalcTotals();
}

function recalcTotals(){
    var totalQty = 0; var totalAmount = 0;
    $('#items-table tbody tr.item-row').each(function(i,el){
        var $r = $(el);
        var q = parseFloat($r.find('.qty').val()) || 0;
        var t = parseFloat($r.find('.total-price').val()) || 0;
        totalQty += q; totalAmount += t;
        $r.find('.sno').text(i+1);
    });
    $('#total-quantity').val(totalQty);
    $('#total-amount').val(totalAmount.toFixed(2));
    // compute packing charge and roundoff
    var percent = parseFloat($('#packing-percent').val()) || parseFloat($('#billingform-packing_charge').val()) || 0;
    $('#billingform-packing_charge').val(percent);
    var packingCharge = totalAmount * (percent/100);
    $('#packing-charge').val(packingCharge.toFixed(2));
    var finalSum = totalAmount + packingCharge;
    var rounded = Math.round(finalSum);
    $('#final-total').val(rounded.toFixed(2));
    $('#roundoff-amount').val(rounded.toFixed(2));
}

function makeSelect2($sel){
    $sel.select2({
        ajax: {
            url: '{PRODUCT_URL}',
            dataType: 'json',
            delay: 250,
            data: function(params){ return {q: params.term}; },
            processResults: function(data){ return data; }
        },
        placeholder: 'Search product...',
        minimumInputLength: 1,
        width: 'resolve'
    });
    $sel.on('select2:select', function(e){
        var data = e.params.data;
        var $row = $(this).closest('tr');
        $row.find('.product-id').val(data.id);
        $row.find('.mrp').val(data.mrp);
        $row.find('.price').val(data.price);
        $row.find('.discount').val(data.discount || 0);
        recalcRow($row);
    });
}

// initialize on DOM ready (ensure Select2 is present)
$(function(){
    makeSelect2($('.product-select'));
    recalcTotals();
});

// add item
$('#add-item').on('click', function(){
    var rowHtml = '<tr class="item-row">' +
        '<td class="sno"></td>' +
        '<td style="min-width:220px;">' +
        '<select class="product-select form-control" style="width:100%"></select>' +
        '<input type="hidden" class="product-id" />' +
        '</td>' +
        '<td><input type="text" class="form-control mrp" readonly /></td>' +
        '<td><input type="number" step="0.01" class="form-control price" /></td>' +
        '<td><input type="number" class="form-control qty" value="1" min="0" /></td>' +
        '<td><input type="number" class="form-control discount" value="0" min="0" /></td>' +
        '<td><input type="text" class="form-control discount-price" readonly /></td>' +
        '<td><input type="text" class="form-control total-price" readonly /></td>' +
        '<td><button type="button" class="btn btn-danger btn-sm remove-row">Del</button></td>' +
        '</tr>';

    var $row = $(rowHtml);
    $('#items-table tbody').append($row);
    makeSelect2($row.find('.product-select'));
    recalcTotals();
});

// remove
$(document).on('click', '.remove-row', function(){
    if ($('#items-table tbody tr.item-row').length <= 1) {
        var $r = $(this).closest('tr');
        $r.find('input').val('');
        $r.find('.qty').val(1);
        recalcRow($r);
        return;
    }
    $(this).closest('tr').remove();
    recalcTotals();
});

// recalc on change
$(document).on('input change', '#items-table .price, #items-table .qty, #items-table .discount', function(){
    var $r = $(this).closest('tr');
    recalcRow($r);
});

// recalc when packing percent changes
$(document).on('input change', '#packing-percent', function(){
    recalcTotals();
});

// submit via ajax
$('#billing-submit').on('click', function(){
    var data = {};
    data.customer_name = $('#order-customer_name').val();
    data.phone = $('#order-phone').val();
    data.whatsapp = $('#order-whatsapp').val();
    data.address = $('#order-address').val();
    data.date = $('#order-date').val();
    data.id_proof = $('#order-id_proof').val();
    data.id_proof_number = $('#order-id_proof_number').val();
    data.payment_method = $('#order-payment_method').val();
    data.final_total = $('#final-total').val();

    var items = [];
    $('#items-table tbody tr.item-row').each(function(){
        var $r = $(this);
        var pid = $r.find('.product-id').val();
        var $ps = $r.find('.product-select');
        var selData = [];
        try { selData = $ps.select2 ? $ps.select2('data') : []; } catch(e) { selData = []; }
        var pname = (selData && selData.length) ? selData[0].text : ($ps.find('option:selected').text() || '');
        var mrp = parseFloat($r.find('.mrp').val()) || 0;
        var price = parseFloat($r.find('.price').val()) || 0;
        var qty = parseFloat($r.find('.qty').val()) || 0;
        var discount = parseFloat($r.find('.discount').val()) || 0;
        var discountPrice = parseFloat($r.find('.discount-price').val()) || 0;
        var totalPrice = parseFloat($r.find('.total-price').val()) || 0;
        if ((pid && pid.length) || pname.length) {
            items.push({
                product_id: pid,
                product_name: pname,
                mrp: mrp,
                price: price,
                quantity: qty,
                discount: discount,
                discount_price: discountPrice,
                total_price: totalPrice
            });
        }
    });

    data.items = JSON.stringify(items);

    // client-side required validation for all visible fields
    if (!data.customer_name || !data.customer_name.trim()) {
        alert('Customer name is required');
        $('#order-customer_name').focus();
        return;
    }
    if (!data.date || !data.date.trim()) {
        alert('Date is required');
        $('#order-date').focus();
        return;
    }
    if (!data.payment_method || !data.payment_method.trim()) {
        alert('Payment method is required');
        $('#order-payment_method').focus();
        return;
    }
    if (!data.phone || !data.phone.trim()) {
        alert('Phone is required');
        $('#order-phone').focus();
        return;
    }
    if (!data.id_proof || !data.id_proof.trim()) {
        alert('ID proof selection is required');
        $('#order-id_proof').focus();
        return;
    }
    if (!data.id_proof_number || !data.id_proof_number.trim()) {
        alert('ID proof number is required');
        $('#order-id_proof_number').focus();
        return;
    }
    if (!data.whatsapp || !data.whatsapp.trim()) {
        alert('Whatsapp number is required');
        $('#order-whatsapp').focus();
        return;
    }
    if (!data.address || !data.address.trim()) {
        alert('Address is required');
        $('#order-address').focus();
        return;
    }
    // ensure items exist
    if (!items || items.length === 0) {
        alert('Please add at least one item');
        return;
    }

    $.post('{AJAX_URL}', data, function(resp){
        if (resp && resp.status && resp.status == 200) {
            alert('Order created successfully. ID: ' + resp.id);
            // window.location = '{ORDER_INDEX}';
        } else {
            var msg = resp && resp.message ? resp.message : 'Unknown error';
            if (resp && resp.errors) {
                // show first validation error
                var first = Object.keys(resp.errors)[0];
                msg += '\n' + first + ': ' + resp.errors[first].join(', ');
            }
            alert('Save failed: ' + msg);
        }
    }, 'json').fail(function(){
        alert('Server error while saving order.');
    });
});
JS;

$js = strtr($js, [
    '{PRODUCT_URL}' => $productSearchUrl,
    '{AJAX_URL}' => $ajaxSaveUrl,
    '{ORDER_INDEX}' => $orderIndexUrl,
]);

$this->registerJs($js);

?>