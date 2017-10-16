<?php

function load_theme_styles() {
    wp_enqueue_style( 'si-style', get_template_directory_uri() . '/style.css', array(), '1.1' );
    wp_enqueue_style( 'si-responsive', get_template_directory_uri() . '/styles/responsive.css', array(), '1.1' );
}
add_action( 'wp_enqueue_scripts', 'load_theme_styles' );


//Load jQuery and all external scripts
function load_my_scripts() {
	wp_enqueue_script('jquery');
	$templatedir = get_bloginfo('template_directory');
	wp_register_script('myscript', $templatedir.'/scripts/interaction.js', array('jquery'), '', true);
	wp_enqueue_script('myscript');
}
add_action('init', 'load_my_scripts');

// Make Wordpress Admin content area use theme stylesheet
add_editor_style('style.css');

// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain( 'si-modern', TEMPLATEPATH . '/languages' );
 
$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable($locale_file) )
    require_once($locale_file);
 
// Get the page number
function get_page_number() {
    if ( get_query_var('paged') ) {
        print ' | ' . __( 'Page ' , 'si-modern') . get_query_var('paged');
    }
} // end get_page_number


// add more link to excerpt
function custom_excerpt_more($more) {
return ' ...';
}
add_filter('excerpt_more', 'custom_excerpt_more');

//prevent Wordpress from wrapping loose images in a p tag
function filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'filter_ptags_on_images');

//Prevent <p> and <br> tags from being added to posts
//remove_filter( 'the_content', 'wpautop' );
//remove_filter( 'the_excerpt', 'wpautop' );

// For tag lists on tag archives: Returns other tags except the current one (redundant)
function tag_ur_it($glue) {
    $current_tag = single_tag_title( '', '',  false );
    $separator = "n";
    $tags = explode( $separator, get_the_tag_list( "", "$separator", "" ) );
    foreach ( $tags as $i => $str ) {
        if ( strstr( $str, ">$current_tag<" ) ) {
            unset($tags[$i]);
            break;
        }
    }
    if ( empty($tags) )
        return false;
 
    return trim(join( $glue, $tags ));
} // end tag_ur_it

