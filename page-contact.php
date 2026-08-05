<?php
/**
 * CONTACT page template.
 */

get_header();
?>

<main class="p-contact-page">
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

	<section class="p-contact-page__body">
		<div class="p-contact-page__inner l-inner">
			<?php
			get_template_part(
				'template-parts/common/breadcrumb',
				null,
				array(
					'context_class' => 'p-contact-page__breadcrumb',
				)
			);
			?>

			<div class="p-contact-page__form" data-thanks-url="<?php echo esc_url( function_exists( 'my_get_page_url' ) ? my_get_page_url( 'thanks' ) : home_url( '/contact/thanks/' ) ); ?>">
				<?php
				$contact_form_shortcode = function_exists( 'my_get_contact_form_shortcode' ) ? my_get_contact_form_shortcode() : '';

				if ( '' !== $contact_form_shortcode ) {
					echo my_render_contact_form( $contact_form_shortcode );
				}
				?>
			</div>
		</div>
	</section>

	<section class="p-contact-page__common-cta p-common-cta c-cta">
		<div class="p-contact-page__common-cta-inner p-common-cta__inner c-cta__inner l-inner l-inner--cta">
			<?php get_template_part( 'template-parts/common/faq-cta' ); ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>
