<?php get_header(); ?>
    <div class="content listings">
        <div class="main">
			<?php if ( have_posts() ) : ?>
                <h1><?php _e( 'Articles tagged with: ', 'si-modern' ); ?><span><?php single_tag_title() ?></span></h1>
				<?php while ( have_posts() ) : the_post() ?>
                    <div class="article intro">
                        <div class="article_content">
                            <h1><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s', 'si-modern'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
                            <span class="article_date"><?php the_time( get_option( 'date_format' ) ); ?></span>
                            <h5>by <a href="<?php echo get_author_link( false, $authordata->ID, $authordata->user_nicename ); ?>" title="<?php printf( __( 'View all posts by %s', 'si-modern' ), $authordata->display_name ); ?>"><?php the_author(); ?></a></h5>
                            <?php the_excerpt( __( 'Read More <span class="meta-nav">&amp;raquo;</span>', 'si-modern' )  ); ?>
                            <?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'si-modern' ) . '&amp;after=</div>') ?>
                            <?php edit_post_link( __( 'Edit', 'si-modern' ), '<span class="meta-sep"> | </span><span class="edit-link">', '</span>' ); ?>
                            <?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'si-modern' ) . '&amp;after=</div>') ?>
                        </div>
                    </div>
                <?php endwhile; ?>
				<?php /* Bottom post navigation */ ?>
                <?php global $wp_query; $total_pages = $wp_query->max_num_pages; if ( $total_pages > 1 ) { ?>
                    <div class="pagination">
                        <!--<a class="prev" href="#"></a>-->
                        <?php next_posts_link(__( '<span class="meta-nav">&amp;laquo;</span> Older posts', 'si-modern' )) ?>
                        Page 1 of 6
                        <?php previous_posts_link(__( 'Newer posts <span class="meta-nav">&amp;raquo;</span>', 'si-modern' )) ?>
                        <!--<a class="next" href="#"></a>-->
                    </div>
                <?php } ?>
			<?php else : ?>
                <h1><?php _e( 'Your search did not return any results', 'si-modern' ); ?></h1>
                <p><?php _e( 'Sorry, we were unable to find what you were looking for. Please try another seach term', 'si-modern' ); ?></p>
                <?php get_search_form(); ?>
			<?php endif; ?> 
        </div>
        <div class="secondary">
            <?php get_sidebar(); ?>
        </div>
    </div>
<?php get_footer(); ?>