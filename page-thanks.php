<?php
/**
 * Thanks page template.
 */

get_header();
?>

<main class="p-thanks-page">
	<?php
	get_template_part(
		'template-parts/common/page-fv',
		null,
		array(
			'title'     => 'CONTACT',
			'sub_title' => 'お問い合わせ',
			'image_pc'  => 'contact-fv-pc.webp',
			'image_sp'  => 'contact-fv-pc.webp',
			'width_pc'  => 2880,
			'height_pc' => 960,
			'width_sp'  => 375,
			'height_sp' => 230,
		)
	);
	?>

	<section class="p-thanks-page__body">
		<div class="p-thanks-page__inner l-inner">
			<?php
			get_template_part(
				'template-parts/common/breadcrumb',
				null,
				array(
					'context_class' => 'p-thanks-page__breadcrumb',
				)
			);
			?>

			<section class="p-thanks-page__message" aria-labelledby="thanks-message-title">
				<h2 class="p-thanks-page__title" id="thanks-message-title">送信が完了いたしました</h2>
				<p class="p-thanks-page__text">
					<span class="p-thanks-page__text-line p-thanks-page__text-line--lead">お問い合わせいただきありがとうございます。</span>
					<span class="p-thanks-page__text-line">お問い合わせ頂いた内容については、</span>
					<span class="p-thanks-page__text-line">確認の上ご返信させていただきます。</span>
				</p>
			</section>

			<div class="p-thanks-page__button-wrap">
				<a class="p-thanks-page__button c-gradient-button" href="<?php echo esc_url( home_url( '/' ) ); ?>">TOPへ戻る</a>
			</div>
		</div>
	</section>

	<section class="p-thanks-page__common-cta p-common-cta c-cta">
		<div class="p-thanks-page__common-cta-inner p-common-cta__inner c-cta__inner l-inner l-inner--cta">
			<?php get_template_part( 'template-parts/common/faq-cta' ); ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>
