<?php
/**
 * FAQ page template.
 */

get_header();

$faq_items = array();

$normalize_faq_items = static function ( $items ) {
	$normalized_items = array();

	if ( ! is_array( $items ) ) {
		return $normalized_items;
	}

	foreach ( $items as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}

		$question = trim( (string) ( $item['question'] ?? $item['faq_question'] ?? '' ) );
		$answer   = trim( (string) ( $item['answer'] ?? $item['faq_answer'] ?? '' ) );

		if ( '' === $question || '' === $answer ) {
			continue;
		}

		$normalized_items[] = array(
			'question' => $question,
			'answer'   => $answer,
		);
	}

	return $normalized_items;
};

$get_faq_items_from_meta = static function ( $post_id ) use ( $normalize_faq_items ) {
	$meta_faq_items = get_post_meta( $post_id, 'faq_items', true );
	$faq_items      = $normalize_faq_items( $meta_faq_items );

	if ( ! empty( $faq_items ) ) {
		return $faq_items;
	}

	$field_pairs = array(
		array(
			'question' => 'question',
			'answer'   => 'answer',
		),
		array(
			'question' => 'faq_question',
			'answer'   => 'faq_answer',
		),
	);

	foreach ( $field_pairs as $field_pair ) {
		$questions = get_post_meta( $post_id, $field_pair['question'], false );
		$answers   = get_post_meta( $post_id, $field_pair['answer'], false );

		if ( ! is_array( $questions ) ) {
			$questions = array();
		}

		if ( ! is_array( $answers ) ) {
			$answers = array();
		}

		$faq_count = max( count( $questions ), count( $answers ) );

		for ( $index = 0; $index < $faq_count; $index++ ) {
			$question = trim( (string) ( $questions[ $index ] ?? '' ) );
			$answer   = trim( (string) ( $answers[ $index ] ?? '' ) );

			if ( '' === $question || '' === $answer ) {
				continue;
			}

			$faq_items[] = array(
				'question' => $question,
				'answer'   => $answer,
			);
		}

		if ( ! empty( $faq_items ) ) {
			break;
		}
	}

	return $faq_items;
};

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();

		$post_id = get_the_ID();

		if ( 0 >= $post_id ) {
			break;
		}

		if ( class_exists( 'SCF' ) ) {
			$scf_faq_items = SCF::get( 'faq_items', $post_id );

			$faq_items = $normalize_faq_items( $scf_faq_items );
		}

		if ( empty( $faq_items ) ) {
			$faq_items = $get_faq_items_from_meta( $post_id );
		}

		break;
	}
}
?>

<main class="p-faq-page">
	<?php
	get_template_part(
		'template-parts/common/page-fv',
		null,
		array(
			'title'     => 'FAQ',
			'sub_title' => 'よくあるご質問',
			'image_pc'  => 'faq-fv-pc.webp',
			'image_sp'  => 'faq-fv-pc.webp',
			'width_pc'  => 2880,
			'height_pc' => 960,
			'width_sp'  => 375,
			'height_sp' => 230,
		)
	);
	?>

	<section class="p-faq-page__body">
		<div class="p-faq-page__inner l-inner">
			<?php
			get_template_part(
				'template-parts/common/breadcrumb',
				null,
				array(
					'context_class' => 'p-faq-page__breadcrumb',
				)
			);
			?>

			<?php if ( ! empty( $faq_items ) ) : ?>
				<section class="p-faq-page__faq" aria-labelledby="faq-page-title">
					<h2 class="p-faq-page__sr-only" id="faq-page-title">よくあるご質問</h2>

					<dl class="p-faq-page__list js-faq-accordion">
						<?php foreach ( $faq_items as $index => $faq_item ) : ?>
							<?php
							$item_number = $index + 1;
							$item_id     = 'faq-item-' . $item_number;
							$trigger_id  = 'faq-trigger-' . $item_number;
							$panel_id    = 'faq-panel-' . $item_number;
							$is_open     = 1 === $item_number;
							?>
							<div class="p-faq-page__item js-faq-item <?php echo esc_attr( $is_open ? 'is-open' : 'is-collapsed' ); ?>" id="<?php echo esc_attr( $item_id ); ?>">
								<dt class="p-faq-page__question">
									<button class="p-faq-page__button js-faq-trigger" id="<?php echo esc_attr( $trigger_id ); ?>" type="button" aria-expanded="<?php echo esc_attr( $is_open ? 'true' : 'false' ); ?>" aria-controls="<?php echo esc_attr( $panel_id ); ?>">
										<span class="p-faq-page__number" aria-hidden="true">Q<?php echo esc_html( (string) $item_number ); ?>.</span>
										<span class="p-faq-page__question-text"><?php echo esc_html( $faq_item['question'] ); ?></span>
										<span class="p-faq-page__icon" aria-hidden="true"></span>
									</button>
								</dt>
								<dd class="p-faq-page__answer js-faq-panel" id="<?php echo esc_attr( $panel_id ); ?>" aria-labelledby="<?php echo esc_attr( $trigger_id ); ?>" role="region">
									<div class="p-faq-page__answer-inner">
										<p class="p-faq-page__answer-text"><?php echo nl2br( esc_html( $faq_item['answer'] ) ); ?></p>
									</div>
								</dd>
							</div>
						<?php endforeach; ?>
					</dl>
				</section>
			<?php endif; ?>
		</div>
	</section>

	<section class="p-faq-page__common-cta p-common-cta c-cta">
		<div class="p-faq-page__common-cta-inner p-common-cta__inner c-cta__inner l-inner l-inner--cta">
			<?php get_template_part( 'template-parts/common/contact-cta' ); ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>
