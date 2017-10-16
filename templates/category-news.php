<?php
/*
Template Name: News Posts Only
*/
?>
    <?php get_header(); ?>

    <?php
        if($post->post_parent) {
            $ancestors = get_post_ancestors($post->ID);
            $ancestorsTest = false;
            if($ancestors[1]) {
                $children = wp_list_pages("title_li=&child_of=".$ancestors[1]."&echo=0");
                $ancestorsTest = true;
            } else {
                $children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0");
            }
        } else {
            $children = wp_list_pages("title_li=&child_of=".$post->ID."&depth=1&echo=0");
        }

        if($ancestorsTest) {
            $parent_post = get_post($ancestors[1]); //gets the parent post based on the id number passed through
        } else {
            $parent_post = get_post($post->post_parent); //gets the parent post based on the id number passed through
        }
        $parent_post_title = $parent_post->post_title; //gets the parent page's title
    ?>

    <div class="hero">
        <?php if ($children) { ?>
            <span class="section-title"><?php echo $parent_post_title; ?></span>
            <div class="secondary-nav dark">
                <div class="wrapper">
                    <a class="menu-link" href="#"><?php echo $parent_post_title; ?> Menu</a>
                    <ul class="mobile-menu">
                        <?php echo $children; ?>
                    </ul>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="content wrapper">
        <div class="main">
			<?php 
                global $numposts;
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $wp_query = new WP_Query( 'cat=6&posts_per_page='.$numposts.'&paged=' . $paged); //only show news articles, posts_per_page is determined by Settings > Readings
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
                            <span class="article_date"><?php the_time( get_option( 'date_format' ) ); ?></span>
                            <h1><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s', 'si-modern'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
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
                            <?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'si-modern' ) . '&amp;after=</div>') ?>
                            <?php edit_post_link( __( 'Edit', 'si-modern' ), '<span class="meta-sep"> | </span><span class="edit-link">', '</span>' ); ?>
                            <?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'si-modern' ) . '&amp;after=</div>') ?>
                        </div>
                    </div>
				<?php endwhile; ?>






            <?php } ?>
        </div>
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