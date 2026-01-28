<?php

use Timber\Timber;

$context = Timber::context();

Timber::render('woocommerce/archive-product.twig', $context);
