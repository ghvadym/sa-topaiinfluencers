<?php
/**
 * tai functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package tai
 */

if ( ! defined( 'TAI_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'TAI_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function tai_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on tai, use a find and replace
		* to change 'tai' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'tai', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'tai' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'tai_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'tai_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function tai_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'tai_content_width', 640 );
}
add_action( 'after_setup_theme', 'tai_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function tai_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'tai' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'tai' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'tai_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function tai_scripts() {
	wp_enqueue_style( 'tai-style', get_stylesheet_uri(), array(), TAI_VERSION );
	wp_style_add_data( 'tai-style', 'rtl', 'replace' );

	wp_enqueue_script( 'tai-navigation', get_template_directory_uri() . '/js/navigation.js', array(), TAI_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'tai_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

function my_theme_enqueue_styles() {
    wp_enqueue_style( 'my-theme-style', get_stylesheet_uri() );
 wp_enqueue_style('my-theme-extra-style', get_theme_file_uri('style-new.css') );
}

 
function true_loadmore_scripts() {
	wp_enqueue_script( 'jquery' ); // в TwentyTwentyOne он не подключен по умолчанию
 
 	wp_register_script( 
		'true_loadmore', 
		get_stylesheet_directory_uri() . '/loadmore.js', 
		array( 'jquery' ),
		time() // не кэшируем файл, убираем эту строчку после завершение разработки
	);
 
	wp_localize_script( 
		'true_loadmore', 
		'misha', 
		array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) )
	);
 
	wp_enqueue_script( 'true_loadmore' );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

add_action( 'wp_enqueue_scripts', 'true_loadmore_scripts' );

function true_loadmore() {
 
	 $paged = ! empty( $_POST[ 'paged' ] ) ? $_POST[ 'paged' ] : 1;
	$paged++;
$args = array(
	'posts_per_page' => 12,
	'orderby' => 'post_date',
	'category_name' => 'popular-vtubers',
	'paged'          => $paged
);

$query = new WP_Query( $args );

// Цикл


	query_posts( $args );
 
	while( have_posts() ) : the_post();
		
		echo '<div class="topai__item"><a href="' . get_permalink() . '" class="topai__link">' . get_the_post_thumbnail() . '</a><a href="' . get_permalink() . '" class="topai__link"><h4 class="topai__title">' . esc_html( get_the_title() ) . '</h4><p class="topai__text">' . get_the_excerpt() . '</p></a><div class="author"><div class="author__info">' . get_avatar( get_the_author_meta('user_email'), 32 ) . '<a href="' . get_the_author_link() . '" class="author__link"><p class="author__name">' . get_the_author() . '</p></a></div><div class="author__data">' . the_date() . '</div></div></div>';
	endwhile;
	die;
 
}
add_action( 'wp_ajax_loadmore', 'true_loadmore' );
add_action( 'wp_ajax_nopriv_loadmore', 'true_loadmore' );

function tai_posts_table_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'category_name' => 'best-ai-models',
            'orderby' => 'post_date',
            'posts_per_page' => 10,
        ),
        $atts,
        'tai_posts_table'
    );

    $args = array(
        'category_name' => $atts['category_name'],
        'orderby' => $atts['orderby'],
        'posts_per_page' => $atts['posts_per_page'],
        'fields' => 'ids', // Retrieve only post IDs for better performance
    );
 $i = 1;
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start(); // Start output buffering
        ?>
        <div class="table">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="table__row">
                    <div class="table__numb"><?php echo $i++; ?></div>
                    <div class="table__title">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php echo esc_url(get_permalink()); ?>">
                                <?php the_post_thumbnail('thumbnail'); ?>
                            </a>
                        <?php endif; ?>
                        <h3><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a></h3>
                    </div>
                    <?php
                    $card = get_field('card'); // Get the value of the 'card' field from ACF
                    if ($card) :
                        ?>
                        <div class="table__social">
                            <?php
                            foreach (array('instagram', 'tiktok', 'facebook', 'twitter', 'youtube', 'twitch') as $platform) {
                                if (!empty($card[$platform])) {
                                    echo '<div class="table__icons"><a href="' . esc_url($card[$platform]) . '">' . ucfirst($platform) . '</a></div>';
                                }
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
        <?php
        ob_end_flush(); // Output the buffered content
    } else {
        // 'Посты не найдены';
    }

    wp_reset_postdata();
}

add_shortcode('tai_posts_table', 'tai_posts_table_shortcode');



