<?php
/**
 * Functions
 */
/**
 * WordPress標準機能
  *
 * @codex https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/add_theme_support
 */
function my_setup() {
	add_theme_support( 'post-thumbnails' ); /* アイキャッチ */
	add_theme_support( 'automatic-feed-links' ); /* RSSフィード */
	add_theme_support( 'title-tag' ); /* タイトルタグ自動生成 */
	add_theme_support(
		'html5',
		array( /* HTML5のタグで出力 */
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

	register_nav_menus(
		array(
			'global' => 'グローバルナビゲーション',
			'footer' => 'フッターナビゲーション',
		)
	);
}
add_action( 'after_setup_theme', 'my_setup' );

/**
 * 通常投稿を「お知らせ」として運用するための設定
 *
 * @return void
 */
function my_news_post_setup() {
	add_post_type_support( 'post', 'excerpt' );

	if ( taxonomy_exists( 'post_tag' ) ) {
		unregister_taxonomy_for_object_type( 'post_tag', 'post' );
	}
}
add_action( 'init', 'my_news_post_setup' );

/**
 * 通常投稿の管理画面ラベルを「お知らせ」に変更する
 *
 * @param object $labels 投稿ラベル。
 * @return object
 */
function my_news_post_labels( $labels ) {
	$labels->name               = 'お知らせ';
	$labels->singular_name      = 'お知らせ';
	$labels->menu_name          = 'お知らせ';
	$labels->name_admin_bar     = 'お知らせ';
	$labels->add_new            = 'お知らせを追加';
	$labels->add_new_item       = 'お知らせを追加';
	$labels->new_item           = '新しいお知らせ';
	$labels->edit_item          = 'お知らせを編集';
	$labels->view_item          = 'お知らせを表示';
	$labels->all_items          = 'すべてのお知らせ';
	$labels->search_items       = 'お知らせを検索';
	$labels->parent_item_colon  = '親お知らせ:';
	$labels->not_found          = 'お知らせが見つかりませんでした';
	$labels->not_found_in_trash = 'ゴミ箱にお知らせはありません';
	$labels->archives           = 'お知らせアーカイブ';
	$labels->attributes         = 'お知らせの属性';
	$labels->insert_into_item   = 'お知らせに挿入';
	$labels->uploaded_to_this_item = 'このお知らせにアップロード済み';
	$labels->featured_image     = 'アイキャッチ画像';
	$labels->set_featured_image = 'アイキャッチ画像を設定';
	$labels->remove_featured_image = 'アイキャッチ画像を削除';
	$labels->use_featured_image = 'アイキャッチ画像として使用';
	$labels->filter_items_list  = 'お知らせ一覧を絞り込む';
	$labels->items_list_navigation = 'お知らせ一覧ナビゲーション';
	$labels->items_list         = 'お知らせ一覧';
	$labels->item_published     = 'お知らせを公開しました';
	$labels->item_updated       = 'お知らせを更新しました';
	$labels->item_saved         = 'お知らせを保存しました';
	$labels->item_reverted_to_draft = 'お知らせを下書きに戻しました';
	$labels->item_scheduled     = 'お知らせを予約投稿しました';
	$labels->item_trashed       = 'お知らせをゴミ箱に移動しました';
	$labels->item_link          = 'お知らせリンク';
	$labels->item_link_description = 'お知らせへのリンク';

	return $labels;
}
add_filter( 'post_type_labels_post', 'my_news_post_labels' );

/**
 * お知らせカテゴリーのラベルを変更する
 *
 * @param array  $args       taxonomy登録時の引数。
 * @param string $taxonomy   タクソノミー名。
 * @param array  $object_type 対象の投稿タイプ。
 * @return array
 */
function my_news_category_labels( $args, $taxonomy, $object_type ) {
	if ( 'category' !== $taxonomy ) {
		return $args;
	}

	$labels = isset( $args['labels'] ) && is_array( $args['labels'] ) ? $args['labels'] : array();

	$labels['name']                     = 'お知らせカテゴリー';
	$labels['singular_name']            = 'お知らせカテゴリー';
	$labels['menu_name']                = 'お知らせカテゴリー';
	$labels['all_items']                = 'すべてのお知らせカテゴリー';
	$labels['edit_item']                = 'お知らせカテゴリーを編集';
	$labels['view_item']                = 'お知らせカテゴリーを表示';
	$labels['update_item']              = 'お知らせカテゴリーを更新';
	$labels['add_new_item']             = '新規お知らせカテゴリーを追加';
	$labels['new_item_name']            = '新しいお知らせカテゴリーの名前';
	$labels['parent_item']              = '親お知らせカテゴリー';
	$labels['parent_item_colon']        = '親お知らせカテゴリー:';
	$labels['search_items']             = 'お知らせカテゴリーを検索';
	$labels['popular_items']            = 'よく使われているお知らせカテゴリー';
	$labels['separate_items_with_commas'] = 'お知らせカテゴリーをカンマで区切ってください';
	$labels['add_or_remove_items']      = 'お知らせカテゴリーを追加または削除';
	$labels['choose_from_most_used']    = 'よく使われているお知らせカテゴリーから選択';
	$labels['not_found']                = 'お知らせカテゴリーが見つかりませんでした';
	$labels['no_terms']                 = 'お知らせカテゴリーはありません';
	$labels['items_list_navigation']    = 'お知らせカテゴリー一覧ナビゲーション';
	$labels['items_list']               = 'お知らせカテゴリー一覧';

	$args['labels'] = $labels;

	return $args;
}
add_filter( 'register_taxonomy_args', 'my_news_category_labels', 10, 3 );

/**
 * 管理画面の「投稿」メニューアイコンをお知らせ向けに変更する
 *
 * @return void
 */
function my_news_admin_menu_icon() {
	global $menu;

	if ( empty( $menu ) || ! is_array( $menu ) ) {
		return;
	}

	foreach ( $menu as $index => $item ) {
		if ( isset( $item[2] ) && 'edit.php' === $item[2] ) {
			$menu[ $index ][6] = 'dashicons-megaphone';
			break;
		}
	}
}
add_action( 'admin_menu', 'my_news_admin_menu_icon', 999 );

/**
 * お知らせ一覧URLを取得する
 *
 * @return string
 */
function my_get_news_archive_url() {
	$news_page_id = (int) get_option( 'page_for_posts' );

	if ( 0 < $news_page_id ) {
		$news_page_url = get_permalink( $news_page_id );

		if ( $news_page_url ) {
			return $news_page_url;
		}
	}

	return home_url( '/news/' );
}

/**
 * 実績一覧URLを取得する
 *
 * @return string
 */
function my_get_works_archive_url() {
	$works_archive_url = get_post_type_archive_link( 'works' );

	if ( $works_archive_url ) {
		return $works_archive_url;
	}

	return home_url( '/works/' );
}

/**
 * 固定ページURLを取得する
 *
 * @param string $slug 固定ページスラッグ。
 * @return string
 */
function my_get_page_url( $slug ) {
	$slug = trim( (string) $slug );

	if ( '' === $slug ) {
		return home_url( '/' );
	}

	$page = get_page_by_path( $slug );

	if ( $page instanceof WP_Post ) {
		$page_url = get_permalink( $page );

		if ( $page_url ) {
			return (string) $page_url;
		}
	}

	if ( 'thanks' === $slug ) {
		return home_url( '/contact/thanks/' );
	}

	return home_url( '/' . trim( $slug, '/' ) . '/' );
}

/**
 * 画像URLに対応するWebP画像URLを取得する
 *
 * @param string $image_url 画像URL。
 * @return string
 */
function my_get_webp_image_url( $image_url ) {
	$image_url = trim( (string) $image_url );

	if ( '' === $image_url ) {
		return '';
	}

	$candidates     = array();
	$parsed_url     = wp_parse_url( $image_url );
	$image_url_path = isset( $parsed_url['path'] ) ? (string) $parsed_url['path'] : '';

	if ( '' !== $image_url_path && false !== strpos( $image_url_path, '/wp-content/uploads/' ) ) {
		$relative_path = ltrim( substr( $image_url_path, strpos( $image_url_path, '/wp-content/uploads/' ) + strlen( '/wp-content/uploads/' ) ), '/' );
		$image_path    = trailingslashit( WP_CONTENT_DIR ) . 'uploads/' . $relative_path;

		$candidates[] = array(
			'path' => $image_path . '.webp',
			'url'  => $image_url . '.webp',
		);
		$candidates[] = array(
			'path' => preg_replace( '/\.(jpe?g|png|gif)$/i', '.webp', $image_path ),
			'url'  => preg_replace( '/\.(jpe?g|png|gif)$/i', '.webp', $image_url ),
		);
	}

	if ( '' !== $image_url_path && false !== strpos( $image_url_path, '/wp-content/themes/' . get_template() . '/' ) ) {
		$relative_path = ltrim( substr( $image_url_path, strpos( $image_url_path, '/wp-content/themes/' . get_template() . '/' ) + strlen( '/wp-content/themes/' . get_template() . '/' ) ), '/' );
		$image_path    = get_theme_file_path( $relative_path );

		$candidates[] = array(
			'path' => $image_path . '.webp',
			'url'  => $image_url . '.webp',
		);
		$candidates[] = array(
			'path' => preg_replace( '/\.(jpe?g|png|gif)$/i', '.webp', $image_path ),
			'url'  => preg_replace( '/\.(jpe?g|png|gif)$/i', '.webp', $image_url ),
		);
	}

	foreach ( $candidates as $candidate ) {
		if ( ! empty( $candidate['path'] ) && file_exists( $candidate['path'] ) && ! empty( $candidate['url'] ) ) {
			return (string) $candidate['url'];
		}
	}

	return '';
}

/**
 * SCF画像フィールドから添付画像IDを取得する
 *
 * @param string $field_name SCFフィールド名。
 * @param int    $post_id    投稿ID。
 * @return int
 */
function my_get_scf_image_id( $field_name, $post_id = 0 ) {
	if ( '' === trim( (string) $field_name ) || ! class_exists( 'SCF' ) ) {
		return 0;
	}

	$post_id = 0 < (int) $post_id ? (int) $post_id : get_the_ID();
	$value   = SCF::get( $field_name, $post_id );

	if ( is_array( $value ) ) {
		if ( isset( $value['ID'] ) ) {
			$value = $value['ID'];
		} elseif ( isset( $value['id'] ) ) {
			$value = $value['id'];
		} elseif ( isset( $value['url'] ) ) {
			$value = $value['url'];
		} else {
			$value = reset( $value );

			if ( is_array( $value ) ) {
				if ( isset( $value['ID'] ) ) {
					$value = $value['ID'];
				} elseif ( isset( $value['id'] ) ) {
					$value = $value['id'];
				} elseif ( isset( $value['url'] ) ) {
					$value = $value['url'];
				}
			}
		}
	}

	if ( is_numeric( $value ) ) {
		return (int) $value;
	}

	$image_url = trim( (string) $value );

	if ( '' === $image_url ) {
		return 0;
	}

	return (int) attachment_url_to_postid( $image_url );
}

/**
 * SCF画像フィールドから添付IDまたはURLを取得する
 *
 * @param string $field_name SCFフィールド名。
 * @param int    $post_id    投稿ID。
 * @return int|string
 */
function my_get_scf_image_value( $field_name, $post_id = 0 ) {
	$field_name = trim( (string) $field_name );

	if ( '' === $field_name ) {
		return 0;
	}

	$post_id = 0 < (int) $post_id ? (int) $post_id : get_the_ID();
	$value   = class_exists( 'SCF' ) ? SCF::get( $field_name, $post_id ) : '';

	if ( '' === $value || array() === $value || null === $value ) {
		$value = get_post_meta( $post_id, $field_name, true );
	}

	if ( '' === $value || array() === $value || null === $value ) {
		$meta_values = get_post_meta( $post_id, $field_name, false );

		if ( ! empty( $meta_values ) && is_array( $meta_values ) ) {
			$value = reset( $meta_values );
		}
	}

	if ( is_array( $value ) ) {
		if ( isset( $value['ID'] ) ) {
			$value = $value['ID'];
		} elseif ( isset( $value['id'] ) ) {
			$value = $value['id'];
		} elseif ( isset( $value['url'] ) ) {
			$value = $value['url'];
		} else {
			$value = reset( $value );

			if ( is_array( $value ) ) {
				if ( isset( $value['ID'] ) ) {
					$value = $value['ID'];
				} elseif ( isset( $value['id'] ) ) {
					$value = $value['id'];
				} elseif ( isset( $value['url'] ) ) {
					$value = $value['url'];
				}
			}
		}
	}

	if ( is_numeric( $value ) ) {
		return (int) $value;
	}

	return trim( (string) $value );
}

/**
 * 添付画像IDからpicture出力用の画像情報を取得する
 *
 * @param int    $attachment_id 添付画像ID。
 * @param string $size          画像サイズ。
 * @return array
 */
function my_get_attachment_picture_image_data( $attachment_id, $size = 'large' ) {
	$image = wp_get_attachment_image_src( (int) $attachment_id, $size );

	if ( empty( $image ) || ! is_array( $image ) || empty( $image[0] ) ) {
		return array();
	}

	return array(
		'id'     => (int) $attachment_id,
		'url'    => (string) $image[0],
		'webp'   => my_get_webp_image_url( (string) $image[0] ),
		'width'  => isset( $image[1] ) ? (int) $image[1] : 0,
		'height' => isset( $image[2] ) ? (int) $image[2] : 0,
	);
}

/**
 * 画像URLからpicture出力用の画像情報を取得する
 *
 * @param string $image_url 画像URL。
 * @return array
 */
function my_get_picture_image_data_from_url( $image_url ) {
	$image_url = trim( (string) $image_url );

	if ( '' === $image_url ) {
		return array();
	}

	$width      = 0;
	$height     = 0;
	$parsed_url = wp_parse_url( $image_url );
	$url_path   = isset( $parsed_url['path'] ) ? (string) $parsed_url['path'] : '';
	$image_path = '';

	if ( '' !== $url_path && false !== strpos( $url_path, '/wp-content/uploads/' ) ) {
		$relative_path = ltrim( substr( $url_path, strpos( $url_path, '/wp-content/uploads/' ) + strlen( '/wp-content/uploads/' ) ), '/' );
		$image_path    = trailingslashit( WP_CONTENT_DIR ) . 'uploads/' . $relative_path;
	} elseif ( '' !== $url_path && false !== strpos( $url_path, '/wp-content/themes/' . get_template() . '/' ) ) {
		$relative_path = ltrim( substr( $url_path, strpos( $url_path, '/wp-content/themes/' . get_template() . '/' ) + strlen( '/wp-content/themes/' . get_template() . '/' ) ), '/' );
		$image_path    = get_theme_file_path( $relative_path );
	}

	if ( '' !== $image_path && file_exists( $image_path ) ) {
		$image_size = wp_getimagesize( $image_path );

		if ( is_array( $image_size ) && isset( $image_size[0], $image_size[1] ) ) {
			$width  = (int) $image_size[0];
			$height = (int) $image_size[1];
		}
	}

	return array(
		'id'     => 0,
		'url'    => $image_url,
		'webp'   => my_get_webp_image_url( $image_url ),
		'width'  => $width,
		'height' => $height,
	);
}

/**
 * テーマ内no-imageのpicture出力用画像情報を取得する
 *
 * @return array
 */
function my_get_no_image_picture_data() {
	$no_image_path = get_theme_file_path( 'assets/images/no-image.png' );
	$no_image_url  = get_theme_file_uri( 'assets/images/no-image.png' );
	$width         = 1663;
	$height        = 946;

	if ( file_exists( $no_image_path ) ) {
		$image_size = wp_getimagesize( $no_image_path );

		if ( is_array( $image_size ) && isset( $image_size[0], $image_size[1] ) ) {
			$width  = (int) $image_size[0];
			$height = (int) $image_size[1];
		}
	}

	return array(
		'id'     => 0,
		'url'    => $no_image_url,
		'webp'   => my_get_webp_image_url( $no_image_url ),
		'width'  => $width,
		'height' => $height,
	);
}

/**
 * 添付画像ID・画像URL・SCF画像配列からpicture出力用の画像情報を取得する
 *
 * @param int|string|array $image_value 添付画像ID、画像URL、SCF画像配列。
 * @param string           $size        画像サイズ。
 * @return array
 */
function my_get_picture_image_data_from_value( $image_value, $size = 'large' ) {
	if ( is_array( $image_value ) ) {
		if ( isset( $image_value['ID'] ) ) {
			$image_value = $image_value['ID'];
		} elseif ( isset( $image_value['id'] ) ) {
			$image_value = $image_value['id'];
		} elseif ( isset( $image_value['url'] ) ) {
			$image_value = $image_value['url'];
		} else {
			$image_value = reset( $image_value );

			if ( is_array( $image_value ) ) {
				return my_get_picture_image_data_from_value( $image_value, $size );
			}
		}
	}

	if ( is_numeric( $image_value ) ) {
		$image_data = my_get_attachment_picture_image_data( (int) $image_value, $size );

		return ! empty( $image_data ) ? $image_data : array();
	}

	$image_url = trim( (string) $image_value );

	if ( '' === $image_url ) {
		return array();
	}

	$attachment_id = attachment_url_to_postid( $image_url );

	if ( 0 < $attachment_id ) {
		$image_data = my_get_attachment_picture_image_data( $attachment_id, $size );

		if ( ! empty( $image_data ) ) {
			return $image_data;
		}
	}

	return my_get_picture_image_data_from_url( $image_url );
}

/**
 * PC/SP・WebPフォールバックつきpictureタグを出力する
 *
 * @param array $args {
 *     @type int|string|array $pc_image        PC画像。
 *     @type int|string|array $sp_image        SP画像。
 *     @type string           $pc_size         PC画像サイズ。
 *     @type string           $sp_size         SP画像サイズ。
 *     @type string           $class           imgに付与するclass。
 *     @type string           $picture_class   pictureに付与するclass。
 *     @type string           $alt             alt属性。
 *     @type string           $loading         loading属性。
 *     @type string           $fetchpriority   fetchpriority属性。
 *     @type int              $fallback_width  no-imageのwidth属性。
 *     @type int              $fallback_height no-imageのheight属性。
 * }
 * @return string
 */
function my_get_responsive_picture( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'pc_image'        => '',
			'sp_image'        => '',
			'pc_size'         => 'large',
			'sp_size'         => 'large',
			'class'           => '',
			'picture_class'   => '',
			'alt'             => '',
			'loading'         => 'lazy',
			'fetchpriority'   => '',
			'fallback_width'  => 0,
			'fallback_height' => 0,
		)
	);

	$pc_image_data = my_get_picture_image_data_from_value( $args['pc_image'], $args['pc_size'] );
	$sp_image_data = my_get_picture_image_data_from_value( $args['sp_image'], $args['sp_size'] );
	$no_image_data = my_get_no_image_picture_data();

	if ( empty( $pc_image_data ) ) {
		$pc_image_data = $no_image_data;

		if ( 0 < (int) $args['fallback_width'] && 0 < (int) $args['fallback_height'] ) {
			$pc_image_data['width']  = (int) $args['fallback_width'];
			$pc_image_data['height'] = (int) $args['fallback_height'];
		}
	}

	if ( empty( $sp_image_data ) ) {
		$sp_image_data = $pc_image_data;
	}

	$alt = (string) $args['alt'];

	if ( '' === trim( $alt ) && ! empty( $pc_image_data['id'] ) ) {
		$alt = get_post_meta( (int) $pc_image_data['id'], '_wp_attachment_image_alt', true );
	}

	if ( '' === trim( $alt ) && ! empty( $sp_image_data['id'] ) ) {
		$alt = get_post_meta( (int) $sp_image_data['id'], '_wp_attachment_image_alt', true );
	}

	$img_attributes = array(
		'class'    => (string) $args['class'],
		'src'      => $pc_image_data['url'],
		'alt'      => $alt,
		'width'    => 0 < (int) $pc_image_data['width'] ? (int) $pc_image_data['width'] : $no_image_data['width'],
		'height'   => 0 < (int) $pc_image_data['height'] ? (int) $pc_image_data['height'] : $no_image_data['height'],
		'loading'  => (string) $args['loading'],
		'decoding' => 'async',
	);

	if ( 'eager' === $args['loading'] ) {
		$img_attributes['class']          = trim( $img_attributes['class'] . ' skip-lazy' );
		$img_attributes['data-skip-lazy'] = '1';
	}

	if ( '' !== trim( (string) $args['fetchpriority'] ) ) {
		$img_attributes['fetchpriority'] = (string) $args['fetchpriority'];
	}

	$picture_class = trim( (string) $args['picture_class'] );

	if ( 'eager' === $args['loading'] ) {
		$picture_class = trim( $picture_class . ' skip-lazy' );
	}

	ob_start();
	?>
	<picture<?php echo '' !== $picture_class ? ' class="' . esc_attr( $picture_class ) . '"' : ''; ?><?php echo 'eager' === $args['loading'] ? ' data-skip-lazy="1"' : ''; ?>>
		<?php if ( ! empty( $sp_image_data['webp'] ) ) : ?>
			<source media="(max-width: 767px)" srcset="<?php echo esc_url( $sp_image_data['webp'] ); ?>" type="image/webp">
		<?php endif; ?>
		<source media="(max-width: 767px)" srcset="<?php echo esc_url( $sp_image_data['url'] ); ?>">
		<?php if ( ! empty( $pc_image_data['webp'] ) ) : ?>
			<source srcset="<?php echo esc_url( $pc_image_data['webp'] ); ?>" type="image/webp">
		<?php endif; ?>
		<img
			<?php foreach ( $img_attributes as $name => $value ) : ?>
				<?php if ( '' !== trim( (string) $value ) ) : ?>
					<?php echo esc_attr( $name ); ?>="<?php echo esc_attr( $value ); ?>"
				<?php endif; ?>
			<?php endforeach; ?>
		>
	</picture>
	<?php
	return trim( ob_get_clean() );
}

