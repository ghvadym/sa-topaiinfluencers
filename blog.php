<?php
/*
Template Name: blog
Template Post Type: post, page, product
*/

get_header();
?>
	<div class="main">
		<div class="page">
	<section class="topai">
		<?php
while( have_posts() ) : the_post();
 
		get_template_part( 'template-parts/blog' );
 
	endwhile;
		?>
	</section>

		</div>
	</div>
<?php
get_sidebar();
get_footer();