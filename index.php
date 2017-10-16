<?php get_header(); ?>
    <div class="hero">
        <span class="section-title"><?php wp_title(); ?></span>
    </div>
    <div class="content wrapper listings">
        <div class="entry-content">
        	<?php $query = new WP_Query( 'category__not_in=6' ); //exclude news articles?>
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <div class="article intro">
                <?php
				if ( has_post_thumbnail() ) {
				?>
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail('large-feature', array('class' => 'featured-image')); ?>
                	</a>
                    <div class="article-content">
                <?php
				} else {
				?>
					<div class="article-content no-image">
                <?php
				}
				?>
                    <h2><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s', 'si-modern'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                    <span class="article-author">
                        <?php echo get_avatar($authordata->ID, $size = '64'); ?>
                        <span>by <a href="<?php echo get_author_link( false, $authordata->ID, $authordata->user_nicename ); ?>" title="<?php printf( __( 'View all posts by %s', 'si-modern' ), $authordata->display_name ); ?>"><?php the_author(); ?></a></span>
                    </span>
                    <span class="article-date">
                        <i class="icon-calendar"></i>
                        <?php the_time( get_option( 'date_format' ) ); ?>
                    </span>
                    <?php the_excerpt(); ?>
                    <a class="btn btn-outline" href="<?php the_permalink(); ?>">Read More</a>
                </div>
            </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>
        <!--
        <div class="secondary">
            <?php get_sidebar(); ?>
        </div>
        -->
    </div>
    <?php global $wp_query; $total_pages = $wp_query->max_num_pages; if ( $total_pages > 1 ) { ?>
        <div class="pagination">
            <div class="wrapper">
                <?php previous_posts_link(__( 'Prev', 'si-modern' )) ?>
                <?php echo 'Page '.$paged.' of '. $wp_query->max_num_pages; ?>
                <?php next_posts_link(__( 'Next', 'si-modern' )) ?>
            </div>
        </div>
    <?php } ?>
	<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-533249964ea292fb"></script>
<?php get_footer(); ?>