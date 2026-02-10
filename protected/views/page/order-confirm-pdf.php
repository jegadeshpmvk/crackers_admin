<?php

use yii\helpers\ArrayHelper;

/* ==============================
 * Currency Helper (DomPDF Safe)
 * ============================== */

function money($amount)
{
    return "&#8377; " . number_format((float)$amount, 2);
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Estimate PDF</title>

    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 13px;
            color: #000;
            padding: 15px;
        }

        @page {
            margin: 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .invoice-wrapper {
            width: 100%;
            margin: auto;
            border: 2px solid #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* ================= HEADER ================= */
        .header-table td {
            padding: 8px 10px;
            font-size: 14px;
        }

        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
        }

        /* ================= COMPANY ================= */
        .company-block {
            text-align: center;
            padding: 12px;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        .company-block h2 {
            font-size: 18px;
            font-weight: bold;
        }

        .company-block p {
            margin-top: 5px;
            font-size: 13px;
        }

        /* ================= DETAILS ================= */
        .details-table td {
            padding: 12px;
            vertical-align: top;
            border-bottom: 1px solid #000;
        }

        .details-table h3 {
            font-size: 15px;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .details-table p {
            margin: 4px 0;
        }

        /* ================= PRODUCT TABLE ================= */
        .product-table th,
        .product-table td {
            border: 1px solid #000;
            padding: 7px;
            font-size: 13px;
        }

        .product-table th {
            background: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        .product-table td {
            text-align: center;
        }

        .product-name {
            text-align: left !important;
        }

        /* ================= SUMMARY ================= */
        .summary-box {
            margin-top: 15px;
            width: 100%;
        }

        .summary-box td {
            padding: 6px;
            font-size: 14px;
        }

        .summary-label {
            text-align: right;
            font-weight: bold;
        }

        .summary-value {
            text-align: right;
            width: 150px;
            font-weight: bold;
        }

        .total-line td {
            border-top: 2px solid #000;
            padding-top: 10px;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
        }

        /* ================= FOOTER ================= */
        .footer-table td {
            padding: 10px;
            font-weight: bold;
            border-top: 1px solid #000;
        }
    </style>
</head>

<body>

    <div class="invoice-wrapper">

        <!-- ================= HEADER ================= -->
        <table class="header-table">
            <tr>
                <td width="40%">
                    Estimate No : <b><?= $order->order_id ?></b>
                </td>

                <td width="20%" class="header-title">
                    ESTIMATE
                </td>

                <td width="40%" align="right">
                    Date : <b><?= date("d-m-Y", strtotime($order->date)) ?></b>
                </td>
            </tr>

            <tr style="border-top:1px solid #000;">
                <td>
                    Phone : <b>
                        <?= $settings->mobile_number ?>
                        <?= $settings->alternate_mobile_mumber ? ', ' . $settings->alternate_mobile_mumber : '' ?>
                    </b>
                </td>

                <td></td>

                <td align="right">
                    Email : <b><?= $settings->email ?></b>
                </td>
            </tr>
        </table>


        <!-- ================= COMPANY ================= -->
        <div class="company-block">
            <h2><?= $settings->shop_name ?></h2>
            <p><?= $settings->address ?></p>
        </div>


        <!-- ================= CUSTOMER + BANK ================= -->
        <table class="details-table">
            <tr>

                <!-- Customer -->
                <td width="50%">
                    <h3>Customer Details</h3>

                    <?php if ($order->customer_name): ?>
                        <p>Name : <b><?= $order->customer_name ?></b></p>
                    <?php endif; ?>

                    <?php if ($order->phone): ?>
                        <p>Mobile : <b><?= $order->phone ?></b></p>
                    <?php endif; ?>

                    <?php if ($order->whatsapp): ?>
                        <p>Whatsapp : <b><?= $order->whatsapp ?></b></p>
                    <?php endif; ?>

                    <?php if ($order->email): ?>
                        <p>Email : <b><?= $order->email ?></b></p>
                    <?php endif; ?>

                    <?php if ($order->address): ?>
                        <p>Address : <b><?= $order->address ?></b></p>
                    <?php endif; ?>
                </td>


                <!-- Bank -->
                <td width="50%" align="right">
                    <h3>Bank Details</h3>

                    <?php if (!empty($settings->bank_details)): ?>
                        <?php $bank = $settings->bank_details[0]; ?>

                        <p>Acc Name : <b><?= $bank['holder_name'] ?? '' ?></b></p>
                        <p>Acc No : <b><?= $bank['account_number'] ?? '' ?></b></p>
                        <p>IFSC : <b><?= $bank['ifsc_code'] ?? '' ?></b></p>
                        <p>Bank : <b><?= $bank['name'] ?? '' ?></b></p>
                        <p>Branch : <b><?= $bank['branch_name'] ?? '' ?></b></p>

                    <?php endif; ?>
                </td>

            </tr>
        </table>


        <!-- ================= PRODUCT TABLE ================= -->
        <table class="product-table">
            <thead>
                <tr>
                    <th width="5%">S.No</th>
                    <th width="10%">Code</th>
                    <th width="35%">Product Name</th>
                    <th width="10%">MRP</th>
                    <th width="10%">Qty</th>
                    <th width="15%">Price</th>
                    <th width="15%">Amount</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($order->orderItems as $k => $item): ?>
                    <tr>
                        <td><?= $k + 1 ?></td>
                        <td><?= $item->code ?></td>
                        <td class="product-name"><?= $item->product_name ?></td>
                        <td><?= number_format($item->mrp, 2) ?></td>
                        <td><?= $item->quantity ?></td>
                        <td><?= money($item->price) ?></td>
                        <td><?= money($item->total_price) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>


        <!-- ================= SUMMARY CALCULATION ================= -->
        <?php
        $net_total = 0;

        foreach ($order->orderItems as $item) {
            $net_total += ($item->mrp * $item->quantity);
        }

        $discount_amount = ($net_total * $settings->bill_discount) / 100;
        $sub_total = $net_total - $discount_amount;

        $grand_total =
            $sub_total +
            $order->packing_charge -
            $order->promotion_discount;
        ?>


        <!-- ================= SUMMARY TABLE ================= -->
        <table class="summary-box">
            <tr>
                <td width="50%"></td>
                <td width="50%">
                    <table>
                        <tr>
                            <td class="summary-label">Net Total :</td>
                            <td class="summary-value"><?= money($net_total) ?></td>
                        </tr>

                        <tr>
                            <td class="summary-label">Discount :</td>
                            <td class="summary-value"><?= money($discount_amount) ?></td>
                        </tr>

                        <tr>
                            <td class="summary-label">Sub Total :</td>
                            <td class="summary-value"><?= money($sub_total) ?></td>
                        </tr>

                        <tr>
                            <td class="summary-label">Packing Charge :</td>
                            <td class="summary-value"><?= money($order->packing_charge) ?></td>
                        </tr>

                        <tr>
                            <td class="summary-label">Promotion Discount :</td>
                            <td class="summary-value"><?= money($order->promotion_discount) ?></td>
                        </tr>

                        <tr class="total-line">
                            <td class="summary-label"><b>Overall Total :</b></td>
                            <td class="summary-value"><b><?= money($grand_total) ?></b></td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>


        <!-- ================= FOOTER ================= -->
        <table class="footer-table">
            <tr>
                <td>Total Items : <b><?= count($order->orderItems) ?></b></td>
                <td align="center">
                    Total Qty :
                    <b><?= array_sum(ArrayHelper::getColumn($order->orderItems, 'quantity')) ?></b>
                </td>
                <td align="right"></td>
            </tr>
        </table>

    </div>

</body>

</html>
