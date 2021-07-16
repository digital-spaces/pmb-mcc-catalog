<div class="post-inner">
	<div class="entry-content post-content">
		<?php the_content();?>
     <!--ACF Stuff That Probably Doesn't Work-->
      <?php
      if ( get_post_type( get_the_ID() ) == 'courses_post' ) {
        pmb_include_design_template( 'partials/courses' );
      }
      ?>
	</div><!-- .entry-content -->

</div><!-- .post-inner -->