<?php
/*
Template Name: Full Width Page
*/
?>

<?php get_header(); ?>
    <div class="content">
        <div class="full">
			<?php the_post(); ?>
            <?php the_content(); ?>
            <?php edit_post_link( __( 'Edit', 'si-modern' ), '<span class="edit-link">', '</span>' ) ?>
        </div>
    </div>
<?php get_footer(); ?>