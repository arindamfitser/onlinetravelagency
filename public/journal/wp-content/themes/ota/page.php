<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>
<section class="banner_slider_sec hometop_gap">
		<div class="container">
				<div class="row clearfix">
					<div class="text_bg">
					</div>
					
				</div>
		</div>
</section>
<section class="img_box_sec visit_collection">
		<div class="container">
				<div class="row">
						<div class="image_sec_heading">
								<h2>VISIT OUR CURATED COLLECTION</h2>
						</div>
						<div class="visit_img_area_main">
							<?php
							// Start the loop.
							  while ( have_posts() ) : the_post();
								// Include the page content template.
								  //get_template_part( 'content', 'page' );

								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;

							// End the loop.
							endwhile;
							?>
						
								
						</div>
						
				</div>
		</div>
</section>

<?php get_footer(); ?>