/**
 * PC/SP・WebPフォールバックつきpictureタグを出力する
 *
 * @param array $args {
 *     @type int    $post_id       投稿ID。
 *     @type string $sp_field      SP画像用SCFフィールド名。
 *     @type string $pc_size       PC画像サイズ。
 *     @type string $sp_size       SP画像サイズ。
 *     @type string $class         imgに付与するclass。
 *     @type string $picture_class pictureに付与するclass。
 *     @type string $alt           alt属性。
 *     @type string $loading       loading属性。
 *     @type string $fetchpriority fetchpriority属性。
 *     @type int    $fallback_width  no-imageのwidth属性。
 *     @type int    $fallback_height no-imageのheight属性。
 * }
 * @return string
 */
function my_get_responsive_featured_picture( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'post_id'       => get_the_ID(),
			'sp_field'      => 'featured_image_sp',
			'pc_size'       => 'large',
			'sp_size'       => 'large',
			'class'         => '',
			'picture_class' => '',
			'alt'           => '',
			'loading'       => 'lazy',
			'fetchpriority' => '',
			'fallback_width'  => 0,
			'fallback_height' => 0,
		)
	);

	$post_id        = 0 < (int) $args['post_id'] ? (int) $args['post_id'] : get_the_ID();
	$thumbnail_id   = get_post_thumbnail_id( $post_id );
	$sp_image_value = my_get_scf_image_value( $args['sp_field'], $post_id );
	$has_sp_image   = ( is_int( $sp_image_value ) && 0 < $sp_image_value )
		|| ( is_string( $sp_image_value ) && '' !== $sp_image_value )
		|| ( is_array( $sp_image_value ) && ! empty( $sp_image_value ) );

	$alt = (string) $args['alt'];

	if ( '' === $alt && 0 < $thumbnail_id ) {
		$alt = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
	}

	if ( '' === trim( (string) $alt ) ) {
		$alt = get_the_title( $post_id );
	}

	return my_get_responsive_picture(
		array(
			'pc_image'        => $thumbnail_id,
			'sp_image'        => $has_sp_image ? $sp_image_value : $thumbnail_id,
			'pc_size'         => $args['pc_size'],
			'sp_size'         => $args['sp_size'],
			'class'           => $args['class'],
			'picture_class'   => $args['picture_class'],
			'alt'             => $alt,
			'loading'         => $args['loading'],
			'fetchpriority'   => $args['fetchpriority'],
			'fallback_width'  => $args['fallback_width'],
			'fallback_height' => $args['fallback_height'],
		)
	);
}

