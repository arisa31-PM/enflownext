<?php
/**
 * Works Related Card
 */

$post_id = get_the_ID();
$tag     = my_get_works_genre_name( $post_id );

$title = get_the_title( $post_id );
$title = trim( $title );
?>

<article class="p-works-related-card">
	<a class="p-works-related-card__link" href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
		<figure class="p-works-related-card__figure">
			<?php
			echo my_get_responsive_featured_picture(
				array(
					'post_id'       => $post_id,
					'sp_field'      => 'featured_image_sp',
					'pc_size'       => 'large',
					'sp_size'       => 'large',
					'class'         => 'p-works-related-card__image',
					'picture_class' => 'p-works-related-card__picture',
					'loading'       => 'lazy',
				)
			);
			?>
			<span class="p-works-related-card__tag c-tag"><?php echo esc_html( $tag ); ?></span>
		</figure>
		<div class="p-works-related-card__body">
			<?php if ( '' !== $title ) : ?>
				<p class="p-works-related-card__text"><?php echo esc_html( $title ); ?></p>
			<?php endif; ?>
		</div>
	</a>
</article>
