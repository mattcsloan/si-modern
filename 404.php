<?php get_header(); ?>
    <div class="content">
        <div class="main">
			<div id="post-0" class="post error404 not-found">
                <h1><?php _e( 'Not Found', 'si-modern' ); ?></h1>
                <p><?php _e( 'Sorry, we were unable to find what you were looking for. Perhaps searching will help.', 'si-modern' ); ?></p>
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>