// Register widgetized areas
function theme_widgets_init() {
    // Area 1
    register_sidebar( array (
        'name'          => 'Primary Widget Area',
        'id'            => 'primary_widget_area',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
 
    // Area 2
    register_sidebar( array (
        'name'          => 'Secondary Widget Area',
        'id'            => 'secondary_widget_area',
        'before_widget' => '<div class="secondary_nav dark">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="secondary_nav_title">',
        'after_title'   => '<span> Menu</span></h3>',
    ) );
} // end theme_widgets_init
add_action( 'init', 'theme_widgets_init' );

//pre-set our default widgets
$preset_widgets = array (
    'primary_widget_area'   => array( 'search', 'pages', 'categories', 'archives' ),
    'secondary_widget_area' => array( 'links', 'meta' )
);
if ( isset( $_GET['activated'] ) ) {
    update_option( 'sidebars_widgets', $preset_widgets );
}
// update_option( 'sidebars_widgets', NULL );

// Check for static widgets in widget-ready areas
function is_sidebar_active( $index ){
    global $wp_registered_sidebars;
 
    $widgetcolums = wp_get_sidebars_widgets();
 
    if ( $widgetcolums[$index] ) return true;
 
    return false;
} // end is_sidebar_active

//create support for menus
function register_my_menus() {
  register_nav_menus(
    array(
      'main-navigation' => __( 'Main Navigation' ),
      'secondary-navigation' => __( 'Secondary Navigation' ),
      'tertiary-navigation' => __( 'Tertiary Navigation' )
    )
  );
}
add_action( 'init', 'register_my_menus' );

//breadcrumb creation
function breadcrumbs() {
    global $post;
	if(is_front_page() || is_attachment()) {
		//don't include breadcrumbs on home page	
	} else {
		echo '<div class="breadcrumbs"><ul class="wrapper">';
	}

    if (!is_front_page() && !is_attachment()) {
		//get the blog page url
		$posts_page_id = get_option('page_for_posts');
		$posts_page = get_page($posts_page_id);
		$posts_page_title = $posts_page->post_title;
		if(get_option('show_on_front') == 'page') {
			$posts_page_url = get_permalink($posts_page_id);
		}
        echo '<li><a href="';
        echo get_option('home');
        echo '">';
        echo 'Home';
        echo '</a></li>';
		if (is_home()) {
			echo"<li>".$posts_page_title."</li>";
		} elseif (is_category() || is_single()) {
			$category = get_the_category();
			$catLink = get_category_link($category[0]->cat_ID);
			if($category[0]->cat_name != 'Blog') {
				if (is_single()) 
				{
					if($category[0]->cat_name == 'News') {
						echo '<li><a href="/company">Company</a></li>';
						echo '<li><a href="/company/'.strtolower($category[0]->cat_name).'">'.$category[0]->cat_name.'</a></li>';
					} else {
						echo '<li><a href="/'.strtolower($category[0]->cat_name).'">'.$category[0]->cat_name.'</a></li>';
					}
					echo '<li>'.the_title().'</li>';
				} else {
					echo '<li>'.$category[0]->cat_name.'</li>';
				}
			} else {
				echo '<li><a href="'.$posts_page_url.'">'.$posts_page_title.'</a></li>';
				if (is_single()) {
					echo '<li>'.the_title().'</li>';
				}
			}
        } elseif (is_page()) {
            if($post->post_parent){
                $anc = get_post_ancestors( $post->ID );
                $title = get_the_title();
                foreach ( $anc as $ancestor ) {
                    $output = '<li><a href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a></li>';
                }
                echo $output;
                echo $title;
            } else {
                echo the_title();
            }
        }
		elseif (is_tag()) {single_tag_title();}
		elseif (is_day()) {echo"<li>Archive for "; the_time('F jS, Y'); echo'</li>';}
		elseif (is_month()) {echo"<li>Archive for "; the_time('F, Y'); echo'</li>';}
		elseif (is_year()) {echo"<li>Archive for "; the_time('Y'); echo'</li>';}
		elseif (is_author()) {echo"<li>Posts by "; the_author(); echo'</li>';}
		elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<li>Blog Archives"; echo'</li>';}
		elseif (is_search()) {echo"<li>Search Results"; echo'</li>';}
		elseif (is_404()) {echo"<li>Page Not Found"; echo'</li>';}
    }
    echo '</ul></div>';
}


//add support for image thumbnails on posts
add_theme_support('post-thumbnails'); 


//custom blog author list
function contributors() {
	global $wpdb;
	$authors = $wpdb->get_results("SELECT ID, user_nicename from $wpdb->users WHERE ID NOT IN(1) ORDER BY display_name");
	if($author->ID == 1) {
		continue;	
	}
	foreach($authors as $author) {
		echo "<a href=\"".get_bloginfo('url')."/?author=";
		echo $author->ID;
		echo "\">";
		echo get_avatar($author->ID);
		the_author_meta('display_name', $author->ID);
		echo "</a>";
	}
}

//display recent posts by current post's author
function get_related_author_posts() {
    global $authordata, $post;
    $authors_posts = get_posts( array( 'author' => $authordata->ID, 'post__not_in' => array( $post->ID ), 'posts_per_page' => 3, 'cat' => '-6' ) );
    $output = '<div class="related-links">';
    $output .= '<span class="related-links-title">More from '.$authordata->display_name.'</span>';
    $output .= '<ul>';
    foreach ( $authors_posts as $authors_post ) {
        $output .= '<li><a href="' . get_permalink( $authors_post->ID ) . '">' . apply_filters( 'the_title', $authors_post->post_title, $authors_post->ID ) . '</a></li>';
    }
    $output .= '</ul>';
    $output .= '</div>';
    return $output;
}


//tells wordpress to crop image to set size so that it can be used in the main feature or a partner logo
add_image_size('partner_logo', 200, 70, false);
add_image_size('feature_image', 960, 424, true);
add_image_size( 'large-feature', 600, 400, true );

add_filter( 'image_size_names_choose', 'custom_image_sizes' );

function custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'partner_logo' => __( 'Partner Logo' ),
        'feature_image' => __( 'Main Feature' ),
        'large-feature' => __( 'Large Feature' )
    ) );
}


