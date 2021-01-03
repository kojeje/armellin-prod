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

$args_taxos = [
        'post_type' => 'acts',
        'taxonomy' => 'type',
        'orderby' => 'name',
        'posts_per_page' => -1,
];

$args_acts = [
        'post_type' => 'acts',
        'meta_key' => 'note',
        'orderby' => [

                'note' => 'DESC'
        ],
        'posts_per_page' => 100,
];
$args_labels = [
        'post_type' => 'partners',

        // 'meta_query' => [
        // 'relation' => 'AND',
        //         [
        //         'taxonomy' => 'partner-type',
        //         'slug' => 'labels',
        //         'compare' => 'LIKE'
        //         ],
        // ],
];

$args_contacts = [
        'post_type' => 'contacts',
        'id' => 126,
];
$args_lieux = [
        'post_type' => 'places',
];

//// récupère les articles en fonction du tableau d'argument $args_posts
//// en utilisant la méthode de Timber get_posts
//// puis on les enregistre dans l'array $context sous la clé "posts"

// $context['events'] = Timber::get_posts($args_events);
$context['contacts'] = Timber::get_posts($args_contacts);
$context['taxos'] = Timber::get_terms($args_taxos);
$context['acts'] = Timber::get_posts($args_acts);
$context['labels'] = Timber::get_posts($args_labels);
$context['lieux'] = Timber::get_posts($args_lieux);
$context['url'] = $_SERVER["REQUEST_URI"];
// var_dump($context['taxos']);die;
// var_dump($context['labels']);die;
// $context['results'] = Timber::get_posts($envoi);
Timber::render('pages/page-290.twig', $context);
