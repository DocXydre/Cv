<?php

$context = Timber::context();
$timber_post = Timber::get_post();
$context['post'] = $timber_post;

$context['formations'] = Timber::get_posts([
    'post_type' => 'formation',
    'posts_per_page' => 3,
    'orderby' => 'date_start',
    'order' => 'ASC',
]);
$context['experiences'] = Timber::get_posts([
    'post_type' => 'experience',
    'posts_per_page' => 3,
    'orderby' => 'date_start',
    'order' => 'ASC',
]);
$context['projets'] = Timber::get_posts([
    'post_type' => 'projet',
    'posts_per_page' => 3,
    'orderby' => 'date',
    'order' => 'DESC',
]);
$context['competences'] = Timber::get_terms('competence', [
    'orderby' => 'name',
    'order' => 'ASC',
]);

Timber::render('page-home.twig', $context);