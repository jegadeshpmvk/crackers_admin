<?php

use yii\helpers\Html;

$menu = Yii::$app->request->get('tab', false);
if ($menu !== false)
    $tab = $menu;
else
    $tab = isset(Yii::$app->controller->tab) ? Yii::$app->controller->tab : '';
?>
<ul class="nav">
    <li<?php if ($tab == 'dashboard') echo ' class="active"'; ?> title="Dashboard"><?= Html::a('<span>Dashboard</span>', ['dashboard/index'], ['class' => 'fa fa-dashboard']) ?></li>
        <li<?php if ($tab == 'category') echo ' class="active"'; ?> title="Categories"><?= Html::a('<span>Categories</span>', ['category/index'], ['class' => 'fa fa-th-large']) ?></li>
            <li<?php if ($tab == 'product') echo ' class="active"'; ?> title="Product"><?= Html::a('<span>Product</span>', ['product/index'], ['class' => 'fa fa-shopping-bag']) ?></li>
                <li<?php if ($tab == 'coupon') echo ' class="active"'; ?> title="Coupon"><?= Html::a('<span>Coupon</span>', ['coupon/index'], ['class' => 'fa fa-ticket']) ?></li>
                    <li<?php if ($tab == 'order') echo ' class="active"'; ?> title="Order"><?= Html::a('<span>Order</span>', ['order/index'], ['class' => 'fa fa-ticket']) ?></li>
                        <li<?php if ($tab == 'report') echo ' class="active"'; ?> title="Report"><?= Html::a('<span>Report</span>', ['report/index'], ['class' => 'fa fa-ticket']) ?></li>
                            <li<?php if ($tab == 'delivery') echo ' class="active"'; ?> title="Delivery"><?= Html::a('<span>Delivery</span>', ['delivery/index'], ['class' => 'fa fa-truck']) ?></li>
                                <li<?php if ($tab == 'media') echo ' class="active"'; ?> title="Media"><?= Html::a('<span>Media</span>', ['media/index'], ['class' => 'fa fa-picture-o']) ?></li>

                                    <li<?php if ($tab == 'contact') echo ' class="active"'; ?> title="Contact Request"><?= Html::a('<span>Contact Request</span>', ['contact-request/index'], ['class' => 'fa fa-comments']) ?></li>

</ul>
<ul class="nav">
    <li<?php if ($tab == 'user') echo ' class="active"'; ?>><?= Html::a('<span>Admin</span>', ['user/index'], ['class' => 'fa fa-address-book']) ?></li>

</ul>
<ul class="nav">
    <li<?php if ($tab == 'shop-settings') echo ' class="active"'; ?> title="Header Footer"><?= Html::a('<span>Shop Settings</span>', ['shop-settings/index'], ['class' => 'fa fa-briefcase']) ?></li>
        <li<?php if ($tab == 'settings') echo ' class="active"'; ?> title="Settings"><?= Html::a('<span>Settings</span>', ['user/settings'], ['class' => 'fa fa-cog']) ?></li>
            <li<?php if ($tab == 'cache') echo ' class="active"'; ?>><?= Html::a('<span>Clear Cache</span>', ['default/clear'], ['class' => 'fa fa-codiepie']) ?></li>
                <li title="Logout"><?= Html::a('<span>Logout</span>', ['default/logout'], ['class' => 'fa fa-sign-out', 'data-action' => '']) ?></li>
</ul>