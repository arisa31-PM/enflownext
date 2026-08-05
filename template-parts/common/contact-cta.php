<?php
/**
 * Contact CTA Item
 */
$contact_cta = array(
	'label'     => 'CONTACT',
	'sub'       => 'お問い合わせ',
	'url'       => function_exists( 'my_get_page_url' ) ? my_get_page_url( 'contact' ) : home_url( '/contact/' ),
	'image_pc'  => 'contact-cta-pc.png',
	'image_sp'  => 'contact-cta.png',
	'width_pc'  => 1300,
	'height_pc' => 646,
	'width_sp'  => 670,
	'height_sp' => 420,
);
?>
<a class="p-common-cta__item c-cta__item" href="<?php echo esc_url( $contact_cta['url'] ); ?>">
	<picture class="p-common-cta__picture c-cta__picture">
		<source srcset="<?php echo esc_url( get_template_directory_uri() . '/assets/images/' . $contact_cta['image_pc'] ); ?>" media="(min-width: 768px)" type="image/png">
		<img class="p-common-cta__image c-cta__image" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/' . $contact_cta['image_sp'] ); ?>" alt="" width="<?php echo esc_attr( $contact_cta['width_sp'] ); ?>" height="<?php echo esc_attr( $contact_cta['height_sp'] ); ?>" loading="lazy" decoding="async">
	</picture>
	<span class="p-common-cta__text c-cta__text">
		<span class="p-common-cta__label c-cta__label"><?php echo esc_html( $contact_cta['label'] ); ?></span>
		<span class="p-common-cta__sub c-cta__sub">
			<span class="p-common-cta__sub-text c-cta__sub-text"><?php echo esc_html( $contact_cta['sub'] ); ?></span>
		</span>
	</span>
</a>
