<?php

//OBLIGATOIRE : Récupère les variables globales de Wordpress
$context = Timber::get_context();

// on récupère le contenu du post actuel grâce à TimberPost
$post = new TimberPost();

// on ajoute la variable post (qui contient le post) à la variable
// qu'on enverra à la vue twig
$context['post'] = $post;

$args_labels = [
    'post_type' => 'partners',

    'meta_query' => [
        'relation' => 'AND',
        [
            'taxonomy' => 'partner-type',
            'compare' => 'LIKE'
        ],
    ],
];
$args_contacts = [
    'post_type' => 'contacts',
    'id' => 126,
    // 'key' => 'date',
    // 'orderby' => 'date',
    // 'order' => 'DESC',
    // 'posts_per_page' => 1,
];
$context['labels'] = Timber::get_posts($args_labels);
$context['contacts'] = Timber::get_posts($args_contacts);
// appelle la vue twig "single.twig" située dans le dossier views
// en lui passant la variable $context qui contient notamment ici les articles

Timber::render('pages/templates/single.twig', $context);
