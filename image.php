<?php get_header(); ?>
    <div class="content">
        <div class="full">
        	<?php 
				while ( have_posts() ) : the_post();
						echo wp_get_attachment_image($attachment->ID, 'full');
				endwhile;
			?>
        </div>
    </div>
<?php get_footer(); ?>