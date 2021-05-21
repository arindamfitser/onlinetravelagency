<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>

<div class="col-md-6 col-sm-6 col-xs-6 mobile_width_full" id="post-<?php the_ID(); ?>"> 
  <a href="<?php the_permalink(); ?>" class="category-thumbnail">
  <?php
     if ( has_post_thumbnail() ){
     	$wpblog_fetrdimg = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );?>
       <div class="wrapper-category-image"> <img src="<?php echo $wpblog_fetrdimg; ?>" alt=""> </div>
	  <?php }else{?>
      <div class="wrapper-category-image"> <img src="<?php echo get_template_directory_uri(); ?>/images/timthumb.jpg" alt=""> </div>
    <?php } ?>
	
		<!--<h3>Castles, Chateaux & Luxury Manors</h3>-->
	
	<?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>
  </a> 
</div>