//Custom Comments
function customComments($comment, $args, $depth) {
    $isByAuthor = false;

    if($comment->comment_author_email == get_the_author_meta('email')) {
        $isByAuthor = true;
    }

   $GLOBALS['comment'] = $comment; ?>
   <div class="comment-level">
	<div id="comment-<?php comment_ID(); ?>" class="comment comment-info<?php if($isByAuthor){ echo ' author';}?>">
        <span class="comment-date"><i class="icon-calendar"></i> <?php echo get_comment_date('F j, Y g:i a'); ?></span>
        <?php printf(__('<span class="comment-author">%s</span>'), get_comment_author()) ?>
        <div class="comment-message">
            <?php if ($comment->comment_approved == '0') : ?>
                <p><?php _e('Your comment is awaiting moderation.<em>') ?></em></p>
            <?php endif; ?>
            <?php comment_text() ?>
        </div>
        <p><?php edit_comment_link(__('(Edit) | '),'  ','') ?><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></p>
	</div>
<?php
}

//Remove website url field from comments form
function remove_comment_url_fields($fields) {
    if(isset($fields['url']))
    {
         unset($fields['url']);
    }
    return $fields;
}
add_filter('comment_form_default_fields','remove_comment_url_fields');

//Add a rel="nofollow" to the comment reply links
function add_nofollow_to_reply_link( $link ) {
    return str_replace( '")\'>', '")\' rel=\'nofollow\'>', $link );
}
add_filter( 'comment_reply_link', 'add_nofollow_to_reply_link' );

//Use a different single file for posts that have a "News" category set
function get_custom_cat_template($single_template) {
     global $post;
 
       if ( in_category( 'news' )) {
          $single_template = dirname( __FILE__ ) . '/single-news.php';
     }
     return $single_template;
}
add_filter( "single_template", "get_custom_cat_template" ) ;

//Add New Meta Box for Secondary CTA Module
add_action( 'add_meta_boxes', 'module_add' );
function module_add()
{
	foreach (array('post','page') as $type)
	{
    	add_meta_box( 'secondary-module', 'Secondary CTA Module', 'module_render', $type, 'normal', 'high' );
	}
}

//Render Meta Box for Secondary CTA Module in Wordpress interface
function module_render()
{
    // $post is already set, and contains an object: the WordPress post
    global $post;
    $values = get_post_custom( $post->ID );
    $modHeadline = isset( $values['module_headline'] ) ? esc_attr( $values['module_headline'][0] ) : '';
    $modContent = isset( $values['module_content'] ) ? esc_attr( $values['module_content'][0] ) : '';
    $modUrl = isset( $values['module_url'] ) ? esc_attr( $values['module_url'][0] ) : '';
    $modBtn = isset( $values['module_btn'] ) ? esc_attr( $values['module_btn'][0] ) : '';
    $modBtnColor = isset( $values['module_btn_color'] ) ? esc_attr( $values['module_btn_color'][0] ) : '';
	$check = isset( $values['display_module'] ) ? esc_attr( $values['display_module'][0] ) : '';
     
    // We'll use this nonce field later on when saving.
    wp_nonce_field( 'my_module_nonce', 'module_nonce' );
?>
    <style type="text/css">
		#secondary-module label
		{
			width: 130px;
			display: block;
			vertical-align: top;
		}
		
		#secondary-module input[type=text], #secondary-module textarea
		{
			width: 94%;
			padding: 3px;
		}
	</style>
    <p>
        <label width="130" for="module_headline">Module Headline</label>
        <input type="text" name="module_headline" id="module_headline" value="<?php echo $modHeadline; ?>" />
    </p>
    <p>
        <label width="130" for="module_content">Module Content</label>
        <textarea name="module_content" id="module_content"><?php echo $modContent; ?></textarea>
    </p>
    <p>
        <label width="130" for="module_url">Button URL</label>
        <input type="text" name="module_url" id="module_url" value="<?php echo $modUrl; ?>" />
    </p>
    <p>
        <label width="130" for="module_btn">Button Display Text</label>
        <input type="text" name="module_btn" id="module_btn" value="<?php echo $modBtn; ?>" />
    </p>
    <p>
        <label width="130" for="module_btn_color">Button Color</label>
        <select name="module_btn_color" id="module_btn_color">
            <option value="blue" <?php selected( $modBtnColor, 'blue', 'selected="selected"' ); ?>>Blue</option>
            <option value="red" <?php selected( $modBtnColor, 'red', 'selected="selected"' ); ?>>Red</option>
            <option value="green" <?php selected( $modBtnColor, 'green', 'selected="selected"' ); ?>>Green</option>
        </select>
    </p>
    <p>
        <input type="checkbox" id="display_module" name="display_module" <?php checked( $check, 'on' ); ?> />
        <label for="display_module" style="display: inline; width: auto;">Display this module on page</label>
    </p>
<?php   
}

