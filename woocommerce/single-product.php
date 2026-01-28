<?php

use Timber\Timber;

$context = Timber::context();

Timber::render('woocommerce/single-product.twig', $context);
