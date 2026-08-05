<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script>document.documentElement.classList.add('is-js');</script>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <?php
    $home_url = home_url( '/' );
    $news_archive_url = function_exists( 'my_get_news_archive_url' ) ? my_get_news_archive_url() : home_url( '/news/' );
    $profile_url = function_exists( 'my_get_page_url' ) ? my_get_page_url( 'profile' ) : home_url( '/profile/' );
    $faq_url = function_exists( 'my_get_page_url' ) ? my_get_page_url( 'faq' ) : home_url( '/faq/' );
    $contact_url = function_exists( 'my_get_page_url' ) ? my_get_page_url( 'contact' ) : home_url( '/contact/' );
    $nav_items = array(
      array(
        'label' => 'WORKS',
        'sub' => '実績',
        'url' => home_url( '/works/' ),
      ),
      array(
        'label' => 'PRICE',
        'sub' => '料金',
        'url' => home_url( '/price/' ),
      ),
      array(
        'label' => 'PROFILE',
        'sub' => '経歴・職歴',
        'url' => $profile_url,
      ),
      array(
        'label' => 'NEWS',
        'sub' => 'お知らせ',
        'url' => $news_archive_url,
      ),
      array(
        'label' => 'FAQ',
        'sub' => 'よくあるご質問',
        'url' => $faq_url,
      ),
    );
  ?>
  <header class="p-header l-header js-header">
    <div class="p-header__inner">
      <a class="p-header__logo" href="<?php echo esc_url( $home_url ); ?>" aria-label="CODO ASSIST トップページへ">
        CODO ASSIST
      </a>
      <nav class="p-header__nav" aria-label="グローバルナビゲーション">
        <ul class="p-header__nav-list">
          <?php foreach ( $nav_items as $item ) : ?>
            <li class="p-header__nav-item">
              <a class="p-header__nav-link" href="<?php echo esc_url( $item['url'] ); ?>">
                <span class="p-header__nav-main"><?php echo esc_html( $item['label'] ); ?></span>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </nav>
      <a class="p-header__contact" href="<?php echo esc_url( $contact_url ); ?>">
        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/icons/icon-mail.svg' ); ?>" alt="" width="24" height="18" decoding="async">
        <span>CONTACT</span>
      </a>
      <button class="p-header__menu-button js-menu-button" type="button" aria-label="メニューを開く" aria-controls="js-drawer" aria-expanded="false">
        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/icons/icon-hamburger.svg' ); ?>" alt="" width="22" height="17" decoding="async">
      </button>
    </div>
    <div class="p-header__drawer js-drawer" id="js-drawer" aria-hidden="true">
      <nav class="p-header__drawer-nav" aria-label="スマートフォンナビゲーション">
        <ul class="p-header__drawer-list">
          <?php foreach ( $nav_items as $item ) : ?>
            <li class="p-header__drawer-item">
              <a class="p-header__drawer-link js-drawer-link" href="<?php echo esc_url( $item['url'] ); ?>">
                <span class="p-header__drawer-main"><?php echo esc_html( $item['label'] ); ?></span>
                <span class="p-header__drawer-sub"><?php echo esc_html( $item['sub'] ); ?></span>
              </a>
            </li>
          <?php endforeach; ?>
          <li class="p-header__drawer-item">
            <a class="p-header__drawer-link js-drawer-link" href="<?php echo esc_url( $contact_url ); ?>">
              <span class="p-header__drawer-main">CONTACT</span>
              <span class="p-header__drawer-sub">お問い合わせ</span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </header>
