<?php
/**
 * Template Name: Normal
 * Description: A normal Page template.
 */

$context = Timber::context();

$timber_post = Timber::get_post();
$context['post'] = $timber_post;
Timber::render(array('page-' . $timber_post->post_name . '.twig', 'page.twig'), $context);