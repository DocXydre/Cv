<?php
// single-formation.php
$context = Timber::context();
$context['post'] = new Timber\Post();
Timber::render('single-formation.twig', $context);