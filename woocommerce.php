<?php

use Timber\Timber;

$context = Timber::context();

if (is_singular('product')) {
    Timber::render('templates/single-product.twig', $context);
} else {
    Timber::render('templates/archive-product.twig', $context);
}
