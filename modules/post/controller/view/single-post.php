<?php
get_header();
?>
<main id="site-content" role="main">
	<div class="nxfeed-content">
		<?php
		/* Start the Loop */
		while ( have_posts() ) :
			the_post();
			do_action( 'nextfeed_before_single_post' );
			$class = 'elementor summary';
			$class = apply_filters('nextfeed_post_class', $class);
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
				<?php
				do_action( 'nextfeed_single_post_content' );
				?>
			</article>
			<?php do_action( 'nextfeed_after_single_post' );?>
			<?php
		endwhile; 
		?>
	</div>
 </main>
<?php
get_footer();
