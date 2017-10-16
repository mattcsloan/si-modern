<?php
/*
Template Name: Home
*/
?>

<?php get_header(); ?>
<?php the_post(); ?>

<?php 
$post_id = get_the_ID();

$headline = get_post_meta( $post_id, 'module_headline', true ); 
$content = get_post_meta( $post_id, 'module_content', true ); 
$url = get_post_meta( $post_id, 'module_url', true ); 
$btnText = get_post_meta( $post_id, 'module_btn', true ); 
$btnColor = 'btn-'.get_post_meta( $post_id, 'module_btn_color', true ); 
$moduleDisplay = get_post_meta( $post_id, 'display_module', true );

$headline2 = get_post_meta( $post_id, 'module_headline2', true ); 
$content2 = get_post_meta( $post_id, 'module_content2', true ); 
$url2 = get_post_meta( $post_id, 'module_url2', true ); 
$btnText2 = get_post_meta( $post_id, 'module_btn2', true ); 
$btnColor2 = 'btn-'.get_post_meta( $post_id, 'module_btn_color2', true ); 
$moduleDisplay2 = get_post_meta( $post_id, 'display_module2', true ); 

$headline3 = get_post_meta( $post_id, 'module_headline3', true ); 
$content3 = get_post_meta( $post_id, 'module_content3', true ); 
$url3 = get_post_meta( $post_id, 'module_url3', true ); 
$btnText3 = get_post_meta( $post_id, 'module_btn3', true ); 
$btnColor3 = 'btn-'.get_post_meta( $post_id, 'module_btn_color3', true ); 
$moduleDisplay3 = get_post_meta( $post_id, 'display_module3', true ); 

?>


<div class="hero main-feature with-image">
    <div class="wrapper main">
        <h1>Lorem ipsum dolor sit amet consectetur</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque pellentesque felis eu diam pretium, vel consectetur orci tempus.</p>
        <p class="slim"><a class="btn" href="#">Call To Action</a></p>
        <p><a class="btn btn-text btn-small light" href="#">sample text</a></p>
    </div>
</div>
<div class="secondary">
    <div class="wrapper large-pad">
        <div class="columns four-wide feature-cards">
            <a class="col card" href="#">
                <i class="icon-connection"></i>
                <span class="card-title">Solutions</span>
                <p>Wi-Fi Performance Solutions for Different Organizations</p>
            </a>
            <a class="col card" href="#">
                <i class="icon-connection"></i>
                <span class="card-title">Products</span>
                <p>Proactive Wi-Fi Performance Management</p>
            </a>
            <a class="col card" href="#">
                <i class="icon-book"></i>
                <span class="card-title">Learning Center</span>
                <p>Learn more about Wi-Fi performance management</p>
            </a>
            <a class="col card" href="#">
                <i class="icon-newspaper"></i>
                <span class="card-title">Blog</span>
                <p>Keep up-to-date with Wi-Fi performance management</p>
            </a>
        </div>
        <div class="columns thirds intro">
            <div class="col">
                <h3>About Company Name</h3>
                <p>Lorem ipsum.</p>
                <p><a class="btn" href="#">Get A Free Trial</a></p>
            </div>
            <div class="col two-thirds">
                <img src="content-img/video-placeholder.jpg" alt="" />
            </div>
        </div>
    </div>
</div>
<div class="content wrapper columns thirds large-pad intro">
    <div class="col two-thirds">
        <img src="content-img/tablet-placeholder.png" alt="" />
    </div>
    <div class="col">
        <h3>Lorem ipsum dolor sit amet consectetur</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque pellentesque felis eu diam pretium, vel consectetur orci tempus.</p>
        <a class="btn" href="#">Call To Action</a>
    </div>
</div>

<?php
if($moduleDisplay == 'on' || $moduleDisplay2 == 'on' || $moduleDisplay3 == 'on') {
?>
<div class="secondary">
    <div class="wrapper">
        <div class="featured-items columns three-wide large-pad">
            <?php if($moduleDisplay == 'on') { ?>
                <div class="featured-item col">
                    <div class="featured-item-content">
                        <?php if($headline != '') { echo '<h3>'.$headline.'</h3>'; } ?>
                        <?php if($content != '') { echo '<p>'.$content.'</p>'; } ?>
                        <p>
                            <?php if($btnColor != '' && $url != '' && $btnText != '') { 
                                if(substr($url,0,4) == 'http') {
                                    echo '<a class="btn '.$btnColor.'" href="'.$url.'" target="_blank">'.$btnText.'</a>';
                                } else {
                                    echo '<a class="btn '.$btnColor.'" href="'.$url.'">'.$btnText.'</a>';
                                }
                            } ?>
                        </p>
                    </div>
                </div>
            <?php
            }
            if($moduleDisplay2 == 'on') {
            ?>
                <div class="featured-item col">
                    <div class="featured-item-content">
                        <?php if($headline2 != '') { echo '<h3>'.$headline2.'</h3>'; } ?>
                        <?php if($content2 != '') { echo '<p>'.$content2.'</p>'; } ?>
                        <p>
                            <?php if($btnColor2 != '' && $url2 != '' && $btnText2 != '') { 
                                if(substr($url2,0,4) == 'http') {
                                    echo '<a class="btn '.$btnColor2.'" href="'.$url2.'" target="_blank">'.$btnText2.'</a>'; 
                                } else {
                                    echo '<a class="btn '.$btnColor2.'" href="'.$url2.'">'.$btnText2.'</a>'; 
                                }
                            } ?>
                        </p>
                    </div>
                </div>
            <?php
            }
            if($moduleDisplay3 == 'on') {
            ?>
                <div class="featured-item col">
                    <div class="featured-item-content">
                        <?php if($headline3 != '') { echo '<h3>'.$headline3.'</h3>'; } ?>
                        <?php if($content3 != '') { echo '<p>'.$content3.'</p>'; } ?>
                        <p>
                            <?php if($btnColor3 != '' && $url3 != '' && $btnText3 != '') { 
                                if(substr($url3,0,4) == 'http') {
                                    echo '<a class="btn '.$btnColor3.'" href="'.$url3.'" target="_blank">'.$btnText3.'</a>'; 
                                } else {
                                    echo '<a class="btn '.$btnColor3.'" href="'.$url3.'">'.$btnText3.'</a>'; 
                                }
                            } ?>
                        </p>
                    </div>
                </div>
            <?php
            } ?>
        </div>
    </div>
</div>
<?php
}
?>



<div class="wrapper">
    <div class="columns two-wide">
        <div class="col">
            <h3>In the News</h3>
            <?php
                $recent_posts = wp_get_recent_posts( array(
                    'numberposts' => 4,
                    'category' => get_cat_ID('news') )
                );
                if($recent_posts) {
                    echo '<ul class="link-list">';
                    foreach( $recent_posts as $recent ){
                        echo '<li><a href="' . get_permalink($recent["ID"]) . '" title="'.esc_attr($recent["post_title"]).'" >'.$recent["post_title"].'</a></li>';
                    }
                    echo '</ul>';
                }
            ?>
        </div>
        <div class="col">
            <h3>What They're Saying</h3>
            <div class="testimonial">
                <div class="testimonial-comment">"This is a testimonial comment."</div>
                <div class="testimonial-company">Company Name</div>
                <div class="testimonial-person">Person Name, Person Title</div>
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>