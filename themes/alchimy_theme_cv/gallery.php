<?php
/*
  Template Name: Champ Galerie
*/

// Inclure Timber
if (!class_exists('Timber')) {
    echo 'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
    return;
}

// Récupérer le contexte Timber
$context = Timber::get_context();

// Récupérer le post actuel
$post = new TimberPost();
$context['post'] = $post;

// Récupérer les images du champ de galerie ACF
if ($photos = $post->get_field('photos')) {
    $context['photos'] = $photos;
} 

// Rendre le template Twig
Timber::render('gallery.twig', $context);