//Save Meta Box for Secondary CTA Module to Database
add_action( 'save_post', 'module_save' );
function module_save( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['module_nonce'] ) || !wp_verify_nonce( $_POST['module_nonce'], 'my_module_nonce' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post', $post_id ) ) return;
     
    // now we can actually save the data
    $allowed = array(
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )
    );
     
    // Make sure your data is set before trying to save it
    if( isset( $_POST['module_headline'] ) )
        update_post_meta( $post_id, 'module_headline', wp_kses( $_POST['module_headline'], $allowed ) );
         
    if( isset( $_POST['module_content'] ) )
        update_post_meta( $post_id, 'module_content', wp_kses( $_POST['module_content'], $allowed ) );
         
    if( isset( $_POST['module_url'] ) )
        update_post_meta( $post_id, 'module_url', wp_kses( $_POST['module_url'], $allowed ) );
         
    if( isset( $_POST['module_btn'] ) )
        update_post_meta( $post_id, 'module_btn', wp_kses( $_POST['module_btn'], $allowed ) );
         
    if( isset( $_POST['module_btn_color'] ) )
        update_post_meta( $post_id, 'module_btn_color', esc_attr( $_POST['module_btn_color'] ) );

    $chk = isset( $_POST['display_module'] ) ? 'on' : 'off';
		update_post_meta( $post_id, 'display_module', $chk );

}

//Add New Meta Box for Secondary CTA Module 2
add_action( 'add_meta_boxes', 'module_add2' );
function module_add2()
{
    foreach (array('post','page') as $type)
    {
        add_meta_box( 'secondary-module2', 'Secondary CTA Module 2', 'module_render2', $type, 'normal', 'high' );
    }
}

//Render Meta Box for Secondary CTA Module in Wordpress interface
function module_render2()
{
    // $post is already set, and contains an object: the WordPress post
    global $post;
    $values = get_post_custom( $post->ID );
    $modHeadline2 = isset( $values['module_headline2'] ) ? esc_attr( $values['module_headline2'][0] ) : '';
    $modContent2 = isset( $values['module_content2'] ) ? esc_attr( $values['module_content2'][0] ) : '';
    $modUrl2 = isset( $values['module_url2'] ) ? esc_attr( $values['module_url2'][0] ) : '';
    $modBtn2 = isset( $values['module_btn2'] ) ? esc_attr( $values['module_btn2'][0] ) : '';
    $modBtnColor2 = isset( $values['module_btn_color2'] ) ? esc_attr( $values['module_btn_color2'][0] ) : '';
    $check2 = isset( $values['display_module2'] ) ? esc_attr( $values['display_module2'][0] ) : '';
     
    // We'll use this nonce field later on when saving.
    wp_nonce_field( 'my_module_nonce2', 'module_nonce2' );
?>
    <style type="text/css">
        #secondary-module2 label
        {
            width: 130px;
            display: block;
            vertical-align: top;
        }
        
        #secondary-module2 input[type=text], #secondary-module2 textarea
        {
            width: 94%;
            padding: 3px;
        }
    </style>
    <p>
        <label width="130" for="module_headline2">Module Headline</label>
        <input type="text" name="module_headline2" id="module_headline2" value="<?php echo $modHeadline2; ?>" />
    </p>
    <p>
        <label width="130" for="module_content2">Module Content</label>
        <textarea name="module_content2" id="module_content2"><?php echo $modContent2; ?></textarea>
    </p>
    <p>
        <label width="130" for="module_url2">Button URL</label>
        <input type="text" name="module_url2" id="module_url2" value="<?php echo $modUrl2; ?>" />
    </p>
    <p>
        <label width="130" for="module_btn2">Button Display Text</label>
        <input type="text" name="module_btn2" id="module_btn2" value="<?php echo $modBtn2; ?>" />
    </p>
    <p>
        <label width="130" for="module_btn_color2">Button Color</label>
        <select name="module_btn_color2" id="module_btn_color2">
            <option value="blue" <?php selected( $modBtnColor2, 'blue', 'selected="selected"' ); ?>>Blue</option>
            <option value="red" <?php selected( $modBtnColor2, 'red', 'selected="selected"' ); ?>>Red</option>
            <option value="green" <?php selected( $modBtnColor2, 'green', 'selected="selected"' ); ?>>Green</option>
        </select>
    </p>
    <p>
        <input type="checkbox" id="display_module2" name="display_module2" <?php checked( $check2, 'on' ); ?> />
        <label for="display_module2" style="display: inline; width: auto;">Display this module on page</label>
    </p>
<?php   
}

