<?php
/**
 * @var \PrintMyBlog\orm\entities\Project $pmb_project
 * @var PrintMyBlog\orm\entities\Design $pmb_design
 */
?>
<div <?php pmb_section_wrapper_class();?> <?php pmb_section_wrapper_id();?>>
    <article <?php pmb_section_class(); ?> <?php pmb_section_id(); ?>>
        <header class="entry-header has-text-align-center">

            <div class="entry-header-inner section-inner medium">
				<?php pmb_the_title();?>
            </div><!-- .entry-header-inner -->
        </header><!-- .entry-header -->
		<?php pmb_include_design_template( 'partials/content' ); ?>
    </article>
<?php // end of file. For some reason this comment was needed to prevent a fatal parsing error on dev.printmy.blog