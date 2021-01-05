<?php

//OBLIGATOIRE : Récupère les variables globales de Wordpress
$context = Timber::get_context();

// on récupère le contenu du post actuel grâce à TimberPost
$post = new TimberPost();

// on ajoute la variable post (qui contient le post) à la variable
// qu'on enverra à la vue twig
$context['post'] = $post;



// tableau d'arguments pour modifier la requête en base
// de données, et venir récupérer uniquement les trois
// derniers articles

$args_members = [
    'post_type' => 'members',
    'order' => 'ASC',
    'orderby' => 'date'
];
$args_contacts = [
    'post_type' => 'contacts',
    'id' => 126,
    // 'key' => 'date',
    // 'orderby' => 'date',
    // 'order' => 'DESC',
    // 'posts_per_page' => 1,
];
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
$args_lieux = [
    'post_type' => 'places',
];

//// récupère les articles en fonction du tableau d'argument $args_posts
//// en utilisant la méthode de Timber get_posts
//// puis on les enregistre dans l'array $context sous la clé "posts"

// $context['events'] = Timber::get_posts($args_events);
$context['contacts'] = Timber::get_posts($args_contacts);
$context['labels'] = Timber::get_posts($args_labels);
$context['members'] = Timber::get_posts($args_members);
$context['lieux'] = Timber::get_posts($args_lieux);
$context['url'] = $_SERVER["REQUEST_URI"];



// $context['places'] = Timber::get_posts($args_places);
// var_dump($context['contacts']);die;
// var_dump($context['fiches']);die;
// appelle la vue twig "page-31.twig" située dans le dossier views
// en lui passant la variable $context qui contient notamment ici les articles
Timber::render('pages/page-6.twig', $context);
