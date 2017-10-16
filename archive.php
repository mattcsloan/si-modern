<?php
if(is_category('news')) {
	header("Location: /company/news",TRUE,301);
}
?>
<?php get_header(); ?>
    <div class="content listings">
        <div class="main entry-content">
		<?php the_post(); ?>         
 
		<?php if ( is_day() ) : ?>
                        <h1><?php printf( __( 'Daily Archives: <span>%s</span>', 'si-modern' ), get_the_time(get_option('date_format')) ) ?></h1>
        <?php elseif ( is_month() ) : ?>
                        <h1><?php printf( __( 'Monthly Archives: <span>%s</span>', 'si-modern' ), get_the_time('F Y') ) ?></h1>
        <?php elseif ( is_year() ) : ?>
                        <h1><?php printf( __( 'Yearly Archives: <span>%s</span>', 'si-modern' ), get_the_time('Y') ) ?></h1>
        <?php elseif ( is_author() ) : ?>
                        <h1><?php echo 'All posts by: <span>'.get_the_author().'</span>'; ?></h1>
        <?php elseif ( is_category() ) : ?>
                        <h1><?php echo 'All posts under the: <span>'; echo single_cat_title(); echo '</span> category'; ?></h1>
        <?php elseif ( is_tag() ) : ?>
                        <h1><?php echo 'All posts tagged with: <span>'; echo single_tag_title(); echo '</span>'; ?></h1>
        <?php elseif ( isset($_GET['paged']) && !empty($_GET['paged']) ) : ?>
                        <h1><?php _e( 'Blog Archives', 'si-modern' ) ?></h1>
        <?php endif; ?>
		<?php 
            global $numposts;
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			global $query_string;
			query_posts($query_string . '&cat=-6'); //excludes news articles
		?>
		<?php if ( $wp_query->have_posts() ) { ?>
            <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
            <div class="article intro">
                <?php
				if ( has_post_thumbnail() ) {
				?>
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail(); ?>
                	</a>
                    <div class="article_content">
                <?php
				} else {
				?>
					<div class="article_content no_image">
                <?php
				}
				?>
                    <h1><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s', 'si-modern'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
                    <span class="article_date"><?php the_time( get_option( 'date_format' ) ); ?></span>
                    <h5>by <a href="<?php echo get_author_link( false, $authordata->ID, $authordata->user_nicename ); ?>" title="<?php printf( __( 'View all posts by %s', 'si-modern' ), $authordata->display_name ); ?>"><?php the_author(); ?></a></h5>
                    <p><?php the_excerpt(); ?></p>
                    <div class="share">
                        <span class="helper">Share:</span> 
                        <div class="addthis_toolbox addthis_default_style addthis_16x16_style" addthis:title="<?php the_title(); ?>" addthis:url="<?php the_permalink(); ?>">
                            <a class="addthis_button_facebook"></a>
                            <a class="addthis_button_twitter"></a>
                            <a class="addthis_button_linkedin"></a>
                            <a class="addthis_button_google_plusone_share"></a>
                            <a class="addthis_button_email"></a>
                        </div>
                    </div>
                    <?php edit_post_link( __( 'Edit', 'si-modern' ), '<span class="edit-link">', '</span>' ); ?>
                </div>
            </div>
            <?php endwhile; ?>
			<?php /* Bottom post navigation */ 
                $total_pages = $wp_query->max_num_pages;
                if ( $total_pages > 1 ) {
            ?>
                    <div class="pagination">
                        <?php previous_posts_link('<span class="prev"></span>') ?>
                        <?php echo 'Page '.$paged.' of '. $wp_query->max_num_pages; ?>
                        <?php next_posts_link('<span class="next"></span>') ?>
                    </div>
            <?php } ?> 
		<?php } ?>
        </div>
        <div class="secondary">
            <?php get_sidebar(); ?>
        </div>
    </div>
	<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-533249964ea292fb"></script>
<?php get_footer(); ?>