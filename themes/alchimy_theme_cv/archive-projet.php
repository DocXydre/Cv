<?php
// archive-projet.php
$context = Timber::context();
$context['projets'] = Timber::get_posts([
    'post_type' => 'projet',
    'orderby' => 'date',
    'order' => 'DESC',
]);
Timber::render('archive-projet.twig', $context);