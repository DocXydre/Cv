<?php
include_once(ABSPATH . 'wp-admin/includes/plugin.php');
//Clé d'API (au début du fichier, important)
define( 'GMAP_API_KEY', 'AIzaSyBAEgvP6uG-mq332hbWXjL1gifMIirvTDM' );



////
//// CUSTOM FUNCTIONS ------------------------------------
////
function add_theme_scripts()
{
	$dist_path = '/assets/dist/';
	$dist_url = get_stylesheet_directory_uri() . $dist_path;
	$dist_folder = dirname(__FILE__) . '/assets/dist/';

	wp_enqueue_style('style', $dist_url . 'main.css', array(), filemtime($dist_folder . 'main.css'));
	wp_enqueue_script('app', $dist_url . 'main.js', array(), filemtime($dist_folder . 'main.js'));
}

function add_file_types_to_supported_uploads($file_types)
{
	$new_filetypes = array();
	$new_filetypes['svg'] = 'image/svg+xml';
	$file_types = array_merge($file_types, $new_filetypes);
	return $file_types;
}

function add_slug_body_class($classes)
{
	global $post;
	if (isset($post)) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}
	return $classes;
}

////
//// FILTERS ------------------------------------
////

add_filter('body_class', 'add_slug_body_class');

////
//// COMPOSER INITIALIZATION ------------------------------------
////
$composer_autoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($composer_autoload)) {
	require_once $composer_autoload;
	$timber = Timber\Timber::init();
}

////
//// TIMBER CHECK ------------------------------------
////
if (!class_exists('Timber')) {

	add_action(
		'admin_notices',
		function () {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url(admin_url('plugins.php#timber')) . '">' . esc_url(admin_url('plugins.php')) . '</a></p></div>';
		}
	);

	add_filter(
		'template_include',
		function ($template) {
			return get_stylesheet_directory() . '/static/no-timber.html';
		}
	);
	return;
}

////
//// TIMBER CONFIG ------------------------------------
////
Timber::$dirname = array('templates', 'views');
Timber::$autoescape = false;

////
//// SITE DEFINITION ------------------------------------
////
class StarterSite extends Timber\Site
{
	public function __construct()
	{
		// ACTION ---
		add_action('after_setup_theme', array($this, 'theme_supports'));
		add_action('wp_enqueue_scripts', 'add_theme_scripts');
		add_action('init', array($this, 'register_post_types'));
		add_action('init', array($this, 'register_taxonomies'));
		// FILTERS ---	
		add_filter('upload_mimes', 'add_file_types_to_supported_uploads');
		add_filter('timber/context', array($this, 'add_to_context'));
		add_filter('timber/twig', array($this, 'add_to_twig'));
		parent::__construct();
	}
	/** This is where you can register custom post types. */
	public function register_post_types() {
		// Custom Post Type pour les Formations
		register_post_type('formation', array(
			'labels' => array(
				'name' => 'Formations',
				'singular_name' => 'Formation',
				'add_new' => 'Ajouter une formation',
				'add_new_item' => 'Ajouter une nouvelle formation',
				'edit_item' => 'Modifier la formation',
				'new_item' => 'Nouvelle formation',
				'view_item' => 'Voir la formation',
				'search_items' => 'Rechercher des formations',
				'not_found' => 'Aucune formation trouvée',
				'not_found_in_trash' => 'Aucune formation trouvée dans la corbeille',
			),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-welcome-learn-more',
			'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
			'rewrite' => array('slug' => 'formations'),
			'show_in_rest' => true,
		));
		
		// Custom Post Type pour les Expériences Professionnelles
		register_post_type('experience', array(
			'labels' => array(
				'name' => 'Expériences',
				'singular_name' => 'Expérience',
				'add_new' => 'Ajouter une expérience',
				'add_new_item' => 'Ajouter une nouvelle expérience',
				'edit_item' => 'Modifier l\'expérience',
				'new_item' => 'Nouvelle expérience',
				'view_item' => 'Voir l\'expérience',
				'search_items' => 'Rechercher des expériences',
				'not_found' => 'Aucune expérience trouvée',
				'not_found_in_trash' => 'Aucune expérience trouvée dans la corbeille',
			),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-businessman',
			'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
			'rewrite' => array('slug' => 'experiences'),
			'show_in_rest' => true,
		));
		
		// Custom Post Type pour les Projets
		register_post_type('projet', array(
			'labels' => array(
				'name' => 'Projets',
				'singular_name' => 'Projet',
				'add_new' => 'Ajouter un projet',
				'add_new_item' => 'Ajouter un nouveau projet',
				'edit_item' => 'Modifier le projet',
				'new_item' => 'Nouveau projet',
				'view_item' => 'Voir le projet',
				'search_items' => 'Rechercher des projets',
				'not_found' => 'Aucun projet trouvé',
				'not_found_in_trash' => 'Aucun projet trouvé dans la corbeille',
			),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-portfolio',
			'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
			'rewrite' => array('slug' => 'projets'),
			'show_in_rest' => true,
		));
	}
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies() {}

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context($context)
	{
		$context['is_yoast_active'] = is_plugin_active('wordpress-seo/wp-seo.php');
		$context['menu'] = Timber::get_menu();
		return $context;
	}

	public function theme_supports()
	{
		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support('menus');
	}


	public function add_to_twig($twig)
	{
		$twig->addExtension(new Twig\Extension\StringLoaderExtension());
		$twig->addFilter(new Twig\TwigFilter('myfoo', array($this, 'myfoo')));
		return $twig;
	}

	}

////
//// SITE INITIALIZATION --------------------------------
////

new StarterSite();