/**
 * Contact ページで使う Contact Form 7 のショートコードを解決する
 *
 * @return string
 */
function my_get_contact_form_shortcode() {
	if ( ! shortcode_exists( 'contact-form-7' ) ) {
		return '';
	}

	$preferred_titles = array(
		'CONTACTページ',
		'Contact form 1',
	);

	$forms = get_posts(
		array(
			'post_type'      => 'wpcf7_contact_form',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'date',
			'order'          => 'ASC',
		)
	);

	if ( empty( $forms ) ) {
		return '';
	}

	foreach ( $preferred_titles as $preferred_title ) {
		foreach ( $forms as $form ) {
			if ( ! ( $form instanceof WP_Post ) ) {
				continue;
			}

			if ( $preferred_title === $form->post_title ) {
				return sprintf( '[contact-form-7 id="%d"]', (int) $form->ID );
			}
		}
	}

	$form = reset( $forms );

	if ( ! ( $form instanceof WP_Post ) ) {
		return '';
	}

	return sprintf( '[contact-form-7 id="%d"]', (int) $form->ID );
}

/**
 * 必須バッジのHTMLを返す
 *
 * @return string
 */
function my_contact_required_badge_html() {
	return '<span class="c-tag c-tag--required">必須</span>';
}

/**
 * Confirm Plus Contact Form 7 の確認画面で必須バッジを整形する
 *
 * @param string $form_html フォームHTML。
 * @return string
 */
