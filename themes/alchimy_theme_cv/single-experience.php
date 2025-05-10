<?php
/**
 * Template pour l'affichage d'une expérience
 */

 $context = Timber::context();
 $timber_post = Timber::get_post();
 $context['post'] = $timber_post;
 
 // Récupération des formations liées via ACF
 $related_formations = get_field('related_formation', $timber_post->ID);
 if (!empty($related_formations)) {
     $context['formations'] = Timber::get_posts($related_formations);
 } else {
     // Fallback si aucune formation liée
     $context['formations'] = Timber::get_posts([
         'post_type' => 'formation',
         'posts_per_page' => 2,
         'orderby' => 'date_start',
         'order' => 'ASC',
     ]);
 }
 
 // Récupération des expériences liées via ACF
 $related_experiences = get_field('related_experience', $timber_post->ID);
 if (!empty($related_experiences)) {
     $context['experiences'] = Timber::get_posts($related_experiences);
 } else {
     // Fallback si aucune expérience liée
     $context['experiences'] = Timber::get_posts([
         'post_type' => 'experience',
         'posts_per_page' => 2,
         'orderby' => 'date_start',
         'order' => 'ASC',  
     ]);
 }
 
 // Récupération des projets liés via ACF
 $related_projets = get_field('related_projet', $timber_post->ID);
 if (!empty($related_projets)) {
     $context['projets'] = Timber::get_posts($related_projets);
 } else {
     // Fallback si aucun projet lié
     $context['projets'] = Timber::get_posts([
         'post_type' => 'projet',
         'posts_per_page' => 3,
         'orderby' => 'date',
         'order' => 'DESC',
     ]);
 }
 
 Timber::render('single-experience.twig', $context);