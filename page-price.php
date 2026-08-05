<?php
/**
 * PRICE page template.
 */

get_header();

$price_values = array(
	'estimate'        => array(
		'start' => 100,
		'end'   => 0,
	),
	'basic_top'      => array(
		'start' => 0,
		'end'   => 59800,
	),
	'basic_lower'    => array(
		'start' => 0,
		'end'   => 19800,
	),
	'animation'      => array(
		'start' => 0,
		'end'   => 16800,
	),
	'responsive'     => array(
		'start' => 0,
		'end'   => 19800,
	),
	'implementation' => array(
		'end' => 2,
	),
);

$format_price = static function ( $value ) {
	return number_format( (int) $value );
};
?>

<main class="p-price">
	<?php
	get_template_part(
		'template-parts/common/page-fv',
		null,
		array(
			'title'     => 'PRICE',
			'sub_title' => '料金',
			'image_pc'  => 'price-fv-pc.webp',
			'image_sp'  => 'price-fv-pc.webp',
			'width_pc'  => 2880,
			'height_pc' => 960,
			'width_sp'  => 375,
			'height_sp' => 230,
		)
	);
	?>

	<section class="p-price__body">
		<div class="p-price__inner l-inner">
			<?php
			get_template_part(
				'template-parts/common/breadcrumb',
				null,
				array(
					'context_class' => 'p-price__breadcrumb',
				)
			);
			?>

			<section class="p-price__pricing js-price-section" aria-labelledby="price-pricing-title">
				<h2 class="p-price__sr-only" id="price-pricing-title">料金</h2>

				<div class="p-price__grid">
					<section class="p-price__card p-price__card--estimate">
						<h3 class="p-price__card-title">お見積もり</h3>
						<p class="p-price__price p-price__price--estimate" aria-label="<?php echo esc_attr( $format_price( $price_values['estimate']['end'] ) . '円' ); ?>">
							<span class="p-price__count js-price-count" data-start="<?php echo esc_attr( $price_values['estimate']['start'] ); ?>" data-end="<?php echo esc_attr( $price_values['estimate']['end'] ); ?>" aria-hidden="true"><?php echo esc_html( $format_price( $price_values['estimate']['end'] ) ); ?></span>
							<span class="p-price__unit" aria-hidden="true">円</span>
						</p>
					</section>

					<section class="p-price__card p-price__card--basic p-price__card--basic-pc">
						<h3 class="p-price__card-title">基本料金</h3>
						<div class="p-price__basic-content">
							<figure class="p-price__figure p-price__figure--pricing">
								<img class="p-price__image p-price__image--pricing" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/price-pricing-pc.webp' ); ?>" alt="" width="462" height="373" loading="lazy" decoding="async">
							</figure>
							<div class="p-price__basic-list">
								<p class="p-price__basic-row p-price__basic-row--top" aria-label="<?php echo esc_attr( 'トップ ' . $format_price( $price_values['basic_top']['end'] ) . '円から' ); ?>">
									<span class="p-price__label" aria-hidden="true">トップ</span>
									<span class="p-price__price" aria-hidden="true">
										<span class="p-price__count js-price-count" data-start="<?php echo esc_attr( $price_values['basic_top']['start'] ); ?>" data-end="<?php echo esc_attr( $price_values['basic_top']['end'] ); ?>"><?php echo esc_html( $format_price( $price_values['basic_top']['end'] ) ); ?></span>
										<span class="p-price__unit">円〜</span>
									</span>
								</p>
								<p class="p-price__basic-row p-price__basic-row--lower" aria-label="<?php echo esc_attr( '下層 ' . $format_price( $price_values['basic_lower']['end'] ) . '円から' ); ?>">
									<span class="p-price__label" aria-hidden="true">下層</span>
									<span class="p-price__price" aria-hidden="true">
										<span class="p-price__count js-price-count" data-start="<?php echo esc_attr( $price_values['basic_lower']['start'] ); ?>" data-end="<?php echo esc_attr( $price_values['basic_lower']['end'] ); ?>"><?php echo esc_html( $format_price( $price_values['basic_lower']['end'] ) ); ?></span>
										<span class="p-price__unit">円〜</span>
									</span>
								</p>
							</div>
						</div>
					</section>

					<div class="p-price__service-grid">
						<section class="p-price__card p-price__card--animation">
							<h3 class="p-price__card-title">アニメーション</h3>
							<p class="p-price__price p-price__price--animation" aria-label="<?php echo esc_attr( $format_price( $price_values['animation']['end'] ) . '円から' ); ?>">
								<span class="p-price__count js-price-count" data-start="<?php echo esc_attr( $price_values['animation']['start'] ); ?>" data-end="<?php echo esc_attr( $price_values['animation']['end'] ); ?>" aria-hidden="true"><?php echo esc_html( $format_price( $price_values['animation']['end'] ) ); ?></span>
								<span class="p-price__unit" aria-hidden="true">円〜</span>
							</p>
						</section>

						<section class="p-price__card p-price__card--responsive">
							<h3 class="p-price__card-title">レスポンシブ</h3>
							<div class="p-price__responsive-content">
								<figure class="p-price__figure p-price__figure--responsive">
									<img class="p-price__image p-price__image--responsive" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/price-responsive-pc.webp' ); ?>" alt="" width="281" height="273" loading="lazy" decoding="async">
								</figure>
								<p class="p-price__price p-price__price--responsive" aria-label="<?php echo esc_attr( $format_price( $price_values['responsive']['end'] ) . '円から' ); ?>">
									<span class="p-price__count js-price-count" data-start="<?php echo esc_attr( $price_values['responsive']['start'] ); ?>" data-end="<?php echo esc_attr( $price_values['responsive']['end'] ); ?>" aria-hidden="true"><?php echo esc_html( $format_price( $price_values['responsive']['end'] ) ); ?></span>
									<span class="p-price__unit p-price__unit--responsive" aria-hidden="true">円〜</span>
								</p>
							</div>
						</section>
					</div>

					<section class="p-price__card p-price__card--schedule">
						<h3 class="p-price__card-title">実装工期</h3>
						<div class="p-price__schedule-content">
							<div class="p-price__schedule-text">
								<p class="p-price__period" aria-label="<?php echo esc_attr( '平均' . $price_values['implementation']['end'] . '週間' ); ?>">
									<span class="p-price__period-label" aria-hidden="true">平均</span>
									<span class="p-price__period-number" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', (int) $price_values['implementation']['end'] ) ); ?></span>
									<span class="p-price__period-unit" aria-hidden="true">週間</span>
								</p>
								<p class="p-price__note">※コーポレートサイト00ページあたり</p>
							</div>
							<figure class="p-price__figure p-price__figure--schedule">
								<img class="p-price__image p-price__image--schedule" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/price-schedule-pc.webp' ); ?>" alt="" width="931" height="429" loading="lazy" decoding="async">
							</figure>
						</div>
					</section>
				</div>
			</section>
		</div>
	</section>

	<section class="p-price__common-cta p-common-cta c-cta">
		<div class="p-common-cta__inner c-cta__inner l-inner l-inner--cta">
			<?php get_template_part( 'template-parts/common/contact-cta' ); ?>
			<?php get_template_part( 'template-parts/common/faq-cta' ); ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>
