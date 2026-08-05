<?php
/**
 * PROFILE page template.
 */

get_header();

$theme_uri = get_template_directory_uri();

$profile_pictures = array(
	'main'    => array(
		'basename' => 'profile-main-pc',
		'alt'      => '田中 太郎のプロフィール写真',
		'width'    => 1052,
		'height'   => 690,
	),
	'hobby'   => array(
		'basename' => 'profile-hobby-pc',
		'alt'      => 'サーフィンをしている様子',
		'width'    => 506,
		'height'   => 440,
	),
	'camera'  => array(
		'basename' => 'profile-camera-pc',
		'alt'      => 'カメラを構えている様子',
		'width'    => 524,
		'height'   => 440,
	),
);

$profile_skill_groups = array(
	array(
		'modifier' => 'coding',
		'title'    => 'コーディング',
		'items'    => array(
			array(
				'basename' => 'profile-html-pc',
				'label'    => 'HTML',
				'modifier' => 'html',
				'width'    => 90,
				'height'   => 133,
			),
			array(
				'basename' => 'profile-css-pc',
				'label'    => 'CSS',
				'modifier' => 'css',
				'width'    => 91,
				'height'   => 103,
			),
			array(
				'basename' => 'profile-sass-pc',
				'label'    => 'Saas',
				'modifier' => 'sass',
				'width'    => 129,
				'height'   => 97,
			),
			array(
				'basename' => 'profile-js-pc',
				'label'    => 'JavaScript',
				'modifier' => 'javascript',
				'width'    => 115,
				'height'   => 115,
			),
			array(
				'basename' => 'profile-php-pc',
				'label'    => 'PHP',
				'modifier' => 'php',
				'width'    => 158,
				'height'   => 83,
			),
		),
	),
	array(
		'modifier' => 'cms',
		'title'    => 'CMS',
		'items'    => array(
			array(
				'basename' => 'profile-wp-pc',
				'label'    => 'WordPress',
				'modifier' => 'wordpress',
				'width'    => 134,
				'height'   => 130,
			),
		),
	),
	array(
		'modifier' => 'design',
		'title'    => 'デザイン',
		'items'    => array(
			array(
				'basename' => 'profile-ai-pc',
				'label'    => 'Illustrator',
				'modifier' => 'illustrator',
				'width'    => 97,
				'height'   => 97,
			),
			array(
				'basename' => 'profile-ps-pc',
				'label'    => 'Photoshop',
				'modifier' => 'photoshop',
				'width'    => 97,
				'height'   => 97,
			),
			array(
				'basename' => 'profile-xd-pc',
				'label'    => 'XD',
				'modifier' => 'xd',
				'width'    => 98,
				'height'   => 98,
			),
			array(
				'basename' => 'profile-figma-pc',
				'label'    => 'Figma',
				'modifier' => 'figma',
				'width'    => 67,
				'height'   => 100,
			),
		),
	),
	array(
		'modifier' => 'communication',
		'title'    => 'コミュニケーション',
		'items'    => array(
			array(
				'basename' => 'profile-chatwork-pc',
				'label'    => 'Chatwork',
				'modifier' => 'chatwork',
				'width'    => 94,
				'height'   => 94,
			),
			array(
				'basename' => 'profile-mail-pc',
				'label'    => 'メール',
				'modifier' => 'mail',
				'width'    => 100,
				'height'   => 100,
			),
			array(
				'basename' => 'profile-slack-pc',
				'label'    => 'Slack',
				'modifier' => 'slack',
				'width'    => 93,
				'height'   => 93,
			),
			array(
				'basename' => 'profile-line-pc',
				'label'    => 'LINE',
				'modifier' => 'line',
				'width'    => 109,
				'height'   => 109,
			),
		),
	),
);

$profile_skill_rows = array(
	array(
		'modifier' => 'top',
		'items'    => array_slice( $profile_skill_groups, 0, 2 ),
	),
	array(
		'modifier' => 'bottom',
		'items'    => array_slice( $profile_skill_groups, 2 ),
	),
);

$profile_career_text = 'ここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入る';
$profile_work_text   = 'ここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入るここにテキスト入る';

$render_profile_picture = static function ( $picture, $picture_class = '', $image_class = '', $loading = 'lazy' ) use ( $theme_uri ) {
	$basename = isset( $picture['basename'] ) ? (string) $picture['basename'] : '';
	$alt      = isset( $picture['alt'] ) ? (string) $picture['alt'] : '';
	$modifier = isset( $picture['modifier'] ) ? (string) $picture['modifier'] : '';
	$width    = isset( $picture['width'] ) ? (int) $picture['width'] : 0;
	$height   = isset( $picture['height'] ) ? (int) $picture['height'] : 0;
	$image_classes = trim( (string) $image_class );

	if ( '' !== $modifier ) {
		$image_classes = trim( $image_classes . ' p-profile-page__skill-image--' . sanitize_html_class( $modifier ) );
	}

	if ( '' === $basename || 0 >= $width || 0 >= $height ) {
		return '';
	}

	ob_start();
	?>
	<picture class="<?php echo esc_attr( $picture_class ); ?>">
		<source srcset="<?php echo esc_url( $theme_uri . '/assets/images/' . $basename . '.webp' ); ?>" type="image/webp">
		<img class="<?php echo esc_attr( $image_classes ); ?>" src="<?php echo esc_url( $theme_uri . '/assets/images/' . $basename . '.png' ); ?>" alt="<?php echo esc_attr( $alt ); ?>" width="<?php echo esc_attr( $width ); ?>" height="<?php echo esc_attr( $height ); ?>" loading="<?php echo esc_attr( $loading ); ?>" decoding="async">
	</picture>
	<?php

	return (string) ob_get_clean();
};
?>

