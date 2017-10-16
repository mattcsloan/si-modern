<?php
/*
Template Name: 2-column Page - Right Sidebar
*/
?>

<?php get_header(); ?>
    <div class="content">
        <div class="main">
			<?php the_post(); ?>
            <?php the_content(); ?>
            <?php edit_post_link( __( 'Edit', 'si-modern' ), '<span class="edit-link">', '</span>' ) ?>
        </div>
    	<div class="secondary">
        	<?php get_sidebar('pages'); ?>
        </div>
    </div>
<?php get_footer(); ?>