function my_contact_format_confirm_required_badges( $form_html ) {
	$form_html = (string) $form_html;

	if ( '' === $form_html ) {
		return '';
	}

	$required_badge = my_contact_required_badge_html();

	$required_labels = array(
		'お問い合わせ内容',
		'お名前',
		'ふりがな',
		'メールアドレス',
	);

	foreach ( $required_labels as $required_label ) {
		$form_html = preg_replace(
			'/' . preg_quote( $required_label, '/' ) . '\s*必須/u',
			$required_label . ' ' . $required_badge,
			$form_html
		);
	}

	$form_html = preg_replace(
		'/プライバシーポリシーに同意する(?!\s*<span class="c-tag c-tag--required">必須<\/span>)/u',
		'プライバシーポリシーに同意する ' . $required_badge,
		$form_html,
		1
	);

	$form_html = preg_replace(
		'/<span\b[^>]*(?:p-contact-page__required|required|is-required|wpcf7cp-required)[^>]*>\s*必須\s*<\/span>/iu',
		$required_badge,
		$form_html
	);

	return $form_html;
}

/**
 * Contact Form 7 の出力を contact ページ向けに整形する
 *
 * @param string $shortcode Contact Form 7 ショートコード。
 * @return string
 */
function my_render_contact_form( $shortcode ) {
	$shortcode = trim( (string) $shortcode );

	if ( '' === $shortcode || ! shortcode_exists( 'contact-form-7' ) ) {
		return '';
	}

	$form_html = do_shortcode( $shortcode );

	if ( '' === $form_html ) {
		return '';
	}

	if ( false !== strpos( $form_html, 'wpcf7cpcnf' ) ) {
		$form_html = my_contact_format_confirm_required_badges( $form_html );
	}

	$form_html = preg_replace(
		'/<span\b[^>]*(?:p-contact-page__required|required|is-required|wpcf7cp-required)[^>]*>\s*必須\s*<\/span>/iu',
		my_contact_required_badge_html(),
		$form_html
	);

	$form_html = preg_replace(
		'/class="([^"]*\bp-contact-page__submit-button\b(?![^"]*\bc-gradient-button\b)[^"]*)"/u',
		'class="$1 c-gradient-button"',
		$form_html
	);

	return $form_html;
}

