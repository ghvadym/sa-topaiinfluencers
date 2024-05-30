<?php
/*
Template Name: vtubers
Template Post Type: post, page, product
*/

get_header();
?>
<div class="main">
		<div class="page">
	<section class="vtubers">
		<h2 class="vtubers__article">Best VTubers</h2>
		<!-- <div class="vtubers__filter">
			<select name="" id="">
				<option value="Social Media">Social Media</option>
			</select>
			<select name="" id="">
				<option value="Subscribers">Subscribers</option>
			</select>
			<select name="" id="">
				<option value="Niches">Niches</option>
			</select>
			<select name="" id="">
				<option value="Language">Language</option>
			</select>
		</div> -->
		<div class="vtubers__row">
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
	'paged' => $current
);

$query = new WP_Query( $args );

// Цикл
if ( $query->have_posts() ) {
	
	while ( $query->have_posts() ) {
		$query->the_post();
		echo '<div class="vtubers__box"><a href="' . get_permalink() . '" class="vtubers__link"><div class="vtubers__image">' . get_the_post_thumbnail() . '</div><h4 class="vtubers__title">' . esc_html( get_the_title() ) . '</h4></a></div>';
	}

}
else {
	// Постов не найдено
}
?>
</div>

                    <?php

wp_reset_postdata();
		 ?>
		 <div class="topai__row topai__vtuber">
		 <?php echo do_shortcode( '[ajax_load_more post_type="post" posts_per_page="8" category="popular-vtubers" category__not_in="158,1" offset="12"]' ); ?>
		</div>
		<!-- <div class="topai__btn"><a href="" class="topai__btn-link btn">Lazy load</a></div> -->
	</section>

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