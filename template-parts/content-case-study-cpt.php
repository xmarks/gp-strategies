<?php
$postID = get_the_ID();

// [Legacy] - Enqueue Styles / Scripts
if ( gp_is_legacy_enabled() ) {
	wp_enqueue_style( 'legacy.main' );
	wp_enqueue_style( 'legacy.aos' );
	wp_enqueue_script( 'legacy.aos' );
	wp_enqueue_script( 'legacy.jquery-main' );
}

?>

<section class="hero-page hero-page--berry content-height">
    <div class="container">
        <div class="hero-page__breadcrumbs">
            <?php if (function_exists('gp_breadcrumbs')) gp_breadcrumbs(); ?>
        </div>
        <div class="hero-page__content">
            <?php the_title( '<h1 class="hero-page__title">', '</h1>' ); ?>

            <div class="bottom-dots">
				<svg width="31" height="8" viewBox="0 0 31 8" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M26.9936 0C24.7807 0 22.9883 1.79087 22.9883 4.00084C22.9883 6.20997 24.7807 8.00084 26.9936 8C29.2057 8.00084 30.9989 6.20997 30.9989 4.00084C30.9989 1.79087 29.2057 0 26.9936 0Z" fill="#FFF"/>
				<path fill-rule="evenodd" clip-rule="evenodd" d="M14.7475 0.75C12.9492 0.749159 11.4922 2.20508 11.4922 3.99932C11.4922 5.79355 12.9492 7.24947 14.7467 7.24947C16.5441 7.24947 18.0012 5.79355 18.0012 3.99932C18.0012 2.20508 16.5441 0.749159 14.7475 0.75Z" fill="#FFF"/>
				<path fill-rule="evenodd" clip-rule="evenodd" d="M2.50365 1.5C1.11994 1.50084 0 2.62013 0 4.00116C0 5.38134 1.11994 6.49979 2.50365 6.49979C3.88567 6.49979 5.0073 5.38134 5.0073 4.00116C5.0073 2.62013 3.88651 1.50084 2.50365 1.5Z" fill="#FFF"/>
				</svg>
			</div>
        </div>
    </div>
</section>

<section class="content-section">
    <div class="container">
        <div class="content-section__wrap">
            <aside class="content-section__aside">
                <?php $company_logo = get_field( 'company_logo' ); ?>
                <?php

                $img_classes = '';

                if ( $company_logo ) :
                    if (get_field('border_radius') == 'no') {
                        $img_classes .= ' remove-border-rad ';
                    }else{
                        $img_classes .= ' border-rad ';
                    }
                    if (get_field('image_style')) {
                        $img_classes .= ' style-'.get_field('image_style');
                    }else{
                        $img_classes .= ' style-contain ';
                    }
                ?>
                    <div class="content-section__aside__logo <?php echo $img_classes; ?>">
                        <img src="<?php echo esc_url( $company_logo['url'] ); ?>" alt="<?php echo esc_attr( $company_logo['alt'] ); ?>"/>
                    </div>
                <?php endif; ?>
                <?php if (get_field( 'show_list_of_content' ) == 'yes'): ?>
                    <?php
                    get_template_part( 'template-parts/reusable-sections/table-of-contents',  '', array('ID' => $postID,) );
                    ?>
                <?php endif; ?>
            </aside>
            <div class="content-section__content entry-content">
                <?php the_content(  ); ?>
            </div>
        </div>
    </div>
</section>

<?php
get_template_part( 'template-parts/reusable-sections/find-more');
?>
<?php
get_template_part( 'template-parts/reusable-sections/innovation-approach');
?>