//Save Meta Box for Secondary CTA Module to Database
add_action( 'save_post', 'module_save2' );
function module_save2( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['module_nonce2'] ) || !wp_verify_nonce( $_POST['module_nonce2'], 'my_module_nonce2' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post', $post_id ) ) return;
     
    // now we can actually save the data
    $allowed = array(
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )
    );
     
    // Make sure your data is set before trying to save it
    if( isset( $_POST['module_headline2'] ) )
        update_post_meta( $post_id, 'module_headline2', wp_kses( $_POST['module_headline2'], $allowed ) );
         
    if( isset( $_POST['module_content2'] ) )
        update_post_meta( $post_id, 'module_content2', wp_kses( $_POST['module_content2'], $allowed ) );
         
    if( isset( $_POST['module_url2'] ) )
        update_post_meta( $post_id, 'module_url2', wp_kses( $_POST['module_url2'], $allowed ) );
         
    if( isset( $_POST['module_btn2'] ) )
        update_post_meta( $post_id, 'module_btn2', wp_kses( $_POST['module_btn2'], $allowed ) );
         
    if( isset( $_POST['module_btn_color2'] ) )
        update_post_meta( $post_id, 'module_btn_color2', esc_attr( $_POST['module_btn_color2'] ) );

    $chk2 = isset( $_POST['display_module2'] ) ? 'on' : 'off';
        update_post_meta( $post_id, 'display_module2', $chk2 );

}

//Add New Meta Box for Secondary CTA Module 3
add_action( 'add_meta_boxes', 'module_add3' );
function module_add3()
{
    foreach (array('post','page') as $type)
    {
        add_meta_box( 'secondary-module3', 'Secondary CTA Module 3', 'module_render3', $type, 'normal', 'high' );
    }
}

