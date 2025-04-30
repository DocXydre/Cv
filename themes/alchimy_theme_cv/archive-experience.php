<?php
// archive-experience.php
$context = Timber::context();
$context['experiences'] = Timber::get_posts([
    'post_type' => 'experience',
    'orderby' => 'date',
    'order' => 'DESC',
]);
Timber::render('archive-experience.twig', $context);