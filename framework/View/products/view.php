<?php $this->extends('layout/products'); ?>
<h1>Product</h1>
<p>
    This is the product page for <?php print $product; ?>
    <?php print $this->escape($scary); ?>
</p>