<?php get_header(); ?>

<main class="p-works-single">
	<section class="p-works-single__body">
		<div class="p-works-single__breadcrumb-wrap l-inner">
			<?php
			get_template_part(
				'template-parts/common/breadcrumb',
				null,
				array(
					'context_class' => 'p-works-single__breadcrumb',
				)
			);
			?>
		</div>

		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : ?>
				<?php
					the_post();

					$post_id = get_queried_object_id();

					if ( 0 >= $post_id ) {
						$post_id = get_the_ID();
					}

					$get_scf_value = static function ( $key ) use ( $post_id ) {
						if ( class_exists( 'SCF' ) ) {
							$value = SCF::get( $key, $post_id );

							if ( is_array( $value ) ) {
								return $value;
							}

							return trim( (string) $value );
						}

						return '';
					};

					$get_scf_text = static function ( $key ) use ( $get_scf_value ) {
						$value = $get_scf_value( $key );

						if ( is_array( $value ) ) {
							return '';
						}

						return trim( (string) $value );
					};

					$get_scf_image_id = static function ( $key ) use ( $get_scf_value ) {
						$value = $get_scf_value( $key );

						if ( is_array( $value ) ) {
							$value = reset( $value );
						}

						return (int) $value;
					};

					$genre_name = my_get_works_genre_name( $post_id, true );

					$site_url      = $get_scf_text( 'site_url' );
					$site_url_safe = esc_url_raw( $site_url, array( 'http', 'https' ) );
					$is_valid_url  = '' !== $site_url && '' !== $site_url_safe && preg_match( '/^https?:\/\//i', $site_url );

					$info_rows = array(
						array(
							'label' => 'ジャンル',
							'value' => $genre_name,
							'type'  => 'text',
						),
						array(
							'label' => '担当と作業範囲',
							'value' => $get_scf_text( 'work_scope' ),
							'type'  => 'text',
						),
						array(
							'label' => '制作環境と使用言語',
							'value' => $get_scf_text( 'development_environment' ),
							'type'  => 'text',
						),
						array(
							'label' => '制作期間',
							'value' => $get_scf_text( 'production_period' ),
							'type'  => 'text',
						),
						array(
							'label' => 'URL',
							'value' => $site_url,
							'type'  => $is_valid_url ? 'url' : 'text',
							'url'   => $site_url_safe,
						),
						array(
							'label' => 'クライアント概要',
							'value' => $get_scf_text( 'client_overview' ),
							'type'  => 'textarea',
						),
						array(
							'label'    => 'クライアントの意向と課題、制作経緯',
							'value'    => $get_scf_text( 'project_background' ),
							'type'     => 'textarea',
							'modifier' => 'project-background',
						),
					);

					$visible_info_rows = array_filter(
						$info_rows,
						static function ( $row ) {
							return isset( $row['value'] ) && '' !== trim( (string) $row['value'] );
						}
					);

					$appeal_title    = $get_scf_text( 'appeal_title' );
					$appeal_image_id = $get_scf_image_id( 'appeal_image' );
					$appeal_text     = $get_scf_text( 'appeal_text' );
					$has_appeal      = '' !== $appeal_title || 0 < $appeal_image_id || '' !== $appeal_text;

					$voice_image_id = $get_scf_image_id( 'voice_image' );
					$voice_title    = $get_scf_text( 'voice_title' );
					$voice_text     = $get_scf_text( 'voice_text' );
					$has_voice      = 0 < $voice_image_id && '' !== $voice_title && '' !== $voice_text;

					$works_title = esc_html( get_the_title() );
					foreach ( array( 'コミュニケーション', 'ハイクオリティ', 'コード' ) as $palt_word ) {
						$works_title = str_replace(
							$palt_word,
							'<span class="p-works-single__title-palt">' . $palt_word . '</span>',
							$works_title
						);
					}
					?>

				<article class="p-works-single__article">
					<figure class="p-works-single__hero">
						<?php
						echo my_get_responsive_featured_picture(
							array(
								'post_id'       => $post_id,
								'sp_field'      => 'featured_image_sp',
								'pc_size'       => 'full',
								'sp_size'       => 'large',
								'class'         => 'p-works-single__hero-image',
								'picture_class' => 'p-works-single__hero-picture',
								'loading'       => 'eager',
								'fetchpriority' => 'high',
							)
						);
						?>
					</figure>

					<div class="p-works-single__content-wrap l-inner">
							<h1 class="p-works-single__title"><?php echo wp_kses( $works_title, array( 'span' => array( 'class' => true ) ) ); ?></h1>

							<?php if ( ! empty( $visible_info_rows ) ) : ?>
								<section class="p-works-single__info" aria-label="作品情報">
									<table class="p-works-single__info-table">
										<tbody class="p-works-single__info-body">
											<?php foreach ( $visible_info_rows as $row ) : ?>
												<?php
												$info_data_classes = array( 'p-works-single__info-data' );

												if ( isset( $row['modifier'] ) && '' !== $row['modifier'] ) {
													$info_data_classes[] = 'p-works-single__info-data--' . $row['modifier'];
												}
												?>
												<tr class="p-works-single__info-row">
													<th class="p-works-single__info-heading" scope="row"><?php echo esc_html( $row['label'] ); ?></th>
													<td class="<?php echo esc_attr( implode( ' ', $info_data_classes ) ); ?>">
														<?php if ( 'url' === $row['type'] ) : ?>
															<a class="p-works-single__info-link" href="<?php echo esc_url( $row['url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $row['value'] ); ?></a>
														<?php elseif ( 'textarea' === $row['type'] ) : ?>
															<?php echo nl2br( esc_html( $row['value'] ) ); ?>
														<?php else : ?>
															<?php echo esc_html( $row['value'] ); ?>
														<?php endif; ?>
													</td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</section>
							<?php endif; ?>

							<?php if ( $has_appeal ) : ?>
								<section class="p-works-single__appeal">
									<?php if ( '' !== $appeal_title ) : ?>
										<h2 class="p-works-single__appeal-title"><?php echo nl2br( esc_html( $appeal_title ) ); ?></h2>
									<?php endif; ?>
									<?php if ( 0 < $appeal_image_id ) : ?>
										<figure class="p-works-single__appeal-figure">
											<?php echo wp_get_attachment_image( $appeal_image_id, 'large', false, array( 'class' => 'p-works-single__appeal-image', 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
										</figure>
									<?php endif; ?>
									<?php if ( '' !== $appeal_text ) : ?>
										<p class="p-works-single__appeal-text"><?php echo nl2br( esc_html( $appeal_text ) ); ?></p>
									<?php endif; ?>
								</section>
							<?php endif; ?>
					</div>

							<?php if ( $has_voice ) : ?>
								<section class="p-works-single__voice">
									<div class="p-works-single__voice-heading c-section-heading">
										<h2 class="p-works-single__voice-title-main c-section-heading__title">VOICE</h2>
										<p class="p-works-single__voice-sub c-section-heading__sub">お客様の声</p>
									</div>
									<div class="p-works-single__voice-body">
										<figure class="p-works-single__voice-figure">
											<?php echo wp_get_attachment_image( $voice_image_id, 'large', false, array( 'class' => 'p-works-single__voice-image', 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
										</figure>
										<div class="p-works-single__voice-content">
											<h3 class="p-works-single__voice-title"><?php echo nl2br( esc_html( $voice_title ) ); ?></h3>
											<p class="p-works-single__voice-text"><?php echo nl2br( esc_html( $voice_text ) ); ?></p>
										</div>
									</div>
								</section>
							<?php endif; ?>

					<div class="p-works-single__nav-wrap l-inner">
							<?php
							$previous_post = get_previous_post();
							$next_post     = get_next_post();
							?>
							<nav class="p-works-single__post-nav" aria-label="前後の記事">
								<?php if ( $previous_post ) : ?>
									<a class="p-works-single__post-nav-link p-works-single__post-nav-link--prev" href="<?php echo esc_url( get_permalink( $previous_post ) ); ?>" aria-label="<?php echo esc_attr( get_the_title( $previous_post ) . 'へ移動' ); ?>">
										<span class="p-works-single__post-nav-icon" aria-hidden="true"></span>
										<span class="p-works-single__post-nav-text">前の記事へ</span>
									</a>
								<?php else : ?>
									<span class="p-works-single__post-nav-link p-works-single__post-nav-link--prev p-works-single__post-nav-link--disabled" aria-disabled="true">
										<span class="p-works-single__post-nav-icon" aria-hidden="true"></span>
										<span class="p-works-single__post-nav-text">前の記事へ</span>
									</span>
								<?php endif; ?>
								<?php if ( $next_post ) : ?>
									<a class="p-works-single__post-nav-link p-works-single__post-nav-link--next" href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" aria-label="<?php echo esc_attr( get_the_title( $next_post ) . 'へ移動' ); ?>">
										<span class="p-works-single__post-nav-text">次の記事へ</span>
										<span class="p-works-single__post-nav-icon" aria-hidden="true"></span>
									</a>
								<?php else : ?>
									<span class="p-works-single__post-nav-link p-works-single__post-nav-link--next p-works-single__post-nav-link--disabled" aria-disabled="true">
										<span class="p-works-single__post-nav-text">次の記事へ</span>
										<span class="p-works-single__post-nav-icon" aria-hidden="true"></span>
									</span>
								<?php endif; ?>
							</nav>
					</div>
				</article>
			<?php endwhile; ?>
		<?php endif; ?>
	</section>

	<?php
	$related_query = new WP_Query(
		array(
			'post_type'      => 'works',
			'posts_per_page' => 6,
			'post_status'    => 'publish',
			'post__not_in'   => array( get_queried_object_id() ),
			'orderby'        => 'date',
			'order'          => 'DESC',
			'no_found_rows'  => true,
		)
	);
	?>
	<?php if ( $related_query->have_posts() ) : ?>
		<aside class="p-works-single__related" aria-label="関連実績">
			<?php if ( 2 < (int) $related_query->post_count ) : ?>
				<div class="p-works-single__related-controls">
					<button class="p-works-single__related-button c-slider-button c-slider-button--prev js-works-related-prev" type="button" aria-label="前の関連実績へ"></button>
					<button class="p-works-single__related-button c-slider-button c-slider-button--next js-works-related-next" type="button" aria-label="次の関連実績へ"></button>
				</div>
				<div class="p-works-single__related-slider swiper js-works-related-slider">
					<div class="p-works-single__related-wrapper swiper-wrapper">
						<?php while ( $related_query->have_posts() ) : ?>
							<?php $related_query->the_post(); ?>
							<div class="p-works-single__related-item swiper-slide">
								<?php get_template_part( 'template-parts/cards/works-related-card' ); ?>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
			<?php else : ?>
				<div class="p-works-single__related-list">
					<?php while ( $related_query->have_posts() ) : ?>
						<?php $related_query->the_post(); ?>
						<div class="p-works-single__related-item">
							<?php get_template_part( 'template-parts/cards/works-related-card' ); ?>
						</div>
					<?php endwhile; ?>
				</div>
			<?php endif; ?>
		</aside>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>

	<section class="p-works-single__common-cta p-common-cta c-cta">
		<div class="p-common-cta__inner c-cta__inner l-inner l-inner--cta">
			<?php get_template_part( 'template-parts/common/contact-cta' ); ?>
			<?php get_template_part( 'template-parts/common/faq-cta' ); ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>
