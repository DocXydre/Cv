<?php
// single-experience.php
$context = Timber::context();
$context['post'] = new Timber\Post();
Timber::render('single-experience.twig', $context);