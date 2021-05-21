<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); 
?>

<section class="img_box_sec visit_collection page">
		<div class="container">
		    
		         <div class="row">
		           <div class="col-md-12">
		               	  <div class="image_sec_heading">
    		               <h1 class="page-title">Our journal</h1>
    				     </div>
		           </div>
		        </div>
		        
				<div class="row">
				   <div class="col-md-9 ">
					
							
						
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
					</div>
				   <div class="col-md-3">
				   		<?php get_sidebar(); ?>
				   </div>
						
				</div>
		</div>
</section>


	

<?php get_footer(); ?>
