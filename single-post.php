<?php get_header(); ?>

<main class="p-news-single">
	<section class="p-news-single__body">
		<div class="p-news-single__inner l-inner">
			<?php
			get_template_part(
				'template-parts/common/breadcrumb',
				null,
				array(
					'context_class' => 'p-news-single__breadcrumb',
				)
			);
			?>

			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : ?>
					<?php
					the_post();

					$post_id       = get_the_ID();
					$categories    = get_the_category( $post_id );
					$category_name = 'お知らせ';

					if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
						$first_category = reset( $categories );

						if ( $first_category instanceof WP_Term && '' !== $first_category->name ) {
							$category_name = $first_category->name;
						}
					}

					?>

					<div class="p-news-single__layout">
						<article class="p-news-single__main">
							<header class="p-news-single__header">
								<div class="p-news-single__meta">
									<time class="p-news-single__date" datetime="<?php echo esc_attr( get_the_date( 'c', $post_id ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d', $post_id ) ); ?></time>
									<span class="p-news-single__category c-tag"><?php echo esc_html( $category_name ); ?></span>
								</div>
								<h1 class="p-news-single__title"><?php the_title(); ?></h1>
							</header>

							<figure class="p-news-single__figure">
								<?php
								echo my_get_responsive_featured_picture(
									array(
										'post_id'       => $post_id,
										'sp_field'      => 'featured_image_sp',
										'pc_size'       => 'large',
										'sp_size'       => 'large',
										'class'         => 'p-news-single__image',
										'picture_class' => 'p-news-single__picture',
										'loading'       => 'eager',
										'fetchpriority' => 'high',
									)
								);
								?>
							</figure>

							<div class="p-news-single__content">
								<?php the_content(); ?>
							</div>

							<a class="p-news-single__back c-more-link" href="<?php echo esc_url( function_exists( 'my_get_news_archive_url' ) ? my_get_news_archive_url() : home_url( '/news/' ) ); ?>">
								<span class="c-more-link__text">一覧に戻る</span>
								<span class="c-more-link__icon" aria-hidden="true"></span>
							</a>
						</article>

						<aside class="p-news-single__sidebar" aria-label="お知らせメニュー">
							<?php get_template_part( 'template-parts/news/news-sidebar' ); ?>
						</aside>
					</div>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</section>

	<section class="p-news-single__common-cta p-common-cta c-cta">
		<div class="p-common-cta__inner c-cta__inner l-inner l-inner--cta">
			<?php get_template_part( 'template-parts/common/contact-cta' ); ?>
			<?php get_template_part( 'template-parts/common/faq-cta' ); ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>