//Render Meta Box for Secondary CTA Module in Wordpress interface
function module_render3()
{
    // $post is already set, and contains an object: the WordPress post
    global $post;
    $values = get_post_custom( $post->ID );
    $modHeadline3 = isset( $values['module_headline3'] ) ? esc_attr( $values['module_headline3'][0] ) : '';
    $modContent3 = isset( $values['module_content3'] ) ? esc_attr( $values['module_content3'][0] ) : '';
    $modUrl3 = isset( $values['module_url3'] ) ? esc_attr( $values['module_url3'][0] ) : '';
    $modBtn3 = isset( $values['module_btn3'] ) ? esc_attr( $values['module_btn3'][0] ) : '';
    $modBtnColor3 = isset( $values['module_btn_color3'] ) ? esc_attr( $values['module_btn_color3'][0] ) : '';
    $check3 = isset( $values['display_module3'] ) ? esc_attr( $values['display_module3'][0] ) : '';
     
    // We'll use this nonce field later on when saving.
    wp_nonce_field( 'my_module_nonce3', 'module_nonce3' );
?>
    <style type="text/css">
        #secondary-module3 label
        {
            width: 130px;
            display: block;
            vertical-align: top;
        }
        
        #secondary-module3 input[type=text], #secondary-module3 textarea
        {
            width: 94%;
            padding: 3px;
        }
    </style>
    <p>
        <label width="130" for="module_headline3">Module Headline</label>
        <input type="text" name="module_headline3" id="module_headline3" value="<?php echo $modHeadline3; ?>" />
    </p>
    <p>
        <label width="130" for="module_content3">Module Content</label>
        <textarea name="module_content3" id="module_content3"><?php echo $modContent3; ?></textarea>
    </p>
    <p>
        <label width="130" for="module_url3">Button URL</label>
        <input type="text" name="module_url3" id="module_url3" value="<?php echo $modUrl3; ?>" />
    </p>
    <p>
        <label width="130" for="module_btn3">Button Display Text</label>
        <input type="text" name="module_btn3" id="module_btn3" value="<?php echo $modBtn3; ?>" />
    </p>
    <p>
        <label width="130" for="module_btn_color3">Button Color</label>
        <select name="module_btn_color3" id="module_btn_color3">
            <option value="blue" <?php selected( $modBtnColor3, 'blue', 'selected="selected"' ); ?>>Blue</option>
            <option value="red" <?php selected( $modBtnColor3, 'red', 'selected="selected"' ); ?>>Red</option>
            <option value="green" <?php selected( $modBtnColor3, 'green', 'selected="selected"' ); ?>>Green</option>
        </select>
    </p>
    <p>
        <input type="checkbox" id="display_module3" name="display_module3" <?php checked( $check3, 'on' ); ?> />
        <label for="display_module3" style="display: inline; width: auto;">Display this module on page</label>
    </p>
<?php   
}

//Save Meta Box for Secondary CTA Module 3 to Database
add_action( 'save_post', 'module_save3' );
function module_save3( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['module_nonce3'] ) || !wp_verify_nonce( $_POST['module_nonce3'], 'my_module_nonce3' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post', $post_id ) ) return;
     
    // now we can actually save the data
    $allowed = array(
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )
    );
     
    // Make sure your data is set before trying to save it
    if( isset( $_POST['module_headline3'] ) )
        update_post_meta( $post_id, 'module_headline3', wp_kses( $_POST['module_headline3'], $allowed ) );
         
    if( isset( $_POST['module_content3'] ) )
        update_post_meta( $post_id, 'module_content3', wp_kses( $_POST['module_content3'], $allowed ) );
         
    if( isset( $_POST['module_url3'] ) )
        update_post_meta( $post_id, 'module_url3', wp_kses( $_POST['module_url3'], $allowed ) );
         
    if( isset( $_POST['module_btn3'] ) )
        update_post_meta( $post_id, 'module_btn3', wp_kses( $_POST['module_btn3'], $allowed ) );
         
    if( isset( $_POST['module_btn_color3'] ) )
        update_post_meta( $post_id, 'module_btn_color3', esc_attr( $_POST['module_btn_color3'] ) );

    $chk3 = isset( $_POST['display_module3'] ) ? 'on' : 'off';
        update_post_meta( $post_id, 'display_module3', $chk3 );

}






//Add New Meta Box for Related Page Links
add_action( 'add_meta_boxes', 'related_links_add' );
function related_links_add()
{
	foreach (array('post','page') as $type)
	{
    	add_meta_box( 'related-links', 'Related Page Links', 'related_links_render', $type, 'normal', 'high' );
	}
}

