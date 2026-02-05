<?php
	$postID = $args['ID'];
?>

<?php if ( have_rows( 'link_items', $postID ) ) :  ?>
    <div class="table-of-contents">
        <ul class="table-of-contents__list">
            <?php while ( have_rows( 'link_items', $postID ) ) : the_row(); ?>
            <?php $choose_icon = get_sub_field( 'choose_icon' ); ?>
            <?php $link = get_sub_field( 'link' ); ?>
            <?php if ( $link ) : ?>
                <li>
                    <a href="<?php echo esc_url( $link['url'] ); ?>" target="<?php echo esc_attr( $link['target'] ); ?>">
                        <?php if ( $choose_icon ) : ?>
                            <span class="svg-icon-wrapper">
                                <?php sprite_svg( $choose_icon['ID'], '24', '24' ); ?>
                            </span>
                        <?php endif; ?>
                        <?php echo esc_html( $link['title'] ); ?>
                    </a>
                    
                </li>
                <?php endif; ?>
                <?php if ( have_rows( 'sub_items' ) ) : ?>
                    <ul class="table-of-contents__sublist">
					<?php while ( have_rows( 'sub_items' ) ) : the_row(); ?>
						<li>
						<?php $link = get_sub_field( 'link' ); ?>
						<?php if ( $link ) : ?>
							<a href="<?php echo esc_url( $link['url'] ); ?>" target="<?php echo esc_attr( $link['target'] ); ?>"><?php echo esc_html( $link['title'] ); ?></a>
						<?php endif; ?>
						</li>
					<?php endwhile; ?>
					</ul>
                <?php endif; ?>
            <?php endwhile; ?>
        </ul>
        <?php $bottom_cta = get_field( 'sidebar_cta_button', 'option' ); ?>
        <?php if ( $bottom_cta ) : ?>
            <div class="bottom-butoon">
                <a href="<?php echo esc_url( $bottom_cta['url'] ); ?>" target="<?php echo esc_attr( $bottom_cta['target'] ); ?>" class="button button--navy-outline"><?php echo esc_html( $bottom_cta['title'] ); ?></a>
            </div>
        <?php endif; ?>
    </div>
<?php elseif(is_single()): ?>
<?php  echo generate_table_of_contents($postID); ?>  

<?php endif; ?>