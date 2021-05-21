<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

<section class="img_box_sec visit_collection page">
		<div class="container">
		    <div class="row">
		        <div class="col-md-12">
		             <div class="image_sec_heading">
    		           <?php
    					    the_archive_title( '<h1 class="page-title">', '</h1>' );
    					    the_archive_description( '<div class="taxonomy-description">', '</div>' );
    				   ?>
    				 </div>
		       </div>
		    </div>
		    	
				<div class="row">
				   
				   <div class="col-md-9 ">
				     <?php if ( have_posts() ) : ?>
				
						<div class="visit_img_area_main">
							<?php
							// Start the loop.
							  while ( have_posts() ) : the_post();
								// Include the page content template.
								  get_template_part( 'content', 'post' );

								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;

							// End the loop.
							endwhile;
							?>
								
						</div>
					   <?php
        				else :
        			    get_template_part( 'content', 'none' );
        		        endif;
        		      ?>
					</div>
				   <div class="col-md-3">
				   		<?php get_sidebar(); ?>
				   </div>
						
				</div>
			
		</div>
</section>

<?php get_footer(); ?>