/**
 * Confirm Plus Contact Form 7 のボタン文言をサイト表記に合わせる
 *
 * @param array $data_arr Confirm Plus Contact Form 7 のフロント表示文言。
 * @return array
 */
function my_contact_confirm_button_labels( $data_arr ) {
	if ( ! is_array( $data_arr ) ) {
		$data_arr = array();
	}

	$data_arr['cfm_btn']           = '入力内容の確認';
	$data_arr['cfm_btn_edit']      = '修正する';
	$data_arr['cfm_btn_mail_send'] = '送信する';
	$data_arr['checked_msg']       = '同意済み';

	return $data_arr;
}
add_filter( 'wpcf7cp_localize_data', 'my_contact_confirm_button_labels' );

/**
 * ひらがな入力欄のバリデーション対象か判定する
 *
 * Contact Form 7 のフォームタグに以下のいずれかを付与すると対象になる。
 *
 * - name: `hiragana` / `furigana` / `your-hiragana` / `your-furigana`
 * - class: `validate-hiragana`
 *
 * @param WPCF7_FormTag $tag フォームタグ。
 * @return bool
 */
function my_is_hiragana_validation_target( $tag ) {
	if ( ! isset( $tag->name ) ) {
		return false;
	}

	$field_name = sanitize_key( (string) $tag->name );

	if ( preg_match( '/^(hiragana|furigana|your[-_]?hiragana|your[-_]?furigana)$/', $field_name ) ) {
		return true;
	}

	if ( empty( $tag->className ) ) {
		return false;
	}

	$classes = preg_split( '/\s+/', (string) $tag->className );

	if ( empty( $classes ) || ! is_array( $classes ) ) {
		return false;
	}

	return in_array( 'validate-hiragana', $classes, true );
}

