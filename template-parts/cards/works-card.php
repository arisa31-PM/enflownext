<?php
/**
 * Works Card
 */

$post_id = get_the_ID();
$is_slider = (bool) get_query_var( 'works_card_is_slider', true );
$tag       = my_get_works_genre_name( $post_id );

$article_classes = array( 'p-works__card' );

if ( $is_slider ) {
	$article_classes[] = 'swiper-slide';
}

$title = get_the_title( $post_id );
$title = trim( $title );
?>

<article class="<?php echo esc_attr( implode( ' ', $article_classes ) ); ?>">
	<a class="p-works__link" href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
		<figure class="p-works__figure">
			<?php
			echo my_get_responsive_featured_picture(
				array(
					'post_id'       => $post_id,
					'sp_field'      => 'featured_image_sp',
					'pc_size'       => 'large',
					'sp_size'       => 'large',
					'class'         => 'p-works__image',
					'picture_class' => 'p-works__picture',
					'loading'       => 'lazy',
				)
			);
			?>
			<span class="p-works__tag c-tag"><?php echo esc_html( $tag ); ?></span>
		</figure>
		<div class="p-works__body">
			<p class="p-works__text">
				<?php echo esc_html( $title ); ?>
			</p>
		</div>
	</a>
</article>
