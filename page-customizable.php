<?php 
/* 
Template name: Customizable Page
*/
get_header(); ?>


<main class="main" role="main">
<?php // open the WordPress loop
if (have_posts()) : while (have_posts()) : the_post();

  // are there any rows within within our flexible content?
  if( have_rows('page_layout') ): 

    // loop through all the rows of flexible content
    while ( have_rows('page_layout') ) : the_row();

    	// Product Callout 
    	if( get_row_layout() == 'masthead' )
      		get_template_part('partials/section', 'masthead');

      	endwhile; // close the loop of flexible content
  endif; // close flexible content conditional

endwhile; endif; // close the WordPress loop ?>
</main>

<?php get_footer(); ?>