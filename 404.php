<?php
/**
 * 404 template.
 */

get_header();
?>

<main class="p-error-page">
	<section class="p-error-page__message" aria-labelledby="error-page-title">
		<div class="p-error-page__inner l-inner">
			<h1 class="p-error-page__title" id="error-page-title">404 NOT FOUND</h1>
			<p class="p-error-page__text">
				お探しのページが見つかりませんでした。<br>
				削除された可能性があります。
			</p>
			<a class="p-error-page__link c-gradient-button" href="<?php echo esc_url( home_url( '/' ) ); ?>">TOPへ戻る</a>
		</div>
	</section>

	<section class="p-error-page__common-cta p-common-cta c-cta">
		<div class="p-error-page__common-cta-inner p-common-cta__inner c-cta__inner l-inner l-inner--cta">
			<?php get_template_part( 'template-parts/common/contact-cta' ); ?>
			<?php get_template_part( 'template-parts/common/faq-cta' ); ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>
