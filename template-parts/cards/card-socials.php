<?php
$socials = [
    'instagram',
    'tiktok',
    'X',
    'twitch',
    'youtube'
];
?>

<div class="article__socials">
    <?php foreach ($socials as $social) { ?>
        <div class="article__social">
            <?php get_svg($social); ?>
            <span>2.3M</span>
        </div>
    <?php } ?> 
</div>
