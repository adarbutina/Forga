<?php

use Timber\Timber;

$context = Timber::context();

Timber::render('templates/archive.twig', $context);
