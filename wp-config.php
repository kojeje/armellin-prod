<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en « wp-config.php » et remplir les
 * valeurs.
 *
 * Ce fichier contient les réglages de configuration suivants :
 *
 * Réglages MySQL
 * Préfixe de table
 * Clés secrètes
 * Langue utilisée
 * ABSPATH
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'c1_armellin-test' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'c1_e2w' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', 'Kestufe12' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Type de collation de la base de données.
 * N’y touchez que si vous savez ce que vous faites.
 */
define( 'DB_COLLATE', '' );

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '%TiP5)_*C89o-~5$4DLYNJ*gcA|^864bPC:/6XOu$]vJ}|)n)C</4i-V3EL_GC~p' );
define( 'SECURE_AUTH_KEY',  '6knBQZn2H#/jVMbXkgZsaH^>b#k1~=:`E{-5zRFn*,dyMWSv@9W+R W$z E a>PZ' );
define( 'LOGGED_IN_KEY',    '* d<NY?@pm(o~!Y!`$6[-wN/R*=JPR|5[~4>.5NHTA`FR:qG]r[aQHDC(u}_:A;j' );
define( 'NONCE_KEY',        'X MlGeAwkNTl_ogLtQNCPxyk`?x2{CjLOt?TjIkQ%T:s{tD(?N6t{obWnWo-Q^V ' );
define( 'AUTH_SALT',        'vcYF%ihy`.E,IgVI<YAhCAX;2J;9.cHe5qP^+B6Q]DctW{F6Gxs>79$1{hKH/[:m' );
define( 'SECURE_AUTH_SALT', 'r 5P!8n{UK|jsu@cKP086B:&k/nW%F|<M27|uebM-nqHb:%A?^8OQ`|0IZmsWP~N' );
define( 'LOGGED_IN_SALT',   '<yQp7kEs](]8rcuhq_Kl)-V1p=-A%7=TD9mBRlw7/q{%QNp/YJsTW(@UG}$Q<zT5' );
define( 'NONCE_SALT',       '/(:S)l7u!Qju<Ik(pW%P|ss^}aPrAeNz5btz/{bIg@ >>m*^YUz2rqS80oh1s6!`' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( ! defined( 'ABSPATH' ) )
  define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once( ABSPATH . 'wp-settings.php' );
