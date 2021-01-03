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
$args_articles  = [
    'post_type' => 'post',
    
    'posts_per_page' => 1000,
            
        ];
// $args_taxos = [
//     'post_type' => 'acts',
//     'taxonomy' => 'type',
//     'orderby' => 'name',
//     'posts_per_page' => 100,
// ];
// $args_taxo_ids = [
//     'post_type' => 'acts',
//     'taxonomy' => 'type',
//     // 'meta_key' => 'id',
//     // 'order' => 'ASC',
//     'orderby' => 'id',
//     'posts_per_page' => 100,
// ];

// $args_acts = [
//     'post_type' => 'acts',
//     'meta_key' => 'note',
//     'orderby' => [

//         'note' => 'DESC'
//     ],
//     'posts_per_page' => 100,
// ];


$args_contacts = [
    'post_type' => 'contacts',
    'id' => 126,
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
$args_events = [
    'post_type' => 'events',

];

$args_lieux = [
    'post_type' => 'places',
];

//// récupère les articles en fonction du tableau d'argument $args_posts
//// en utilisant la méthode de Timber get_posts
//// puis on les enregistre dans l'array $context sous la clé "posts"

// $context['events'] = Timber::get_posts($args_events);
// $context['taxos'] = Timber::get_terms($args_taxos);
// $context['taxo_ids'] = Timber::get_terms($args_taxo_ids);
// $context['acts'] = Timber::get_posts($args_acts);
$context['lieux'] = Timber::get_posts($args_lieux);
$context['labels'] = Timber::get_posts($args_labels);
$context['articles'] = Timber::get_posts($args_articles);
$context['events'] = Timber::get_posts($args_events);
$context['contacts'] = Timber::get_posts($args_contacts);
$context['url'] = $_SERVER["REQUEST_URI"];



// $context['contacts'] = Timber::get_posts($args_contacts);
// $context['results'] = Timber::get_posts($envoi);
Timber::render('pages/page-121.twig', $context);
