<?php if ( have_rows( 'innovation_approach', 'global' ) ) : ?>
	<?php while ( have_rows( 'innovation_approach', 'global' ) ) : the_row(); ?>
        <?php $section_image = get_field( 'section_image' ); ?>
        <?php 

        $classes = 'innovation-approach';


        $sectionTitleTag = 'h2';
        if (get_field( 'section_title_tag' )) {
            $sectionTitleTag = get_field( 'section_title_tag' );
        }

        $contentTitleTag = 'h3';
        if (get_field( 'content_title_tag' )) {
            $contentTitleTag = get_field( 'content_title_tag' );
        }

        $sectionBgColor = '#C11F5A';
        if (get_field( 'section_background_color' )) {
            $sectionBgColor = get_field( 'section_background_color' );
        }

        $sectionTextColor = '#FFFFFF';
        if (get_field( 'section_text_color' )) {
            $sectionTextColor = get_field( 'section_text_color' );
        }

        if (get_field( 'image_position' ) == '2') {
            $classes .= ' innovation-approach--right-img';
        }

        ?>
        <style type="text/css">
            .innovation-approach .innovation-approach__wrap::before{
                background-color: <?php echo $sectionBgColor; ?>;
            }
            .innovation-approach .innovation-approach__info {
                color: <?php echo $sectionTextColor; ?>;
                background-color: <?php echo $sectionBgColor; ?>;
            }
            .innovation-approach .h2 {
                margin-top: 0;
            }
            .innovation-approach .h3 {
                margin-top: 0;
            }
            .innovation-approach--global .innovation-approach__text a {
                color: var(--linkColor);
            }
            .innovation-approach--global .innovation-approach__text a:hover {
                text-decoration: none;
            }
            .innovation-approach--global ul:not([class])>li:not([class]):before {
                color: var(--dotColor);
            }
            
            
        </style>
        <section class="<?php echo $classes; ?> innovation-approach--global">
            <div class="container">
                <?php if (get_field( 'section_title' )): ?>
                    <<?php echo $sectionTitleTag; ?> class="innovation-approach__title h2"><?php the_sub_field( 'section_title' ); ?></<?php echo $sectionTitleTag; ?>>
                <?php endif ?>
                <div class="innovation-approach__wrap">
                    <div class="innovation-approach__image" style="--order: <?php the_sub_field( 'image_position' ); ?>">
                    <?php if ( $section_image ) : ?>
                        <img src="<?php echo esc_url( $section_image['url'] ); ?>" alt="<?php echo esc_attr( $section_image['alt'] ); ?>" />
                    <?php endif; ?>
                    </div>
                    <div class="innovation-approach__info">
                        <div class="innovation-approach__content">
                            <?php if (get_field( 'content_title' )): ?>
                                <<?php echo $contentTitleTag; ?> class="innovation-approach__content-title h3"><?php the_sub_field( 'content_title' ); ?></<?php echo $contentTitleTag; ?>>
                            <?php endif ?>
                            <div class="innovation-approach__text"><?php the_sub_field( 'content_text' ); ?></div>
                            <?php if ( have_rows( 'buttons' ) ) : ?>
                                <div class="innovation-approach__buttons">
                                    <?php while ( have_rows( 'buttons' ) ) : the_row(); ?>
                                        <?php $button = get_field( 'button' ); ?>
                                        <?php if ( $button ) : ?>
                                            <a class="button <?php the_sub_field( 'button_style' ); ?>" href="<?php echo esc_url( $button['url'] ); ?>" target="<?php echo esc_attr( $button['target'] ); ?>"><span class="button__text"><?php echo esc_html( $button['title'] ); ?></span></a>
                                        <?php endif; ?>
                                    <?php endwhile; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
	<?php endwhile; ?>
<?php endif; ?>