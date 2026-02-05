<?php if ( have_rows( 'bottom_form_section', 'global' ) ) : ?>
	<?php while ( have_rows( 'bottom_form_section', 'global' ) ) : the_row(); ?>
        <section class="find-more-section entry-content">
            <div class="container">
                <div class="find-more-section__wrap">
                    <div class="find-more-section__content">
                        <?php _e(get_sub_field( 'section_text_content' )); ?>
                    </div>
                    <div class="find-more-section__form">
                        <?php _e(get_sub_field( 'form_embed_code' )); ?>
                    </div>
                </div>
            </div>
        </section>
	<?php endwhile; ?>
<?php endif; ?>