//Render Meta Box for Related Page Links in Wordpress interface
function related_links_render()
{
    // $post is already set, and contains an object: the WordPress post
    global $post;
    $values = get_post_custom( $post->ID );
    $link1 = isset( $values['link_1'] ) ? esc_attr( $values['link_1'][0] ) : '';
    $link2 = isset( $values['link_2'] ) ? esc_attr( $values['link_2'][0] ) : '';
    $link3 = isset( $values['link_3'] ) ? esc_attr( $values['link_3'][0] ) : '';
    $link4 = isset( $values['link_4'] ) ? esc_attr( $values['link_4'][0] ) : '';
    $link5 = isset( $values['link_5'] ) ? esc_attr( $values['link_5'][0] ) : '';
    $link6 = isset( $values['link_6'] ) ? esc_attr( $values['link_6'][0] ) : '';
    $link7 = isset( $values['link_7'] ) ? esc_attr( $values['link_7'][0] ) : '';
    $link8 = isset( $values['link_8'] ) ? esc_attr( $values['link_8'][0] ) : '';
    $link1Url = isset( $values['link_1_url'] ) ? esc_attr( $values['link_1_url'][0] ) : '';
    $link2Url = isset( $values['link_2_url'] ) ? esc_attr( $values['link_2_url'][0] ) : '';
    $link3Url = isset( $values['link_3_url'] ) ? esc_attr( $values['link_3_url'][0] ) : '';
    $link4Url = isset( $values['link_4_url'] ) ? esc_attr( $values['link_4_url'][0] ) : '';
    $link5Url = isset( $values['link_5_url'] ) ? esc_attr( $values['link_5_url'][0] ) : '';
    $link6Url = isset( $values['link_6_url'] ) ? esc_attr( $values['link_6_url'][0] ) : '';
    $link7Url = isset( $values['link_7_url'] ) ? esc_attr( $values['link_7_url'][0] ) : '';
    $link8Url = isset( $values['link_8_url'] ) ? esc_attr( $values['link_8_url'][0] ) : '';
	$check = isset( $values['display_links'] ) ? esc_attr( $values['display_links'][0] ) : '';
     
    // We'll use this nonce field later on when saving.
    wp_nonce_field( 'rel_links_nonce', 'links_nonce' );
?>
    <style type="text/css">
		#related-links label
		{
			width: 130px;
			vertical-align: top;
		}
		
		#related-links input[type=text]
		{
			padding: 3px;
		}
	</style>
    <p>
        <label width="130" for="link_1">Related Link</label>
        <input type="text" name="link_1" id="link_1" value="<?php echo $link1; ?>" />
        <label width="130" for="link_1_url">Link URL</label>
        <input type="text" name="link_1_url" id="link_1_url" value="<?php echo $link1Url; ?>" />
    </p>
    <p>
        <label width="130" for="link_2">Related Link</label>
        <input type="text" name="link_2" id="link_2" value="<?php echo $link2; ?>" />
        <label width="130" for="link_2_url">Link URL</label>
        <input type="text" name="link_2_url" id="link_2_url" value="<?php echo $link2Url; ?>" />
    </p>
    <p>
        <label width="130" for="link_3">Related Link</label>
        <input type="text" name="link_3" id="link_3" value="<?php echo $link3; ?>" />
        <label width="130" for="link_3_url">Link URL</label>
        <input type="text" name="link_3_url" id="link_3_url" value="<?php echo $link3Url; ?>" />
    </p>
    <p>
        <label width="130" for="link_4">Related Link</label>
        <input type="text" name="link_4" id="link_4" value="<?php echo $link4; ?>" />
        <label width="130" for="link_4_url">Link URL</label>
        <input type="text" name="link_4_url" id="link_4_url" value="<?php echo $link4Url; ?>" />
    </p>
    <p>
        <label width="130" for="link_5">Related Link</label>
        <input type="text" name="link_5" id="link_5" value="<?php echo $link5; ?>" />
        <label width="130" for="link_5_url">Link URL</label>
        <input type="text" name="link_5_url" id="link_5_url" value="<?php echo $link5Url; ?>" />
    </p>
    <p>
        <label width="130" for="link_6">Related Link</label>
        <input type="text" name="link_6" id="link_6" value="<?php echo $link6; ?>" />
        <label width="130" for="link_6_url">Link URL</label>
        <input type="text" name="link_6_url" id="link_6_url" value="<?php echo $link6Url; ?>" />
    </p>
    <p>
        <label width="130" for="link_7">Related Link</label>
        <input type="text" name="link_7" id="link_7" value="<?php echo $link7; ?>" />
        <label width="130" for="link_7_url">Link URL</label>
        <input type="text" name="link_7_url" id="link_7_url" value="<?php echo $link7Url; ?>" />
    </p>
    <p>
        <label width="130" for="link_8">Related Link</label>
        <input type="text" name="link_8" id="link_8" value="<?php echo $link8; ?>" />
        <label width="130" for="link_8_url">Link URL</label>
        <input type="text" name="link_8_url" id="link_8_url" value="<?php echo $link8Url; ?>" />
    </p>
    <p>
        <input type="checkbox" id="display_links" name="display_links" <?php checked( $check, 'on' ); ?> />
        <label for="display_links" style="display: inline; width: auto;">Display Related Links on page</label>
    </p>
<?php   
}

