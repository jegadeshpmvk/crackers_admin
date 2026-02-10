    <?php

    use yii\helpers\ArrayHelper;
    ?>
    <style>
        .estimate-wrapper {
            border: 2px solid #000;
            font-family: Arial, sans-serif;
            font-size: 14px;
            width: 100%;
        }

        /* HEADER */
        .top-header {
            border-bottom: 1px solid #000;
        }

        .row {
            display: flex;
            justify-content: space-between;
            padding: 10px;
        }

        .border-top {
            border-top: 1px solid #000;
        }

        .left {
            flex: 1;
        }

        .center {
            flex: 1;
            text-align: center;
        }

        .right {
            flex: 1;
            text-align: right;
        }

        /* COMPANY */
        .company-block {
            text-align: center;
            padding: 15px;
            border-bottom: 1px solid #000;
        }

        .company-block h2 {
            margin: 0;
            font-size: 18px;
        }

        .company-block p {
            margin: 5px 0 0;
        }

        /* DETAILS */
        .details-section {
            display: flex;
            border-bottom: 1px solid #000;
        }

        .details-box {
            flex: 1;
            padding: 20px;
        }

        .details-box h3 {
            margin-bottom: 15px;
        }

        .details-box p {
            margin: 8px 0;
        }

        .text-right {
            text-align: right;
        }

        /* PRODUCT TABLE */
        .product-table {
            width: 100%;
        }

        .product-row {
            display: flex;
            border-bottom: 1px solid #000;
        }

        .product-row div {
            flex: 1;
            padding: 10px;
            text-align: center;
            border-right: 1px solid #000;
        }

        .product-row div:last-child {
            border-right: none;
        }

        .product-head {
            font-weight: bold;
            background: #f2f2f2;
        }

        .flex-2 {
            flex: 2 !important;
        }

        /* SUMMARY */
        .summary-section {
            padding: 15px;
            border-bottom: 1px solid #000;
        }

        .summary-line {
            display: flex;
            justify-content: flex-end;
            gap: 20px;
            margin: 8px 0;
        }

        .summary-line span {
            min-width: 220px;
            text-align: right;
            font-weight: bold;
        }

        .summary-line b {
            min-width: 120px;
            text-align: right;
        }

        .summary-line.total {
            font-size: 16px;
            font-weight: bold;
        }

        /* FOOTER */
        .footer-row {
            display: flex;
            justify-content: space-between;
            padding: 12px;
            font-weight: bold;
        }
    </style>
    <div class="estimate-wrapper">
        <!-- HEADER -->
        <div class="top-header">
            <div class="row">
                <div class="left">
                    Estimate No : <b><?= $order->order_id; ?></b>
                </div>

                <div class="center">
                    <b>ESTIMATE</b>
                </div>

                <div class="right">
                    Date : <b><?= $order->date ?></b>
                </div>
            </div>

            <div class="row border-top">
                <div class="left">
                    Phone : <b><?= $settings->mobile_number ?><?= $settings->alternate_mobile_mumber ?  ', ' . $settings->alternate_mobile_mumber : '' ?></b>
                </div>

                <div class="center"></div>

                <div class="right">
                    Email : <b><?= $settings->email ?></b>
                </div>
            </div>
        </div>

        <!-- COMPANY -->
        <div class="company-block">
            <h2><?= $settings->shop_name ?></h2>
            <p><?= $settings->address ?></p>
        </div>

        <!-- DETAILS -->
        <div class="details-section">

            <!-- CUSTOMER -->
            <div class="details-box">
                <h3>Customer Details</h3>
                <?php
                if ($order->customer_name) {
                    echo '<p>Name : <b>' . $order->customer_name . '</b></p>';
                }
                if ($order->phone) {
                    echo '<p>Mobile : <b>' . $order->phone . '</b></p>';
                }
                if ($order->whatsapp) {
                    echo '<p>Whatsapp : <b>' . $order->whatsapp . '</b></p>';
                }
                if ($order->email) {
                    echo '<p>E-Mail Id : <b>' . $order->email . '</b></p>';
                }
                if ($order->address) {
                    echo '<p>Address : <b>' . $order->address . '</b></p>';
                }
                if ($order->refer) {
                    echo '<p>Refer by : <b>' . $order->refer . '</b></p>';
                }
                ?>
            </div>

            <!-- BANK -->
            <div class="details-box text-right">
                <h3>Bank Details</h3>
                <?php
                if (!empty($settings->bank_details)) {
                    if ($settings->bank_details[0]['holder_name'])
                        echo '<p>Acc Name : <b>' . $settings->bank_details[0]['holder_name'] . '</b></p>';
                    if ($settings->bank_details[0]['account_number'])
                        echo '<p>Acc Numbe : <b>' . $settings->bank_details[0]['account_number'] . '</b></p>';
                    if ($settings->bank_details[0]['ifsc_code'])
                        echo '<p>IFSC Code : <b>' . $settings->bank_details[0]['ifsc_code'] . '</b></p>';
                    if ($settings->bank_details[0]['name'])
                        echo '<p>Bank Name : <b>' . $settings->bank_details[0]['name'] . '</b></p>';
                    if ($settings->bank_details[0]['branch_name'])
                        echo '<p>Branch : <b>' . $settings->bank_details[0]['branch_name'] . '</b></p>'
                ?>
                <?php } ?>

            </div>
        </div>

        <!-- PRODUCT TABLE -->
        <div class="product-table">

            <!-- HEADER -->
            <div class="product-row product-head">
                <div>S.No</div>
                <div>Code</div>
                <div class="flex-2">Product Name</div>
                <div>MRP (Rs)</div>
                <div>Quantity</div>
                <div>Price (Rs)</div>
                <div>Amount (Rs)</div>
            </div>

            <!-- ITEM -->
            <?php

            if (!empty($order->orderItems)) {
                foreach ($order->orderItems as $k => $item) {
            ?>
                    <div class="product-row">
                        <div><?= ($k + 1); ?></div>
                        <div><?= $item->code; ?></div>
                        <div class="flex-2"><?= $item->product_name; ?></div>
                        <div><?= $item->mrp; ?></div>
                        <div><?= $item->quantity; ?></div>
                        <div><?= Yii::$app->formatter->asCurrency($item->price, 'INR'); ?></div>
                        <div><?= Yii::$app->formatter->asCurrency($item->total_price, 'INR'); ?></div>
                    </div>
            <?php }
            }
            ?>


        </div>

        <!-- SUMMARY -->
        <div class="summary-section">
            <?php
            $mrp = array_sum(ArrayHelper::getColumn($order->orderItems, 'mrp'));
            $quantity = array_sum(ArrayHelper::getColumn($order->orderItems, 'quantity'));
            $net_total = $mrp * $quantity;

            $discount_amount = ($net_total * $settings->bill_discount) / 100;
            ?>
            <div class="summary-line">
                <span>Net Total (Rs) :</span>
                <b><?= Yii::$app->formatter->asCurrency($net_total, 'INR'); ?></b>
            </div>

            <div class="summary-line">
                <span>Discount Price (Rs) :</span>
                <b><?= Yii::$app->formatter->asCurrency($discount_amount, 'INR'); ?></b>
            </div>

            <div class="summary-line">
                <span>Sub Total (Rs) :</span>
                <b><?= Yii::$app->formatter->asCurrency($order->total, 'INR'); ?></b>
            </div>

            <div class="summary-line">
                <span>Packing Charge (Rs) :</span>
                <b><?= Yii::$app->formatter->asCurrency($order->packing_charge, 'INR'); ?></b>
            </div>

            <div class="summary-line">
                <span>Promotion Discount (Rs) :</span>
                <b><?= Yii::$app->formatter->asCurrency($order->promotion_discount, 'INR'); ?></b>
            </div>

            <div class="summary-line total">
                <span>Overall Total (Rs) :</span>
                <b><?= Yii::$app->formatter->asCurrency($order->final_total, 'INR'); ?></b>
            </div>

        </div>

        <!-- FOOTER -->
        <div class="footer-row">
            <div>Total items : <b><?= count($order->orderItems) ?></b></div>
            <div>Total Quantity : <b><?= array_sum(ArrayHelper::getColumn($order->orderItems, 'quantity')) ?></b></div>
            <div></div>
        </div>

    </div>