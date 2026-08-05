<?php get_header(); ?>

<main class="p-works-archive">
	<?php
	get_template_part(
		'template-parts/common/page-fv',
		null,
		array(
			'title'     => 'WORKS',
			'sub_title' => '実績',
			'image_pc'  => 'works-fv-pc.webp',
			'image_sp'  => 'works-fv-pc.webp',
			'width_pc'  => 1440,
			'height_pc' => 480,
			'width_sp'  => 375,
			'height_sp' => 230,
		)
	);
	?>
	<section class="p-works-archive__body">
		<div class="p-works-archive__inner l-inner">
			<?php
			get_template_part(
				'template-parts/common/breadcrumb',
				null,
				array(
					'context_class' => 'p-works-archive__breadcrumb',
				)
			);
			?>
			<?php if ( have_posts() ) : ?>
				<div class="p-works-archive__list">
					<?php while ( have_posts() ) : ?>
						<?php the_post(); ?>
						<?php get_template_part( 'template-parts/cards/works-archive-card' ); ?>
					<?php endwhile; ?>
				</div>
				<?php
				get_template_part(
					'template-parts/common/pagination',
					null,
					array(
						'context_class' => 'p-works-archive__pagination',
					)
				);
				?>
			<?php else : ?>
				<p class="p-works-archive__empty">実績がありません。</p>
			<?php endif; ?>
		</div>
	</section>

	<section class="p-works-archive__common-cta p-common-cta c-cta">
		<div class="p-common-cta__inner c-cta__inner l-inner l-inner--cta">
			<?php get_template_part( 'template-parts/common/contact-cta' ); ?>
			<?php get_template_part( 'template-parts/common/faq-cta' ); ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>
