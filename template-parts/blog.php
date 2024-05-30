<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tai
 */

?>

<h2 class="topai__article">
			Blog
		</h2>
		<div class="topai__row topai__blog">
			<?php
			 $current = absint(
                    max(
                        1,
                        get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'news' )
                    )
                );
$args = array(
	'posts_per_page' => 12,
	'orderby' => 'post_date',
	'category_name' => 'popular-vtubers',
	'paged'          => $current
);

$query = new WP_Query( $args );

// Цикл
if ( $query->have_posts() ) {
	
	while ( $query->have_posts() ) {
		$query->the_post();
		echo '<div class="topai__item topai__blog-item"><a href="' . get_permalink() . '" class="topai__link">' . get_the_post_thumbnail() . '</a><a href="' . get_permalink() . '" class="topai__link"><h4 class="topai__title">' . esc_html( get_the_title() ) . '</h4><p class="topai__text">' . get_the_excerpt() . '</p></a><div class="author"><div class="author__info">' . get_avatar( get_the_author_meta('user_email'), 32 ) . '<a href="' . get_the_author_link() . '" class="author__link"><p class="author__name">' . get_the_author() . '</p></a></div><div class="author__data">' . the_date() . '</div></div></div>';
	}

}
else {
	// Постов не найдено
}

wp_reset_postdata();
		 ?>
		
		 <div class="topai__row">
		 <?php echo do_shortcode( '[ajax_load_more post_type="post" posts_per_page="8" category="popular-vtubers" category__not_in="158,1" offset="12"]' ); ?>
		</div>
		<!-- <div class="topai__btn topai__mr"><a href="" class="topai__btn-link  btn">View More</a></div> -->
		<!-- #post-<?php the_ID(); ?> -->