<main class="p-profile-page">
	<?php
	get_template_part(
		'template-parts/common/page-fv',
		null,
		array(
			'title'     => 'PROFILE',
			'sub_title' => '経歴・職歴',
			'image_pc'  => 'profile-fv-pc.webp',
			'image_sp'  => 'profile-fv-pc.webp',
			'width_pc'  => 2880,
			'height_pc' => 960,
			'width_sp'  => 375,
			'height_sp' => 230,
		)
	);
	?>

	<section class="p-profile-page__body">
		<div class="p-profile-page__inner l-inner">
			<?php
			get_template_part(
				'template-parts/common/breadcrumb',
				null,
				array(
					'context_class' => 'p-profile-page__breadcrumb',
				)
			);
			?>

			<section class="p-profile-page__skills" aria-labelledby="profile-skill-title">
				<div class="p-profile-page__heading c-section-heading">
					<h2 class="p-profile-page__heading-title c-section-heading__title" id="profile-skill-title">CODE SKILL</h2>
					<p class="p-profile-page__heading-sub c-section-heading__sub">対応が可能なコーディングスキルと<br class="u-sp">デザインデータ</br></p>
				</div>

				<div class="p-profile-page__skills-grid">
					<?php foreach ( $profile_skill_rows as $skill_row ) : ?>
						<div class="p-profile-page__skills-row p-profile-page__skills-row--<?php echo esc_attr( $skill_row['modifier'] ); ?>">
							<?php foreach ( $skill_row['items'] as $skill_group ) : ?>
								<section class="p-profile-page__skill-card p-profile-page__skill-card--<?php echo esc_attr( $skill_group['modifier'] ); ?>">
									<h3 class="p-profile-page__skill-card-title"><?php echo esc_html( $skill_group['title'] ); ?></h3>
									<ul class="p-profile-page__skill-list p-profile-page__skill-list--<?php echo esc_attr( $skill_group['modifier'] ); ?>">
										<?php foreach ( $skill_group['items'] as $skill_item ) : ?>
											<li class="p-profile-page__skill-item p-profile-page__skill-item--<?php echo esc_attr( $skill_item['modifier'] ); ?>">
												<figure class="p-profile-page__skill-figure">
													<?php echo $render_profile_picture( $skill_item, 'p-profile-page__skill-picture', 'p-profile-page__skill-image' ); ?>
													<figcaption class="p-profile-page__skill-label"><?php echo esc_html( $skill_item['label'] ); ?></figcaption>
												</figure>
											</li>
										<?php endforeach; ?>
									</ul>
								</section>
							<?php endforeach; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</section>
		</div>
	</section>

	<section class="p-profile-page__detail">
		<div class="p-profile-page__detail-inner l-inner">
			<div class="p-profile-page__detail-layout">
				<div class="p-profile-page__media">
					<div class="p-profile-page__main-visual">
						<?php echo $render_profile_picture( $profile_pictures['main'], 'p-profile-page__picture p-profile-page__picture--main', 'p-profile-page__image p-profile-page__image--main' ); ?>
					</div>
					<div class="p-profile-page__sub-visuals">
						<div class="p-profile-page__sub-visual p-profile-page__sub-visual--hobby">
							<?php echo $render_profile_picture( $profile_pictures['hobby'], 'p-profile-page__picture p-profile-page__picture--sub p-profile-page__picture--hobby', 'p-profile-page__image p-profile-page__image--sub' ); ?>
						</div>
						<div class="p-profile-page__sub-visual p-profile-page__sub-visual--camera">
							<?php echo $render_profile_picture( $profile_pictures['camera'], 'p-profile-page__picture p-profile-page__picture--sub p-profile-page__picture--camera', 'p-profile-page__image p-profile-page__image--sub' ); ?>
						</div>
					</div>
				</div>

				<div class="p-profile-page__content">
					<div class="p-profile-page__name-block">
						<h2 class="p-profile-page__name">田中 太郎</h2>
						<p class="p-profile-page__name-en">Tanaka Tarou</p>
					</div>

					<section class="p-profile-page__text-block" aria-labelledby="profile-career-title">
						<h3 class="p-profile-page__section-title" id="profile-career-title">経歴</h3>
						<p class="p-profile-page__text"><?php echo esc_html( $profile_career_text ); ?></p>
					</section>

					<section class="p-profile-page__text-block p-profile-page__text-block--work" aria-labelledby="profile-work-title">
						<h3 class="p-profile-page__section-title" id="profile-work-title">職歴</h3>
						<p class="p-profile-page__text"><?php echo esc_html( $profile_work_text ); ?></p>
					</section>
				</div>
			</div>
		</div>
	</section>

	<section class="p-profile-page__common-cta p-common-cta c-cta">
		<div class="p-common-cta__inner c-cta__inner l-inner l-inner--cta">
			<?php get_template_part( 'template-parts/common/contact-cta' ); ?>
			<?php get_template_part( 'template-parts/common/faq-cta' ); ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>
