<?php
/**
 * Template Name: Contact
 * Description: Template pour la page de contact.
 */

$context = Timber::context();
$timber_post = Timber::get_post();
$context['post'] = $timber_post;

// Fournir uniquement le nonce pour le formulaire AJAX
$context['nonce'] = wp_create_nonce('contact_form');

Timber::render('page-contact.twig', $context);