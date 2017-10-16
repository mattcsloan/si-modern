<?php
	//We don't want the user to see the main page if that page has child pages. Redirect to first child page.
	$pagekids = get_pages("child_of=".$post->ID."&sort_column=menu_order");
	if ($pagekids) {
		$firstchild = $pagekids[0];
		wp_redirect(get_permalink($firstchild->ID));
	} else {
	// Display current page
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
            <?php the_post(); ?>
            <?php the_content(); ?>
            <?php get_template_part( 'includes/related-links'); ?>
        </div>
    </div>
    <?php get_sidebar(); ?>    
    <?php get_footer(); ?>
<?php
	}
?>