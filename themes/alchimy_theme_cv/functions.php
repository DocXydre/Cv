<?php
include_once(ABSPATH . 'wp-admin/includes/plugin.php');

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
	public function register_post_types() {}
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
