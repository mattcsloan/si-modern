
<?php get_header(); ?>
    <div class="content">
    	<div class="secondary">
			<?php
				$children = wp_list_pages("title_li=&child_of=32&depth=1&echo=0");
                if ($children) { ?>
                    <div class="secondary_nav dark">
                        <h3 class="secondary_nav_title">
                        Company
                        <span> Menu</span></h3>
                        <ul>
                            <?php echo $children; ?>
                        </ul>
                    </div>
            <?php } ?>
            <?php get_sidebar('news'); ?>
        </div>
        <div class="main">
        	<?php while ( have_posts() ) : the_post(); ?>
                <div class="article news_article">
                    <div class="article_heading">
                        <h1><?php the_title(); ?></h1>
                        <span class="article_date"><?php the_time( get_option( 'date_format' ) ); ?></span>
                        <div class="share">
                            <div class="addthis_toolbox addthis_default_style addthis_16x16_style">
                                <a class="addthis_button_facebook"></a>
                                <a class="addthis_button_twitter"></a>
                                <a class="addthis_button_linkedin"></a>
                                <a class="addthis_button_google_plusone_share"></a>
                                <a class="addthis_button_email"></a>
                            </div>
                        	<span class="helper">Share:</span> 
                        </div>
                    </div>
                    <?php the_content(); ?>
                    <div class="share large">
                        <span class="helper">Share this article:</span>
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
                </div>
			<?php endwhile; // end of the loop. ?>
            
        </div>
    </div>
	<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-533249964ea292fb"></script>
<?php get_footer(); ?>