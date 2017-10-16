<?php
/*
Template Name: Contact Page
*/
?>

<?php get_header(); ?>
    <div class="content">
    	<div class="secondary">
			<?php
				if($post->post_parent) {
					$ancestors = get_post_ancestors($post->ID);
					$ancestorsTest = false;
					if($ancestors[1]) {
						$children = wp_list_pages("title_li=&child_of=".$ancestors[1]."&depth=1&echo=0");
						$ancestorsTest = true;
					} else {
						$children = wp_list_pages("title_li=&child_of=".$post->post_parent."&depth=1&echo=0");
					}
                } else {
                    $children = wp_list_pages("title_li=&child_of=".$post->ID."&depth=1&echo=0");
                }
                if ($children) { ?>
                    <div class="secondary_nav dark">
                        <h3 class="secondary_nav_title">
                        <?php
							if($ancestorsTest) {
								$parent_post = get_post($ancestors[1]); //gets the parent post based on the id number passed through
							} else {
								$parent_post = get_post($post->post_parent); //gets the parent post based on the id number passed through
							}
                            $parent_post_title = $parent_post->post_title; //gets the parent page's title
                            echo $parent_post_title;
                        ?>
                        <span> Menu</span></h3>
                        <ul>
                            <?php echo $children; ?>
                        </ul>
                    </div>
            <?php } ?>
        </div>
        <div class="main">
            <div class="main">
                <?php the_post(); ?>
                <?php the_content(); ?>
                <?php edit_post_link( __( 'Edit', 'si-modern' ), '<span class="edit-link">', '</span>' ) ?>
            </div>
            <div class="secondary">
                <div class="mod">
                	<img class="feature" src="/wp-content/uploads/2014/04/office-ohio-canal.jpg" alt="Akron, Ohio Office Building" />
                    <h3>Company Name</h3>
                    <p>Address Line 1<br />
                    Address Line 2<br />
                    City, ST 12345</p>
                    <a class="btn blue" href="#" target="_blank">View Map</a>
                </div>
                <?php get_sidebar('pages'); ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>