/**
 * ひらがな入力欄の値を検証する
 *
 * 許可する文字
 * - ひらがな
 * - 長音記号
 * - 全角スペース
 *
 * 不可文字
 * - `ゔ`
 *
 * @param WPCF7_Validation $result バリデーション結果。
 * @param WPCF7_FormTag    $tag    フォームタグ。
 * @return WPCF7_Validation
 */
function my_validate_hiragana_field( $result, $tag ) {
	if ( ! my_is_hiragana_validation_target( $tag ) ) {
		return $result;
	}

	$field_name = isset( $tag->name ) ? (string) $tag->name : '';
	$value      = isset( $_POST[ $field_name ] ) ? wp_unslash( $_POST[ $field_name ] ) : '';
	$value      = trim( (string) $value );

	if ( '' === $value ) {
		return $result;
	}

	/*
	 * ひらがな全般を許可しつつ、`ゔ` だけは除外する。
	 * 全角スペースと長音記号も許可する。
	 */
	if ( ! preg_match( '/\A(?!.*ゔ)(?=.*\p{Hiragana})[\p{Hiragana}ー　]+\z/u', $value ) ) {
		$result->invalidate( $tag, 'ひらがな、長音記号、全角スペースのみで入力してください。' );
	}

	return $result;
}
add_filter( 'wpcf7_validate_text', 'my_validate_hiragana_field', 20, 2 );
add_filter( 'wpcf7_validate_text*', 'my_validate_hiragana_field', 20, 2 );
add_filter( 'wpcf7_validate_textarea', 'my_validate_hiragana_field', 20, 2 );
add_filter( 'wpcf7_validate_textarea*', 'my_validate_hiragana_field', 20, 2 );

/**
 * 実績カテゴリーの表示名を取得する
 *
 * @param int  $post_id   投稿ID。
 * @param bool $show_all  すべてのカテゴリー名を連結するか。
 * @return string
 */
function my_get_works_genre_name( $post_id = 0, $show_all = false ) {
	$post_id    = 0 < (int) $post_id ? (int) $post_id : get_the_ID();
	$genre_name = 'WEBサイト';
	$terms      = get_the_terms( $post_id, 'works_category' );

	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return $genre_name;
	}

	$genre_names = array_filter(
		wp_list_pluck( $terms, 'name' ),
		static function ( $term_name ) {
			return '' !== trim( (string) $term_name );
		}
	);

	if ( empty( $genre_names ) ) {
		return $genre_name;
	}

	if ( $show_all ) {
		return implode( ' / ', $genre_names );
	}

	return (string) reset( $genre_names );
}

/**
 * Breadcrumb NavXTのお知らせ一覧パンくず表示名を変更する
 *
 * @param string $title パンくずの表示名。
 * @param array  $type  パンくず項目の種類。
 * @param int    $id    パンくず項目に紐づくID。
 * @return string
 */
function my_news_breadcrumb_title( $title, $type, $id ) {
	$news_page_id = (int) get_option( 'page_for_posts' );

	if ( 0 === $news_page_id || $news_page_id !== (int) $id ) {
		return $title;
	}

	if ( ! in_array( 'post-root', $type, true ) ) {
		return $title;
	}

	return 'NEWS';
}
add_filter( 'bcn_breadcrumb_title', 'my_news_breadcrumb_title', 10, 3 );

/**
 * Breadcrumb NavXTの実績詳細パンくず表示名を変更する
 *
 * @param string $title パンくずの表示名。
 * @param array  $type  パンくず項目の種類。
 * @param int    $id    パンくず項目に紐づくID。
 * @return string
 */
function my_works_single_breadcrumb_title( $title, $type, $id ) {
	if ( ! is_singular( 'works' ) ) {
		return $title;
	}

	$post_id = get_queried_object_id();

	if ( $post_id !== (int) $id ) {
		return $title;
	}

	if ( ! in_array( 'current-item', $type, true ) && ! in_array( 'post-works', $type, true ) ) {
		return $title;
	}

	return 'WORKS_詳細';
}
add_filter( 'bcn_breadcrumb_title', 'my_works_single_breadcrumb_title', 10, 3 );

/**
 * Breadcrumb NavXTの通常投稿詳細パンくずを固定表示にする
 *
 * @param bcn_breadcrumb_trail $trail パンくずトレイル。
 * @return void
 */
