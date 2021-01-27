<?php
// function dr_adding_styles()
// {
//   wp_enqueue_style('style', get_template_directory_uri() . '/style.css');
// }

// add_action('wp_enqueue_scripts', 'js_adding_styles');

add_theme_support('post-thumbnails');

register_nav_menus(array(
    'header-menu' => 'Header-menu',
    // 'footer-menu' => 'Footer-menu'

));

/** 
 * If you are installing Timber as a Composer dependency in your theme, you'll need this block
 * to load your dependencies and initialize Timber. If you are using Timber via the WordPress.org
 * plug-in, you can safely delete this block.
 */
$composer_autoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($composer_autoload)) {
    require_once($composer_autoload);
    $timber = new Timber\Timber();
}

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if (!class_exists('Timber')) {

    add_action('admin_notices', function () {
        echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url(admin_url('plugins.php#timber')) . '">' . esc_url(admin_url('plugins.php')) . '</a></p></div>';
    });

    add_filter('template_include', function ($template) {
        return get_stylesheet_directory() . '/static/no-timber.html';
    });
    return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array('templates', 'views');

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;







// fonction pour créer des variables globales, accessibles dans tous les fichiers twig
function add_to_context($data)
{

    // on appelle une instance de TimberMenu avec en parametre le menu qu'on veut récupérer
    //$data['menu'] = new TimberMenu('header-menu');
    $data['menu'] = new \Timber\Menu('header-menu');
    return $data;
}



// On ajoute le résultat de notre fonction au context de twig (contexte globale)
add_filter('timber/context', 'add_to_context');
// show admin bar 


function init_remove_support()
{
    $page_type = 'page';
    $post_type = 'post';

    remove_post_type_support($page_type, 'editor');
    remove_post_type_support($post_type, 'editor');
}
add_action('init', 'init_remove_support', 100);

function wpc_show_admin_bar()
{
    return true;
}
add_filter('show_admin_bar', 'wpc_show_admin_bar');
add_filter('acf/settings/remove_wp_meta_box', '__return_false');

function remove_menus()
{

    //    remove_menu_page( 'index.php' );                  //Dashboard
    //    remove_menu_page('edit.php');                   //Posts
    //    remove_menu_page( 'upload.php' );                 //Media
    //    remove_menu_page( 'edit.php?post_type=page' );    //Pages
          remove_menu_page('edit-comments.php');          //Comments
    //    remove_menu_page( 'themes.php' );                 //Appearance
    //    remove_menu_page( 'plugins.php' );                //Plugins
    //    remove_menu_page( 'users.php' );                  //Users
    //    remove_menu_page( 'tools.php' );                  //Tools
    //    remove_menu_page( 'options-general.php' );        //Settings

}
add_action('admin_menu', 'remove_menus');

add_action('init', 'my_custom_init');
function my_custom_init()
{
    register_post_type(
        'acts',
        array(
            'label' => 'Réalisations',
            'labels' => array(
                'name' => 'réalisations',
                'singular_name' => 'réalisation',
                'all_items' => 'Toutes les réalisations',
                'add_new_item' => 'Ajouter une réalisation',
                'edit_item' => 'Éditer la réalisation',
                'new_item' => 'Nouvelle réalisation',
                'view_item' => 'Voir la réalisation',
                'search_items' => 'Rechercher parmi les réalisations',
                'not_found' => 'Pas de réalisation',
                'not_found_in_trash' => 'Pas de réalisation dans la corbeille'
            ),
            'public' => true,
            'rewrite'   => array('slug' => 'acts'),
            'menu_position' => 1,
            'menu_icon' => 'dashicons-hammer',
            'capability_type' => 'post',
            'supports' => array('title', 'author', 'thumbnail', 'excerpt'),
            'has_archive' => true
        )
        );
    register_post_type(
        'members',
        array(
            'label' => 'Membres',
            'labels' => array(
                'name' => 'membres',
                'singular_name' => 'membre',
                'all_items' => 'Touss les membres',
                'add_new_item' => 'Ajouter un membre',
                'edit_item' => 'Éditer le membre',
                'new_item' => 'Nouveau membre',
                'view_item' => 'Voir le membre',
                'search_items' => 'Rechercher parmi les membres',
                'not_found' => 'Pas de membre',
                'not_found_in_trash' => 'Pas de réalisation dans la corbeille'
            ),
            'public' => true,
            'rewrite'   => array('slug' => 'members'),
            'menu_position' => 1,
            'menu_icon' => 'dashicons-businessperson',
            'capability_type' => 'post',
            'supports' => array('title', 'author', 'thumbnail'),
            'has_archive' => true
        )
    );
         
    register_post_type(
       'events',
        array(
            'label' => 'évènements',
            'labels' => array(
                'name' => 'évènements',
                'singular_name' => 'évènement',
                'all_items' => 'Tous les évènements',
                'add_new_item' => 'Ajouter un évènement',
                'edit_item' => 'Éditer l\'évènement',
                'new_item' => 'Nouvel évènement',
                'view_item' => 'Voir l\'évènements',
                'search_items' => 'Rechercher parmi les évènements',
                'not_found' => 'Pas d\"évènement',
                'not_found_in_trash' => 'Pas d\"évènement dans la corbeille'
            ),
            'public' => true,
            'rewrite'   => array('slug' => 'events'),
            'menu_position' => 2,
            'menu_icon' => 'dashicons-calendar-alt',
            'capability_type' => 'post',
            'supports' => array('title', 'author', 'thumbnail', 'excerpt'),
            'has_archive' => true
        )
    );
    register_post_type(
        'refs',
        array(
            'label' => 'références',
            'labels' => array(
                'name' => 'références',
                'singular_name' => 'référence',
                'all_items' => 'Tous les références',
                'add_new_item' => 'Ajouter une référence',
                'edit_item' => 'Éditer la référence',
                'new_item' => 'Nouvelle référence',
                'view_item' => 'Voir la références',
                'search_items' => 'Rechercher parmi les références',
                'not_found' => 'Pas de référence',
                'not_found_in_trash' => 'Pas de référence dans la corbeille'
            ),
            'public' => true,
            'rewrite'   => array('slug' => 'refs'),
            'menu_position' => 3,
            'menu_icon' => 'dashicons-welcome-learn-more',
            'capability_type' => 'post',
            'supports' => array('title', 'author', 'thumbnail', 'excerpt'),
            'has_archive' => true
        )
    );
    register_post_type(
        'partners',
        array(
            'label' => 'partenaires',
            'labels' => array(
                'name' => 'partenaires',
                'singular_name' => 'partenaire',
                'all_items' => 'Tous les partenaires',
                'add_new_item' => 'Ajouter un partenaire',
                'edit_item' => 'Éditer le partenaire',
                'new_item' => 'Nouveau partenaire',
                'view_item' => 'Voir le partenaire',
                'search_items' => 'Rechercher parmi les partenaires',
                'not_found' => 'Pas de partenaire',
                'not_found_in_trash' => 'Pas de partenaire dans la corbeille'
            ),
            'public' => true,
            'rewrite'   => array('slug' => 'refs'),
            'menu_position' => 3,
            'menu_icon' => 'dashicons-groups',
            'capability_type' => 'post',
            'supports' => array('title', 'author', 'thumbnail',),
            'has_archive' => true
        )
    );
    register_post_type(
        'places',
        array(
            'label' => 'lieux',
            'labels' => array(
                'name' => 'lieux',
                'singular_name' => 'lieu',
                'all_items' => 'Tous les lieux',
                'add_new_item' => 'Ajouter une lieu',
                'edit_item' => 'Éditer la lieu',
                'new_item' => 'Nouvelle lieu',
                'view_item' => 'Voir la lieux',
                'search_items' => 'Rechercher parmi les lieux',
                'not_found' => 'Pas de lieu',
                'not_found_in_trash' => 'Pas de lieu dans la corbeille'
            ),
            'public' => true,
            'rewrite'   => array('slug' => 'places'),
            'menu_position' => 4,
            'menu_icon' => 'dashicons-location-alt',
            'capability_type' => 'post',
            'supports' => array('title', 'author', 'thumbnail', 'excerpt'),
            'has_archive' => true
        )
    );
    register_post_type(
        'contacts',
        array(
            'label' => 'Contacts',
            'labels' => array(
                'name' => 'contacts',
                'singular_name' => 'contact',
                'all_items' => 'Toutes les contacts',
                'add_new_item' => 'Ajouter une contact',
                'edit_item' => 'Éditer la contact',
                'new_item' => 'Nouvelle contact',
                'view_item' => 'Voir la contact',
                'search_items' => 'Rechercher parmi les contacts',
                'not_found' => 'Pas de contact',
                'not_found_in_trash' => 'Pas de contact dans la corbeille'
            ),
            'public' => true,
            'rewrite'   => array('slug' => 'contacts'),
            'menu_position' => 1,
            'menu_icon' => 'dashicons-phone',
            'capability_type' => 'post',
            'supports' => array('title', 'thumbnail'),
            'has_archive' => true
        )
    );
    register_taxonomy(
        'type',
        'acts',
        array(
            'label' => 'Types',
            'labels' => array(
                'name' => 'Types de réalisation',
                'singular_name' => 'Type',
                'all_items' => 'Tous les types',
                'edit_item' => 'Éditer le type',
                'view_item' => 'Voir le type',
                'update_item' => 'Mettre à jour le type',
                'add_new_item' => 'Ajouter un type',
                'new_item_name' => 'Nouveau type',
                'search_items' => 'Rechercher parmi les types',
                'popular_items' => 'Types les plus utilisés'
            ),
            'hierarchical' => true
        )
    );
    
    register_taxonomy(
        'material',
        'acts',
        array(
            'label' => 'matériaux',
            'labels' => array(
                'name' => 'matériaux',
                'singular_name' => 'matériau',
                'all_items' => 'Tous les matériaux',
                'edit_item' => 'Éditer le matériau',
                'view_item' => 'Voir le matériau',
                'update_item' => 'Mettre à jour le matériau',
                'add_new_item' => 'Ajouter un matériau',
                'new_item_name' => 'Nouveau matériau',
                'search_items' => 'Rechercher parmi les matériaux',
                'popular_items' => 'Matériaux les plus utilisés'
            ),
            'hierarchical' => true
        )
    );
    register_taxonomy(
        'designer',
        'acts',
        array(
            'label' => 'maître d\'oeuvre',
            'labels' => array(
                'name' => 'maîtres d\'oeuvre',
                'singular_name' => 'maître d\'oeuvre',
                'all_items' => 'Tous les maîtres d\'oeuvre',
                'edit_item' => 'Éditer le maître d\'oeuvre',
                'view_item' => 'Voir le maître d\'oeuvre',
                'update_item' => 'Mettre à jour le maître d\'oeuvre',
                'add_new_item' => 'Ajouter un maître d\'oeuvre',
                'new_item_name' => 'Nouveau maître d\'oeuvre',
                'search_items' => 'Rechercher parmi les maîtres d\'oeuvre',
                'popular_items' => 'maîtres d\'oeuvre les plus utilisés'
            ),
            'hierarchical' => true
        )
    );
    register_taxonomy(
        'partner-type',
        'partners',
        array(
            'label' => 'type',
            'labels' => array(
                'name' => 'type de partenaire',
                'singular_name' => 'type de partenaire',
                'all_items' => 'Tous les type de partenaire',
                'edit_item' => 'Éditer le type de partenaire',
                'view_item' => 'Voir le type de partenaire',
                'update_item' => 'Mettre à jour le type de partenaire',
                'add_new_item' => 'Ajouter un type de partenaire',
                'new_item_name' => 'Nouveau type de partenaire',
                'search_items' => 'Rechercher parmi les types de partenaire',
                'popular_items' => 'types de partenaire les plus utilisés'
            ),
            'hierarchical' => true
        )
    );
    register_taxonomy(
        'member-type',
        'members',
        array(
            'label' => 'type',
            'labels' => array(
                'name' => 'fonction',
                'singular_name' => 'Fonction',
                'all_items' => 'Toutes les fonctions',
                'edit_item' => 'Éditer la fonction',
                'view_item' => 'Voir la fonction',
                'update_item' => 'Mettre à jour la fonction',
                'add_new_item' => 'Ajouter une fonction',
                'new_item_name' => 'Nouvelle fonction',
                'search_items' => 'Rechercher parmi les fonctions',
                'popular_items' => 'Fonctions les plus utilisées'
            ),
            'hierarchical' => true
        )
    );
    register_taxonomy(
        'theme',
        'post',
        array(
            'label' => 'theme',
            'labels' => array(
                'name' => 'theme',
                'singular_name' => 'Thème',
                'all_items' => 'Tous les thèmes',
                'edit_item' => 'Éditer le thème',
                'view_item' => 'Voir le thème',
                'update_item' => 'Mettre à jour le thème',
                'add_new_item' => 'Ajouter un thème',
                'new_item_name' => 'Nouveau thème',
                'search_items' => 'Rechercher parmi les thèmes',
                'popular_items' => 'Thèmes les plus utilisées'
            ),
            'hierarchical' => true
        )
    );
    register_taxonomy(
        'event-type',
        'events',
        array(
            'label' => 'Type d\'évènement',
            'labels' => array(
                'name' => 'type d\'évènement',
                'singular_name' => 'Type d\'évènement',
                'all_items' => 'Tous les type d\'évènements',
                'edit_item' => 'Éditer le type d\'évènement',
                'view_item' => 'Voir le type d\'évènement',
                'update_item' => 'Mettre à jour le type d\'évènement',
                'add_new_item' => 'Ajouter un type d\'évènement',
                'new_item_name' => 'Nouveau type d\'évènement',
                'search_items' => 'Rechercher parmi les type d\'évènements',
                'popular_items' => 'Type d\'évènements les plus utilisées'
            ),
            'hierarchical' => true
        )
    );
    
}
    register_taxonomy_for_object_type('theme', 'post');
    register_taxonomy_for_object_type('event-type', 'events');
    register_taxonomy_for_object_type('type', 'acts');
    register_taxonomy_for_object_type('material', 'acts');
    register_taxonomy_for_object_type('designer', 'acts');
    register_taxonomy_for_object_type('partner-type', 'partners');
    register_taxonomy_for_object_type('member-type', 'members');
    

function custom_menu_order($menu_ord)
{
    if (!$menu_ord) return true;
    return array(
        'index.php', // this represents the dashboard link
        'edit.php?post_type=page', // this is the default page menu
        'edit.php', // this is the default POST admin menu
        'edit.php?post_type=acts', // réalisations
        'edit.php?post_type=events', //évènements
        'edit.php?post_type=refs', //références
        'edit.php?post_type=partners', //partenaires
        'edit.php?post_type=members', //membres 
        'edit.php?post_type=places', //lieux
        'edit.php?post_type=contacts', //lieux 
        
    );
}
add_filter('custom_menu_order', 'custom_menu_order');
add_filter('menu_order', 'custom_menu_order');
add_filter('timber/twig', function ($twig) {
    $twig->addExtension(new Twig_Extension_StringLoader());

    $twig->addFilter(
        new Twig_SimpleFilter(
            'highlight',

            function ($text, array $terms) {

                $highlight = array();
                foreach ($terms as $term) {
                    $highlight[] = '<span class="highlight">' . $term . '</span>';
                }

                return str_ireplace($terms, $highlight, $text);
            }

        )
    );

    return $twig;
});

function wpc_excerpt_pages()
{
    add_meta_box('postexcerpt', __('Extrait'), 'post_excerpt_meta_box', 'page', 'normal', 'core');
}
add_action('admin_menu', 'wpc_excerpt_pages');

add_action('after_setup_theme', 'my_adjust_image_sizes');
function my_adjust_image_sizes()
{
//     //add an cropped image-size with 800 x 250 Pixels
    add_image_size('my-custom-image-size', 800, 250, true);
    add_image_size('my-custom-image-size', 1265, 550, true);
    


//     /** 
//      * The following image sizes use a dynamic value.
//      * USE WITH CARE
//      * Also the plugin supports these image-sizes, i do not recommend them!
//      **/
//     //a dynamic cropped image size with 500 pixel height and the width of the original image
//     add_image_size('my-dynamic-width-1', 9999, 500, true);

//     //a dynamic cropped image with the same ratio as the original image and 500 pixel width
//     add_image_size('my-dynamic-zero-height-1', 500, 0, true);
}
add_action('init', 'init_remove_support', 100);

function seopress_theme_slug_setup()
{
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'seopress_theme_slug_setup');