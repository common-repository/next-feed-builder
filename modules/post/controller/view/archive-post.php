<?php
get_header();
?>
<main id="site-content" role="main">
	<div class="nxfeed-content">
        <?php if ( have_posts() ) : ?>
            <header class="nx-pageheader">
                <?php
                the_archive_title( '<h2>', '</h2>' );
                ?>
            </header>
            <?php
            /* Start the Loop */
            do_action( 'nextfeed_before_archive_post' );
            while ( have_posts() ) :
                the_post();
                
                $class = 'nxfeed-archive';
                $class = apply_filters('nextfeed_post_class', $class);
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
                    <?php
                    do_action( 'nextfeed_archive_post_content' );
                    ?>
                </article>
                
                <?php
            endwhile; 
            ?>
        <?php do_action( 'nextfeed_after_archive_post' );?>
        <?php else : ?>
            <div class="not-found">
                <h1><?php esc_html_e('Nothing found!', 'marketo'); ?></h1>
                <p><?php esc_html_e('It looks like nothing was found here. Maybe try a search?','marketo')?></p>
                <div class="search-forms"> <?php get_search_form(); ?></div>
            </div> 
        <?php endif; ?>
	</div>
</main>
<?php
get_footer();
