<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package tai
 */

get_header();
?>

	<div class="main">
		<div class="page">
	<section class="post post-single">

	<?php 
$image = get_field('banner');
if( !empty( $image ) ): ?>
	<div class="post__banner">
    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
    </div>
<?php endif; ?> 

	
			
			<?php
$card = get_field('card');
if( $card ): ?>
		<div class="post__content-single">
    <div class="post__content-row">
        <img src="<?php echo esc_url( $card['image']['url'] ); ?>" alt="<?php echo esc_attr( $card['image']['alt'] ); ?>" />
        <div class="content-block">
            <h3><?php echo  $card['title']; ?></h3>
            <div class="post__social">
            	<div class="post__social-item instagram btn"><i></i><?php echo $card['instagram']; ?></div>
            	<div class="post__social-item tiktok btn"><i></i><?php echo $card['tiktok']; ?></div>
            	<div class="post__social-item facebook btn"><i></i><?php echo $card['facebook']; ?></div>
            	<div class="post__social-item twitter btn"><i></i><?php echo $card['twitter']; ?></div>
            	<div class="post__social-item youtube btn"><i></i><?php echo $card['youtube']; ?></div>
            	<div class="post__social-item twich btn"><i></i><?php echo $card['twich']; ?></div>
            </div>
            <div class="post__btn"><a href="<?php echo esc_url( $card['button'] ); ?>" class="btn">Get in Touch</a></div>
        </div>
    </div>
    </div>
<?php endif; ?>
		
		<?php

// Check rows exists.
if( have_rows('postblock') ):

    // Loop through rows.
    while( have_rows('postblock') ) : the_row(); ?>

       	<div class="post__content-single">

       <?php // Load sub field value.
        $contents = get_sub_field('postbox');
        echo $contents;
        // Do something, but make sure you escape the value if outputting directly...
?>  </div> <?php
    // End loop.
    endwhile;

// No value.
else :
    // Do something...
endif;
?>
	
			
		
	</section>

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'tai' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'tai' ) . '</span> <span class="nav-title">%title</span>',
				)
			);

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>
		<section class="faq">
		<h2 class="faq__article">FAQs</h2>
		<div class="faq__block">
			<div class="faq__item">
				<h4 class="faq__title">What is NFT?</h4>
				<p class="faq__text">NFT stands for non-fungible token. It is a type of digital asset that represents ownership or proof of authenticity of a unique item, such as a piece of artwork, music, video, or even a tweet. Unlike cryptocurrencies such as Bitcoin, NFTs cannot be exchanged for an equal value because each NFT is one-of-a-kind, making them valuable to collectors and enthusiasts. NFTs are typically created and traded on blockchain platforms such as Ethereum, where ownership and transaction history are recorded on a decentralized ledger. If you want to know ‘what is NFT?’ to find out why there is so much going on around this new technology, read this article.</p>
			</div>
			<div class="faq__item">
				<h4 class="faq__title">What is NFT Music?</h4>
				<p class="faq__text">NFTs are popular digital assets stored on the blockchain that occupy a huge place in the contemporary financial world, but what is NFT music? Read this short article to find out in detail what exactly NFT music is and how to purchase and use them.</p>
			</div>
			<div class="faq__item">
				<h4 class="faq__title">How to Buy NFT on OpenSea?</h4>
				<p class="faq__text"> OpenSea helps buyers and sellers of NFT meet and trade and is also a showroom for the disruptive technology that transforms the definition of an asset. Continue reading to get familiar with the concept of NFT, learn how to buy NFT on OpenSea, and be a part of this transformation.</p>
			</div>
			<div class="faq__item">
				<h4 class="faq__title">How to Promote NFT?</h4>
				<p class="faq__text">Have you ever wondered how exactly you might promote NFL art and NFT games? The good news is that you are about to learn about where to promote NFT, utilize NFT advertising, and how to advertise NFT projects.</p>
			</div>
		</div>
	</section>
	</div>
</div>

<?php
get_sidebar();
get_footer();
