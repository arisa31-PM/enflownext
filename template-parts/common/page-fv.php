<?php
/**
 * Page First View
 *
 * @param array $args {
 *     @type string $title       English title.
 *     @type string $sub_title   Japanese subtitle.
 *     @type string $image       PC background image filename.
 *     @type string $image_pc    PC background image filename.
 *     @type string $image_sp    SP background image filename.
 *     @type int    $width       PC image width.
 *     @type int    $height      PC image height.
 *     @type int    $width_pc    PC image width.
 *     @type int    $height_pc   PC image height.
 *     @type int    $width_sp    SP image width.
 *     @type int    $height_sp   SP image height.
 *     @type int    $post_id     FV画像を取得する投稿ID。
 * }
 */

$title     = isset( $args['title'] ) ? (string) $args['title'] : '';
$sub_title = isset( $args['sub_title'] ) ? (string) $args['sub_title'] : '';
$image_pc  = isset( $args['image_pc'] ) ? (string) $args['image_pc'] : '';

if ( '' === $image_pc && isset( $args['image'] ) ) {
	$image_pc = (string) $args['image'];
}

$image_sp  = isset( $args['image_sp'] ) ? (string) $args['image_sp'] : $image_pc;
$width_pc  = isset( $args['width_pc'] ) ? (int) $args['width_pc'] : ( isset( $args['width'] ) ? (int) $args['width'] : 2880 );
$height_pc = isset( $args['height_pc'] ) ? (int) $args['height_pc'] : ( isset( $args['height'] ) ? (int) $args['height'] : 960 );
$width_sp  = isset( $args['width_sp'] ) ? (int) $args['width_sp'] : $width_pc;
$height_sp = isset( $args['height_sp'] ) ? (int) $args['height_sp'] : $height_pc;

if ( '' === $title || '' === $image_pc ) {
	return;
}

$theme_uri = get_template_directory_uri();
$post_id   = isset( $args['post_id'] ) ? (int) $args['post_id'] : 0;

if ( 0 >= $post_id ) {
	if ( is_home() ) {
		$post_id = (int) get_option( 'page_for_posts' );
	} elseif ( is_singular() ) {
		$post_id = get_queried_object_id();
	} elseif ( is_post_type_archive() ) {
		$post_type = get_query_var( 'post_type' );

		if ( is_array( $post_type ) ) {
			$post_type = reset( $post_type );
		}

		$post_type = trim( (string) $post_type );

		if ( '' !== $post_type ) {
			$post_type_object = get_post_type_object( $post_type );
			$page_slugs       = array( $post_type );

			if ( $post_type_object instanceof WP_Post_Type && ! empty( $post_type_object->rewrite['slug'] ) ) {
				$page_slugs[] = (string) $post_type_object->rewrite['slug'];
			}

			foreach ( array_unique( $page_slugs ) as $page_slug ) {
				$archive_page = get_page_by_path( $page_slug );

				if ( $archive_page instanceof WP_Post ) {
					$post_id = (int) $archive_page->ID;
					break;
				}
			}
		}
	}
}

$use_dynamic_image = 0 < $post_id;

if ( ! $use_dynamic_image ) {
	$resolve_static_fv_image = static function ( $image_filename, $fallback_width, $fallback_height ) {
		$image_filename = ltrim( (string) $image_filename, '/' );
		$image_path     = get_theme_file_path( 'assets/images/' . $image_filename );
		$image_fallback = preg_replace( '/\.webp$/i', '.png', $image_filename );
		$fallback_path  = get_theme_file_path( 'assets/images/' . $image_fallback );

		if ( ! file_exists( $image_path ) && ! file_exists( $fallback_path ) ) {
			$image_filename = 'no-image.webp';
			$image_path     = get_theme_file_path( 'assets/images/no-image.webp' );
			$image_fallback = 'no-image.png';
			$fallback_path  = get_theme_file_path( 'assets/images/no-image.png' );
		}

		$size_path = file_exists( $fallback_path ) ? $fallback_path : $image_path;

		if ( file_exists( $size_path ) ) {
			$image_size = wp_getimagesize( $size_path );

			if ( is_array( $image_size ) && isset( $image_size[0], $image_size[1] ) ) {
				$fallback_width  = (int) $image_size[0];
				$fallback_height = (int) $image_size[1];
			}
		}

		return array(
			'webp'     => file_exists( $image_path ) ? $image_filename : '',
			'fallback' => file_exists( $fallback_path ) ? $image_fallback : $image_filename,
			'width'    => $fallback_width,
			'height'   => $fallback_height,
		);
	};

	$static_image_pc = $resolve_static_fv_image( $image_pc, $width_pc, $height_pc );
	$static_image_sp = $resolve_static_fv_image( $image_sp, $width_sp, $height_sp );
}
?>

<section class="p-page-fv" aria-label="<?php echo esc_attr( $title ); ?>">
	<?php if ( $use_dynamic_image ) : ?>
		<?php
		echo my_get_responsive_featured_picture(
			array(
				'post_id'       => $post_id,
				'sp_field'      => 'featured_image_sp',
				'pc_size'       => 'full',
				'sp_size'       => 'large',
				'class'         => 'p-page-fv__image',
				'picture_class' => 'p-page-fv__picture',
				'alt'           => '',
				'loading'       => 'eager',
				'fetchpriority' => 'high',
				'fallback_width'  => $width_pc,
				'fallback_height' => $height_pc,
			)
		);
		?>
	<?php else : ?>
		<picture class="p-page-fv__picture skip-lazy" data-skip-lazy="1">
			<?php if ( ! empty( $static_image_pc['webp'] ) ) : ?>
				<source srcset="<?php echo esc_url( $theme_uri . '/assets/images/' . $static_image_pc['webp'] ); ?>" media="(min-width: 768px)" type="image/webp">
			<?php endif; ?>
			<source srcset="<?php echo esc_url( $theme_uri . '/assets/images/' . $static_image_pc['fallback'] ); ?>" media="(min-width: 768px)">
			<?php if ( ! empty( $static_image_sp['webp'] ) ) : ?>
				<source srcset="<?php echo esc_url( $theme_uri . '/assets/images/' . $static_image_sp['webp'] ); ?>" type="image/webp">
			<?php endif; ?>
			<img class="p-page-fv__image skip-lazy" src="<?php echo esc_url( $theme_uri . '/assets/images/' . $static_image_sp['fallback'] ); ?>" alt="" width="<?php echo esc_attr( $static_image_sp['width'] ); ?>" height="<?php echo esc_attr( $static_image_sp['height'] ); ?>" loading="eager" fetchpriority="high" decoding="async" data-skip-lazy="1">
		</picture>
	<?php endif; ?>
	<div class="p-page-fv__content l-inner">
		<div class="p-page-fv__heading c-page-heading">
			<h1 class="p-page-fv__title c-page-heading__title"><?php echo esc_html( $title ); ?></h1>
			<?php if ( '' !== $sub_title ) : ?>
				<p class="p-page-fv__sub c-page-heading__sub"><?php echo esc_html( $sub_title ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>
