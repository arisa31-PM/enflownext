<?php
/**
 * News Archives
 */

$archives = wp_get_archives(
	array(
		'type'            => 'monthly',
		'format'          => 'custom',
		'before'          => '<li class="p-news-sidebar__item">',
		'after'           => '</li>',
		'show_post_count' => false,
		'echo'            => false,
	)
);

$archives = str_replace( '<a ', '<a class="p-news-sidebar__link" ', $archives );
?>

<section class="p-news-sidebar__section p-news-sidebar__section--archive">
	<div class="p-news-sidebar__heading">
		<h2 class="p-news-sidebar__title">ARCHIVE</h2>
		<p class="p-news-sidebar__sub">アーカイブ</p>
	</div>

	<?php if ( '' !== trim( $archives ) ) : ?>
		<ul class="p-news-sidebar__list">
			<?php echo wp_kses_post( $archives ); ?>
		</ul>
	<?php else : ?>
		<p class="p-news-sidebar__empty">アーカイブがありません。</p>
	<?php endif; ?>
</section>
