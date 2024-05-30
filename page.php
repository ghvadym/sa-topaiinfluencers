<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tai
 */

get_header();
?>


    <div class="page">
        <!-- <header>
            <div class="nav-section">
                <div class="nav-section__logo"><img src="img/logo.png" alt=""></div>
                <div class="nav-section__menus">
                    <ul class="nav-section__menu">
                        <li class="nav-section"><a href="">AI Influencers</a></li>
                        <li class="nav-section"><a href="">Vtubers</a></li>
                        <li class="nav-section"><a href="">Influence Platform</a></li>
                        <li class="nav-section"><a href="">Top 10</a></li>
                        <li class="nav-section"><a href="">About Us</a></li>
                        <li class="nav-section"><a href="">Blog</a></li>
                    </ul>
                </div>
                <div class="nav-section__button"><a href="" class="btn">Partnership</a></div>
            </div>
        </header> -->
        <section class="top-section">
            <div class="container">
                <div class="top-section__banner">
                    <div class="top-section__article">
                        <h1 class="top-section__title">Influencer marketing, by the numbers</h1>
                        <p class="top-section__subtitle">The easiest engagement rate calculator and fake followers check</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="social">
            <div class="container">
                <div class="social__row">
                    <div class="social__item">
                        <a href="#" class="social__link"><img src="/wp-content/themes/tai/img/instagram.png" alt="" class="social__icon"></a>
                        <a href="#" class="social__link"><img src="/wp-content/themes/tai/img/facebook.png" alt="" class="social__icon"></a>
                        <a href="#" class="social__link"><img src="/wp-content/themes/tai/img/tik.png" alt="" class="social__icon"></a>
                        <a href="#" class="social__link"><img src="/wp-content/themes/tai/img/x.png" alt="" class="social__icon"></a>
                        <a href="#" class="social__link"><img src="/wp-content/themes/tai/img/twich.png" alt="" class="social__icon"></a>
                        <a href="#" class="social__link"><img src="/wp-content/themes/tai/img/youtube.png" alt="" class="social__icon"></a>
                    </div>
                </div>
            </div>
        </section>
        <section class="influencers">
            <div class="container">
                <h2 class="influencers__article">AI Influencers</h2>

                <div class="influencers__row">
                    <?php
                    $args = [
                        'posts_per_page' => 8,
                        'orderby'        => 'comment_count',
                        'category_name'  => 'ai-influencers-list',
                    ];

                    $query = new WP_Query($args);

                    // Цикл
                    if ($query->have_posts()) {

                        while ($query->have_posts()) {
                            $query->the_post();
                            echo '<div class="influencers__box"><a href="' . get_permalink() . '" class="influencers__link"><div class="influencers__image">' . get_the_post_thumbnail() . '</div><h4 class="influencers__title">' . esc_html(get_the_title()) . '</h4></a></div>';
                        }

                    } else {
                        // Постов не найдено
                    }

                    wp_reset_postdata();
                    ?>

                </div>
                <div class="topai__btn"><a href="/ai-influencers" class="topai__btn-link btn">View All Influencers</a></div>
            </div>
        </section>
        <section class="vtubers">
            <div class="container">
                <h2 class="vtubers__article">VTubers</h2>
                <div class="vtubers__row">
                    <?php
                    $args = [
                        'posts_per_page' => 8,
                        'orderby'        => 'comment_count',
                        'category_name'  => 'popular-vtubers',
                    ];

                    $query = new WP_Query($args);

                    // Цикл
                    if ($query->have_posts()) {

                        while ($query->have_posts()) {
                            $query->the_post();
                            echo '<div class="vtubers__box"><a href="' . get_permalink() . '" class="vtubers__link"><div class="vtubers__image">' . get_the_post_thumbnail() . '</div><h4 class="vtubers__title">' . esc_html(get_the_title()) . '</h4></a></div>';
                        }

                    } else {
                        // Постов не найдено
                    }

                    wp_reset_postdata();
                    ?>

                </div>
                <div class="topai__btn"><a href="/vtubers" class="topai__btn-link btn">View All VTubers</a></div>
            </div>
        </section>
        <section class="topai">
            <div class="container">
                <h2 class="topai__article">
                    Top AI Influencers in Niches
                </h2>
                <div class="topai__row">
                    <?php
                    $args = [
                        'posts_per_page' => 4,
                        'orderby'        => 'comment_count',
                        'category_name'  => 'popular-vtubers',
                    ];

                    $query = new WP_Query($args);

                    // Цикл
                    if ($query->have_posts()) {

                        while ($query->have_posts()) {
                            $query->the_post();
                            echo '<div class="topai__item"><a href="' . get_permalink() . '" class="topai__link">' . get_the_post_thumbnail() . '</a><a href="' . get_permalink() . '" class="topai__link"><h4 class="topai__title">' . esc_html(get_the_title()) . '</h4><p class="topai__text">' . wp_trim_words(get_the_excerpt(), 25, '...') . '</p></a><div class="author"><div class="author__info">' . get_avatar(get_the_author_meta('user_email'),
                                    32) . '<a href="' . get_the_author_link() . '" class="author__link"><p class="author__name">' . get_the_author() . '</p></a></div><div class="author__data">' . date('M d, Y', strtotime($query->post->post_date)) . '</div></div></div>';
                        }

                    } else {
                        // Постов не найдено
                    }

                    wp_reset_postdata();
                    ?>
                </div>
                <div class="topai__btn"><a href="/blog/" class="topai__btn-link  btn">View More Posts</a></div>
            </div>
        </section>
        <section class="faq">
            <div class="container">
                <h2 class="faq__article">FAQs</h2>
                <div class="faq__block">
                    <div class="faq__item">
                        <h4 class="faq__title">What is NFT?</h4>
                        <p class="faq__text">NFT stands for non-fungible token. It is a type of digital asset that represents ownership or proof of authenticity of a unique item, such
                            as a
                            piece of artwork, music, video, or even a tweet. Unlike cryptocurrencies such as Bitcoin, NFTs cannot be exchanged for an equal value because each NFT is
                            one-of-a-kind, making them valuable to collectors and enthusiasts. NFTs are typically created and traded on blockchain platforms such as Ethereum, where
                            ownership and transaction history are recorded on a decentralized ledger. If you want to know ‘what is NFT?’ to find out why there is so much going on around
                            this new technology, read this article.</p>
                    </div>
                    <div class="faq__item">
                        <h4 class="faq__title">What is NFT Music?</h4>
                        <p class="faq__text">NFTs are popular digital assets stored on the blockchain that occupy a huge place in the contemporary financial world, but what is NFT
                            music?
                            Read this short article to find out in detail what exactly NFT music is and how to purchase and use them.</p>
                    </div>
                    <div class="faq__item">
                        <h4 class="faq__title">How to Buy NFT on OpenSea?</h4>
                        <p class="faq__text"> OpenSea helps buyers and sellers of NFT meet and trade and is also a showroom for the disruptive technology that transforms the definition
                            of
                            an asset. Continue reading to get familiar with the concept of NFT, learn how to buy NFT on OpenSea, and be a part of this transformation.</p>
                    </div>
                    <div class="faq__item">
                        <h4 class="faq__title">How to Promote NFT?</h4>
                        <p class="faq__text">Have you ever wondered how exactly you might promote NFL art and NFT games? The good news is that you are about to learn about where to
                            promote
                            NFT, utilize NFT advertising, and how to advertise NFT projects.</p>
                    </div>
                </div>
            </div>
        </section>

    </div>


<?php
get_sidebar();
get_footer();