//Save Meta Box for Secondary CTA Module to Database
add_action( 'save_post', 'related_links_save' );
function related_links_save( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['module_nonce'] ) || !wp_verify_nonce( $_POST['links_nonce'], 'rel_links_nonce' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post', $post_id ) ) return;
     
    // now we can actually save the data
    $allowed = array(
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )
    );
     
    // Make sure your data is set before trying to save it
    if( isset( $_POST['link_1'] ) )
        update_post_meta( $post_id, 'link_1', esc_attr( $_POST['link_1'] ) );
         
    if( isset( $_POST['link_2'] ) )
        update_post_meta( $post_id, 'link_2', esc_attr( $_POST['link_2'] ) );
         
    if( isset( $_POST['link_3'] ) )
        update_post_meta( $post_id, 'link_3', esc_attr( $_POST['link_3'] ) );
         
    if( isset( $_POST['link_4'] ) )
        update_post_meta( $post_id, 'link_4', esc_attr( $_POST['link_4'] ) );
         
    if( isset( $_POST['link_5'] ) )
        update_post_meta( $post_id, 'link_5', esc_attr( $_POST['link_5'] ) );

    if( isset( $_POST['link_6'] ) )
        update_post_meta( $post_id, 'link_6', esc_attr( $_POST['link_6'] ) );

    if( isset( $_POST['link_7'] ) )
        update_post_meta( $post_id, 'link_7', esc_attr( $_POST['link_7'] ) );

    if( isset( $_POST['link_8'] ) )
        update_post_meta( $post_id, 'link_8', esc_attr( $_POST['link_8'] ) );

    if( isset( $_POST['link_1_url'] ) )
        update_post_meta( $post_id, 'link_1_url', wp_kses( $_POST['link_1_url'], $allowed ) );
         
    if( isset( $_POST['link_2_url'] ) )
        update_post_meta( $post_id, 'link_2_url', wp_kses( $_POST['link_2_url'], $allowed ) );
         
    if( isset( $_POST['link_3_url'] ) )
        update_post_meta( $post_id, 'link_3_url', wp_kses( $_POST['link_3_url'], $allowed ) );
         
    if( isset( $_POST['link_4_url'] ) )
        update_post_meta( $post_id, 'link_4_url', wp_kses( $_POST['link_4_url'], $allowed ) );
         
    if( isset( $_POST['link_5_url'] ) )
        update_post_meta( $post_id, 'link_5_url', wp_kses( $_POST['link_5_url'], $allowed ) );

    if( isset( $_POST['link_6_url'] ) )
        update_post_meta( $post_id, 'link_6_url', wp_kses( $_POST['link_6_url'], $allowed ) );

    if( isset( $_POST['link_7_url'] ) )
        update_post_meta( $post_id, 'link_7_url', wp_kses( $_POST['link_7_url'], $allowed ) );

    if( isset( $_POST['link_8_url'] ) )
        update_post_meta( $post_id, 'link_8_url', wp_kses( $_POST['link_8_url'], $allowed ) );

    $chk3 = isset( $_POST['display_links'] ) ? 'on' : 'off';
		update_post_meta( $post_id, 'display_links', $chk3 );

}
?>

<?php
    // 2017 Additions
    add_filter('next_posts_link_attributes', 'posts_link_attributes');
    add_filter('previous_posts_link_attributes', 'posts_link_attributes');

    function posts_link_attributes() {
        return 'class="btn btn-blue"';
    }

    //Remove width and height attributes from thumbnail images
    add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
    add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );
    function remove_thumbnail_dimensions( $html ) {
        $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
        return $html;
    }

?>