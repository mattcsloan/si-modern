<?php get_header(); ?>
    <div class="content">
        <div class="main">
        	<?php while ( have_posts() ) : the_post(); ?>
                <div class="article">
                    <h1><?php the_title(); ?></h1>
                    <div class="article-meta">
                        <span class="article-date">
                            <i class="icon-calendar"></i>
                            <?php the_time( get_option( 'date_format' ) ); ?>
                        </span>
                        <span class="article-author">
                            <?php echo get_avatar($authordata->ID, $size = '64'); ?>
                            <span>by <a href="<?php echo get_author_link( false, $authordata->ID, $authordata->user_nicename ); ?>" title="<?php printf( __( 'View all posts by %s', 'si-modern' ), $authordata->display_name ); ?>"><?php the_author(); ?></a></span>
                        </span>
                    </div>
                    <?php the_post_thumbnail('feature_image', array('class' => 'featured-image article-cover')); ?>
                    <?php $commentsNumber = get_comments_number(); ?>
                    <div class="share-bar <?php if($commentsNumber > 0) { echo 'with-comments'; } ?>">
                        <div class="share">
                            <!-- AddThis Button BEGIN -->
                            <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
                                <a class="addthis_button_facebook"></a>
                                <a class="addthis_button_twitter"></a>
                                <a class="addthis_button_linkedin"></a>
                                <a class="addthis_button_google_plusone_share"></a>
                                <a class="addthis_button_email"></a>
                            </div>
                            <!-- AddThis Button END -->
                        </div>
                        <?php if($commentsNumber > 0) { ?>
                            <a class="comment-counter btn btn-outline btn-small btn-light-gray" href="<?php comments_link(); ?>"><?php comments_number( 'No Comments', '1 Comment', '% Comments' ); ?></a>
                        <?php } ?>
                    </div>
                    <?php the_content(); ?>
                    
    
                    
                    <div class="share large">
                        <!-- AddThis Button BEGIN -->
                        <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
                            <a class="addthis_button_facebook"></a>
                            <a class="addthis_button_twitter"></a>
                            <a class="addthis_button_linkedin"></a>
                            <a class="addthis_button_google_plusone_share"></a>
                            <a class="addthis_button_email"></a>
                        </div>
                        <!-- AddThis Button END -->
                    </div>
                    <div class="tags">
                        <?php the_tags('<span>Tagged with:</span>', ''); ?>
                    </div>

                    <?php if(is_single()) { echo get_related_author_posts(); } ?>

                </div>
			<?php endwhile; // end of the loop. ?>
        </div>
    </div>
    <?php get_sidebar(); ?>
    <?php comments_template( '/comments.php', true ); ?>
	<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-533249964ea292fb"></script>
<?php get_footer(); ?>