function my_news_single_breadcrumb_trail( $trail ) {
	if ( ! is_singular( 'post' ) || ! ( $trail instanceof bcn_breadcrumb_trail ) || ! class_exists( 'bcn_breadcrumb' ) ) {
		return;
	}

	$post_id      = get_queried_object_id();
	$home_crumb   = null;
	$news_crumb   = null;
	$news_page_id = (int) get_option( 'page_for_posts' );

	foreach ( $trail->breadcrumbs as $breadcrumb ) {
		if ( ! ( $breadcrumb instanceof bcn_breadcrumb ) ) {
			continue;
		}

		$types = $breadcrumb->get_types();

		if ( in_array( 'home', $types, true ) ) {
			$home_crumb = $breadcrumb;
			continue;
		}

		if ( in_array( 'post-root', $types, true ) ) {
			$news_crumb = $breadcrumb;
		}
	}

	if ( ! ( $home_crumb instanceof bcn_breadcrumb ) ) {
		$home_crumb = new bcn_breadcrumb(
			'TOP',
			isset( $trail->opt['Hhome_template'] ) ? $trail->opt['Hhome_template'] : bcn_breadcrumb::get_default_template(),
			array( 'home' ),
			home_url( '/' ),
			null,
			true
		);
	} else {
		$home_crumb->set_title( 'TOP' );
	}

	if ( ! ( $news_crumb instanceof bcn_breadcrumb ) ) {
		$news_crumb = new bcn_breadcrumb(
			'NEWS',
			isset( $trail->opt['Hpost_post_template'] ) ? $trail->opt['Hpost_post_template'] : bcn_breadcrumb::get_default_template(),
			array( 'post-root', 'post', 'post-post' ),
			my_get_news_archive_url(),
			0 < $news_page_id ? $news_page_id : null,
			true
		);
	}

	$current_crumb = new bcn_breadcrumb(
		'NEWS_詳細',
		isset( $trail->opt['Hpost_post_template_no_anchor'] ) ? $trail->opt['Hpost_post_template_no_anchor'] : bcn_breadcrumb::default_template_no_anchor,
		array( 'post', 'post-post', 'current-item' ),
		get_permalink( $post_id ),
		$post_id,
		false
	);

	$trail->breadcrumbs = array(
		$current_crumb,
		$news_crumb,
		$home_crumb,
	);
}
add_action( 'bcn_after_fill', 'my_news_single_breadcrumb_trail', 10, 1 );

/**
 * Breadcrumb NavXTの実績詳細パンくずを固定表示にする
 *
 * @param bcn_breadcrumb_trail $trail パンくずトレイル。
 * @return void
 */
function my_works_single_breadcrumb_trail( $trail ) {
	if ( ! is_singular( 'works' ) || ! ( $trail instanceof bcn_breadcrumb_trail ) || ! class_exists( 'bcn_breadcrumb' ) ) {
		return;
	}

	$post_id    = get_queried_object_id();
	$home_crumb = null;

	foreach ( $trail->breadcrumbs as $breadcrumb ) {
		if ( ! ( $breadcrumb instanceof bcn_breadcrumb ) ) {
			continue;
		}

		$types = $breadcrumb->get_types();

		if ( in_array( 'home', $types, true ) ) {
			$home_crumb = $breadcrumb;
			break;
		}
	}

	if ( ! ( $home_crumb instanceof bcn_breadcrumb ) ) {
		$home_crumb = new bcn_breadcrumb(
			'TOP',
			isset( $trail->opt['Hhome_template'] ) ? $trail->opt['Hhome_template'] : bcn_breadcrumb::get_default_template(),
			array( 'home' ),
			home_url( '/' ),
			null,
			true
		);
	} else {
		$home_crumb->set_title( 'TOP' );
	}

	$works_crumb = new bcn_breadcrumb(
		'WORKS',
		isset( $trail->opt['Hpost_works_archive_template'] ) ? $trail->opt['Hpost_works_archive_template'] : bcn_breadcrumb::get_default_template(),
		array( 'post-root', 'post', 'post-works' ),
		my_get_works_archive_url(),
		null,
		true
	);

	$current_crumb = new bcn_breadcrumb(
		'WORKS_詳細',
		bcn_breadcrumb::default_template_no_anchor,
		array( 'post', 'post-works', 'current-item' ),
		get_permalink( $post_id ),
		$post_id,
		false
	);

	$trail->breadcrumbs = array(
		$current_crumb,
		$works_crumb,
		$home_crumb,
	);
}
add_action( 'bcn_after_fill', 'my_works_single_breadcrumb_trail', 10, 1 );

/**
 * Thanksページのパンくずを固定表示にする
 *
 * @param bcn_breadcrumb_trail $trail パンくずトレイル。
 * @return void
 */
function my_thanks_breadcrumb_trail( $trail ) {
	if ( ! is_page( 'thanks' ) || ! ( $trail instanceof bcn_breadcrumb_trail ) || ! class_exists( 'bcn_breadcrumb' ) ) {
		return;
	}

	$post_id        = get_queried_object_id();
	$home_crumb     = null;
	$contact_crumb  = null;
	$contact_page   = get_page_by_path( 'contact' );
	$contact_page_id = $contact_page instanceof WP_Post ? (int) $contact_page->ID : null;
	$current_title  = get_the_title( $post_id );

	foreach ( $trail->breadcrumbs as $breadcrumb ) {
		if ( ! ( $breadcrumb instanceof bcn_breadcrumb ) ) {
			continue;
		}

		$types = $breadcrumb->get_types();

		if ( in_array( 'home', $types, true ) ) {
			$home_crumb = $breadcrumb;
			continue;
		}
	}

	if ( ! ( $home_crumb instanceof bcn_breadcrumb ) ) {
		$home_crumb = new bcn_breadcrumb(
			'TOP',
			isset( $trail->opt['Hhome_template'] ) ? $trail->opt['Hhome_template'] : bcn_breadcrumb::get_default_template(),
			array( 'home' ),
			home_url( '/' ),
			null,
			true
		);
	} else {
		$home_crumb->set_title( 'TOP' );
	}

	$contact_crumb = new bcn_breadcrumb(
		'CONTACT',
		isset( $trail->opt['Hpost_page_template'] ) ? $trail->opt['Hpost_page_template'] : bcn_breadcrumb::get_default_template(),
		array( 'page' ),
		my_get_page_url( 'contact' ),
		$contact_page_id,
		true
	);

	$current_crumb = new bcn_breadcrumb(
		'' !== $current_title ? $current_title : '送信完了',
		isset( $trail->opt['Hpost_page_template_no_anchor'] ) ? $trail->opt['Hpost_page_template_no_anchor'] : bcn_breadcrumb::default_template_no_anchor,
		array( 'page', 'current-item' ),
		get_permalink( $post_id ),
		$post_id,
		false
	);

	$trail->breadcrumbs = array(
		$current_crumb,
		$contact_crumb,
		$home_crumb,
	);
}
add_action( 'bcn_after_fill', 'my_thanks_breadcrumb_trail', 10, 1 );

