<?php 
/*
Template Name: top 10
Template Post Type: post, page, product
*/


get_header();
?>
	<div class="main">
		<div class="page">

			<?php the_content(); ?>

			<div class="table">
				<div class="table__row first-row">
					<div class="table__numb">#</div>
				<div class="table__title">Influencer</div>
				<div class="table__social">
				<div class="table__icons"><a href="#"><img src="/wp-content/themes/tai/img/instagram.png" alt="" class="table__icon"></a></div>
				<div class="table__icons"><a href="#"><img src="/wp-content/themes/tai/img/facebook.png" alt="" class="table__icon"></a></div>
				<div class="table__icons"><a href="#"><img src="/wp-content/themes/tai/img/tik.png" alt="" class="table__icon"></a></div>
				<div class="table__icons"><a href="#"><img src="/wp-content/themes/tai/img/x.png" alt="" class="table__icon"></a></div>
				<div class="table__icons"><a href="#"><img src="/wp-content/themes/tai/img/twich.png" alt="" class="table__icon"></a></div>
				<div class="table__icons"><a href="#"><img src="/wp-content/themes/tai/img/youtube.png" alt="" class="table__icon"></a></div>
			</div>
				</div>

	<?php echo do_shortcode( '[tai_posts_table]' ); ?>
	
</div>
<section class="topai">
		<h2 class="topai__article">
			More Post
		</h2>
		<div class="topai__row">
			<?php
        $args = array(
        	'posts_per_page' => 4,
        	'orderby' => 'comment_count',
        	'category_name' => 'popular-vtubers'
        );

$query = new WP_Query( $args );

            if ( $query->have_posts() ) {
            	
            	while ( $query->have_posts() ) {
            		$query->the_post();
            		echo '<div class="topai__item"><a href="' . get_permalink() . '" class="topai__link">' . get_the_post_thumbnail() . '</a><a href="' . get_permalink() . '" class="topai__link"><h4 class="topai__title">' . esc_html( get_the_title() ) . '</h4><p class="topai__text">' . get_the_excerpt() . '</p></a><div class="author"><div class="author__info">' . get_avatar( get_the_author_meta('user_email'), 32 ) . '<a href="' . get_the_author_link() . '" class="author__link"><p class="author__name">' . get_the_author() . '</p></a></div><div class="author__data">' . the_date() . '</div></div></div>';
            	}
            
            }
            else {
            	
            }
            
            wp_reset_postdata();
            		 ?>
			</div>
		
	</section>
			</div>
	</div>
<?php

get_footer();
