<?php

$context = Timber::context();
$timber_post = Timber::get_post();
$context['post'] = $timber_post;

$context['formations'] = Timber::get_posts([
    'post_type' => 'formation',
    'posts_per_page' => 3,
    'orderby' => 'date',
    'order' => 'DESC',
]);
$context['experiences'] = Timber::get_posts([
    'post_type' => 'experience',
    'posts_per_page' => 3,
    'orderby' => 'date',
    'order' => 'DESC',
]);
$context['projets'] = Timber::get_posts([
    'post_type' => 'projet',
    'posts_per_page' => 3,
    'orderby' => 'date',
    'order' => 'DESC',
]);

Timber::render('page-home.twig', $context);