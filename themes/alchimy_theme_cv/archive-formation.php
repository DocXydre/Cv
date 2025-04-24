<?php
// archive-formation.php
$context = Timber::context();
$context['formations'] = Timber::get_posts([
    'post_type' => 'formation',
    'orderby' => 'date',
    'order' => 'DESC',
]);
Timber::render('archive-formation.twig', $context);