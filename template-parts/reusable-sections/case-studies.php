<?php 

global $post;

$casestudies = get_posts( [
	'posts_per_page' => 4,
	'orderby' => 'date',
	'order'=> 'DESC',
	'post_type' => 'case-study-cpt',
] );

$case_ids = array();
$case_ids_custom = array();

?>
<?php /* Last 4 post IDs */ ?>
<?php foreach ($casestudies as $post):?>
	<?php 
		array_push($case_ids, $post->ID);
	?>
<?php endforeach ?>
<?php if ( have_rows( 'case_studies' ) ) : ?>
	<?php while ( have_rows( 'case_studies' ) ) : the_row(); ?>
		<?php if (get_sub_field( 'section_background' )): ?>
			<?php $bgcolor = get_sub_field( 'section_background' ); ?>
		<?php else: ?>
			<?php $bgcolor = '#ececec'; ?>
		<?php endif ?>
		<div class="case-studies-section" style="--color: <?php echo $bgcolor; ?>;">
			<?php /* Custom post IDs */ ?>
			<?php if ( have_rows( 'custom_case_studies' ) ) : ?>
				<?php while ( have_rows( 'custom_case_studies' ) ) : the_row(); ?>
					<?php $case_study = get_sub_field( 'case_study' ); ?>
					<?php array_push($case_ids_custom, $case_study);?>
				<?php endwhile; ?>
			<?php endif; ?>
			<?php if (get_sub_field( 'output' ) == 'custom'): ?>
				<?php $case_ids = $case_ids_custom; ?>
			<?php endif ?>
			<div class="container <?php if ( get_sub_field( 'has_border_radius' ) == 1 ) : ?> has-border-radius<?php endif; ?>">
				<?php $current_control = 1; ?>
				<?php $current_item = 1; ?>
				<?php if ( have_rows( 'case_studies', 'global' ) ) : ?>
					<?php while ( have_rows( 'case_studies', 'global' ) ) : the_row(); ?>
						<?php $section_head_link = get_sub_field( 'view_all_link' ); ?>
						<div class="case-studies-section__head section-header">
							<h2 class="section-header__title"><?php the_sub_field( 'section_title' ); ?></h2>
							<?php if ( $section_head_link ) : ?>
								<div class="section-header__button">
									<a class="button button--navy-outline" href="<?php echo esc_url( $section_head_link['url'] ); ?>" target="<?php echo esc_attr( $section_head_link['target'] ); ?>"><span class="button__text"><?php echo esc_html( $section_head_link['title'] ); ?></span></a>
								</div>
							<?php endif; ?>
						</div>
					<?php endwhile; ?>
				<?php endif; ?>
				<div class="case-studies-section__frame">
					<div class="case-studies-tabs tabset">
						<div class="case-studies-tabs__head">
							<ul class="tab-control case-studies-tabs__switcher">
								<?php foreach ($case_ids as $case_id):?>
									<?php 
									$post_type = get_post_type($case_id);
									$taxonomies = get_object_taxonomies($post_type);
									$taxonomy_names = wp_get_object_terms($case_id, $taxonomies,  array("fields" => "names")); 
									?>
									<li><a class="not-color tab-opener<?php if ($current_control == 1): ?> active<?php endif; ?>" href="#">
										<?php if (!empty($taxonomy_names)): ?>
											<?php echo $taxonomy_names[0]; ?>
										<?php else: ?>
											case
										<?php endif ?>
									</a></li>
									<?php $current_control = $current_control + 1; ?>
								<?php endforeach ?>
							</ul>
						</div>
						<div class="tabs-list case-studies-tabs__tab-list">
							<?php foreach ($case_ids as $case_id):?>
								<?php 
								$read_more_link_url = get_permalink($case_id); 
								?>
								<div class="tab-item<?php if ($current_item == 1): ?> active<?php endif; ?>">
									<div class="case-studies-tabs__item">
										<div class="case-studies-tabs__visual">
											<img src="<?php echo get_the_post_thumbnail_url($case_id, 'full'); ?>" alt="<?php echo get_the_title($case_id); ?>">
										</div>
										<div class="case-studies-tabs__frame">
											<h3 class="case-studies-tabs__name"><?php echo get_the_title($case_id); ?></h3>
											<div class="case-studies-tabs__text"><?php echo get_the_excerpt($case_id); ?></div>
											<div class="case-studies-tabs__more">
												<a class="read-more" href="<?php echo esc_url( $read_more_link_url ); ?>">Read more<span class="screen-reader-text"><?php echo get_the_title($case_id); ?></span></a>
											</div>
										</div>
									</div>
								</div>
								<?php $current_item = $current_item + 1; ?>
							<?php endforeach ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endwhile; ?>
<?php endif; ?>