/**
 * CSSとJavaScriptの読み込み
 *
 */
function my_script_init(){
	$is_debug = defined( 'WP_DEBUG' ) && WP_DEBUG;
	$css_file = get_template_directory() . ( $is_debug ? '/assets/css/styles.css' : '/assets/css/styles.min.css' );
	$js_file  = get_template_directory() . ( $is_debug ? '/assets/js/script.js' : '/assets/js/script.min.js' );
	$css_version = file_exists($css_file) ? filemtime($css_file) : '1.0.0';
	$js_version  = file_exists($js_file)  ? filemtime($js_file)  : '1.0.0';
	$css_rel = str_replace(get_template_directory(), '', $css_file);
	$js_rel  = str_replace(get_template_directory(), '', $js_file);


	if ( is_front_page() || is_singular( 'works' ) ) {
		// Swiper CSS 8.3.2
		wp_enqueue_style('swiper-8.3.2', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css', array(), '8.3.2', 'all');
	}

	// Google Fonts
	wp_enqueue_style('GoogleFonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&family=Open+Sans+Condensed:wght@700&family=Roboto:wght@400;500;700;900&display=swap', array(), null);

	// カスタムCSS
	wp_enqueue_style('custom-style', get_template_directory_uri() . $css_rel, array(), $css_version, 'all');

	$js_dependencies = array();

	if ( is_front_page() || is_singular( 'works' ) ) {
		// Swiper JS 8.3.2
		wp_enqueue_script('swiper-8.3.2', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', array(), '8.3.2', true);
		$js_dependencies[] = 'swiper-8.3.2';
	}

	// カスタムJS
	wp_enqueue_script('custom', get_template_directory_uri() . $js_rel, $js_dependencies, $js_version, true);
}
add_action('wp_enqueue_scripts', 'my_script_init');

/**
 * 管理画面用CSS・JavaScriptの読み込み
 *
 * @return void
 */
function my_admin_style_init() {
	$admin_css_file = get_template_directory() . '/assets/css/admin.css';
	$admin_js_file  = get_template_directory() . '/assets/js/admin.js';

	if ( file_exists( $admin_css_file ) ) {
		wp_enqueue_style(
			'enflownext-admin-style',
			get_template_directory_uri() . '/assets/css/admin.css',
			array(),
			filemtime( $admin_css_file ),
			'all'
		);
	}

	if ( file_exists( $admin_js_file ) ) {
		wp_enqueue_script(
			'enflownext-admin-script',
			get_template_directory_uri() . '/assets/js/admin.js',
			array(),
			filemtime( $admin_js_file ),
			true
		);
	}
}
add_action( 'admin_enqueue_scripts', 'my_admin_style_init' );

/**
 * お知らせ一覧の表示件数を調整する
 *
 * @param WP_Query $query メインクエリ。
 * @return void
 */
function my_news_archive_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! ( $query->is_home() || $query->is_category() || $query->is_date() ) ) {
		return;
	}

	$query->set( 'posts_per_page', 10 );
	$query->set( 'orderby', 'date' );
	$query->set( 'order', 'DESC' );
	$query->set( 'ignore_sticky_posts', true );
}
add_action( 'pre_get_posts', 'my_news_archive_query' );

/**
 * 実績アーカイブの表示件数を調整する
 *
 * @param WP_Query $query メインクエリ。
 * @return void
 */
function my_works_archive_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'works' ) ) {
		return;
	}

	$query->set( 'posts_per_page', 3 );
	$query->set( 'orderby', 'date' );
	$query->set( 'order', 'DESC' );
}
add_action( 'pre_get_posts', 'my_works_archive_query' );

/**
 * 実績一覧に実績カテゴリー列を追加する
 *
 * @param array $columns 投稿一覧の列。
 * @return array
 */
function my_works_admin_columns( $columns ) {
	$new_columns = array();

	foreach ( $columns as $key => $label ) {
		$new_columns[ $key ] = $label;

		if ( 'title' === $key ) {
			$new_columns['works_category'] = '実績カテゴリー';
		}
	}

	return $new_columns;
}
add_filter( 'manage_works_posts_columns', 'my_works_admin_columns' );

/**
 * 実績一覧の実績カテゴリー列を表示する
 *
 * @param string $column  列名。
 * @param int    $post_id 投稿ID。
 * @return void
 */
function my_works_admin_column_content( $column, $post_id ) {
	if ( 'works_category' !== $column ) {
		return;
	}

	$terms = get_the_terms( $post_id, 'works_category' );

	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		echo '—';
		return;
	}

	$term_names = wp_list_pluck( $terms, 'name' );
	echo esc_html( implode( ', ', $term_names ) );
}
add_action( 'manage_works_posts_custom_column', 'my_works_admin_column_content', 10, 2 );

/**
 * 必須プラグインの有効化状態を管理画面で通知する
 *
 * @return void
 */
function my_required_plugins_admin_notice() {
	if ( ! current_user_can( 'activate_plugins' ) || class_exists( 'SCF' ) ) {
		return;
	}

	$plugin_file = WP_PLUGIN_DIR . '/smart-custom-fields/smart-custom-fields.php';

	if ( ! file_exists( $plugin_file ) ) {
		return;
	}
	?>
	<div class="notice notice-error">
		<p><?php echo esc_html__( 'FAQなどのカスタムフィールド表示には Smart Custom Fields の有効化が必要です。プラグイン一覧から Smart Custom Fields を有効化してください。', 'enflownext' ); ?></p>
	</div>
	<?php
}
add_action( 'admin_notices', 'my_required_plugins_admin_notice' );
