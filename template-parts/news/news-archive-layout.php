<?php
/**
 * News Archive Layout
 */

$news_page_id = (int) get_option( 'page_for_posts' );
?>

<main class="p-news-archive">
	<?php
	get_template_part(
		'template-parts/common/page-fv',
		null,
		array(
			'title'     => 'NEWS',
			'sub_title' => 'お知らせ',
			'image_pc'  => 'news-fv-pc.webp',
			'image_sp'  => 'news-fv-pc.webp',
			'width_pc'  => 1440,
			'height_pc' => 480,
			'width_sp'  => 375,
			'height_sp' => 230,
			'post_id'   => $news_page_id,
		)
	);
	?>

	<section class="p-news-archive__body">
		<div class="p-news-archive__inner l-inner">
			<?php
			get_template_part(
				'template-parts/common/breadcrumb',
				null,
				array(
					'context_class' => 'p-news-archive__breadcrumb',
				)
			);
			?>

			<div class="p-news-archive__content">
				<div class="p-news-archive__main">
					<?php if ( have_posts() ) : ?>
						<div class="p-news-archive__list">
							<?php while ( have_posts() ) : ?>
								<?php the_post(); ?>
								<?php get_template_part( 'template-parts/cards/news-archive-card' ); ?>
							<?php endwhile; ?>
						</div>
					<?php else : ?>
						<p class="p-news-archive__empty">お知らせがありません。</p>
					<?php endif; ?>

					<div class="p-news-archive__pagination-sp u-sp">
						<?php
						get_template_part(
							'template-parts/common/pagination',
							null,
							array(
								'context_class' => 'p-news-archive__pagination',
							)
						);
						?>
					</div>
				</div>

				<aside class="p-news-archive__sidebar" aria-label="お知らせメニュー">
					<?php get_template_part( 'template-parts/news/news-sidebar' ); ?>
				</aside>
			</div>

			<div class="p-news-archive__pagination-pc u-pc">
				<?php
				get_template_part(
					'template-parts/common/pagination',
					null,
					array(
						'context_class' => 'p-news-archive__pagination',
					)
				);
				?>
			</div>
		</div>
	</section>

	<section class="p-news-archive__common-cta p-common-cta c-cta">
		<div class="p-common-cta__inner c-cta__inner l-inner l-inner--cta">
			<?php get_template_part( 'template-parts/common/contact-cta' ); ?>
			<?php get_template_part( 'template-parts/common/faq-cta' ); ?>
		</div>
	</section>
</main>
