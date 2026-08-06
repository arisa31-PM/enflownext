# WordPressオリジナルテーマ制作

## 役割

このプロンプトは、デザインカンプをもとに最初からWordPressオリジナルテーマを制作する場合に使用する。

共通コーディングルール（00-common.md）を前提として実装すること。

静的HTMLを後からWordPress化するのではなく、WordPressテーマとして設計・構築することを前提とする。

---

# 基本方針

・WordPress標準機能を優先して実装する
・保守性・再利用性・更新性を重視する
・管理画面から更新しやすい構成にする
・デザインとコンテンツを分離する
・不要な独自実装は行わない
・共通部分はテンプレートパーツ化する

---

# テーマ構成

以下のようなテーマ構成で実装する。

```

theme-name/
│
├── style.css
├── functions.php
├── index.php
├── front-page.php
├── home.php
├── single.php
├── single-post.php
├── archive.php
├── category.php
├── search.php
├── 404.php
├── header.php
├── footer.php
├── screenshot.png
│
├── template-parts/
│
├── assets/
│ ├── css/
│ ├── js/
│ ├── images/
│ └── scss/
│
└── inc/

```

必要に応じて

・archive-{post_type}.php
・single-{post_type}.php
・taxonomy-{taxonomy}.php
・page-{slug}.php

を追加する。

---

# テンプレート設計

・トップページは front-page.php を使用する
・投稿一覧は home.php を使用する
・通常投稿詳細は single-post.php を使用する
・固定ページは page-{slug}.php を使用する
・カスタム投稿一覧は archive-{post_type}.php を使用する
・カスタム投稿詳細は single-{post_type}.php を使用する
・タクソノミー一覧は taxonomy-{taxonomy}.php を使用する
・index.php はフォールバックとして用意する

WordPressテンプレート階層を遵守すること。

---

# header.php

必ず以下を実装する。

・wp_head()

・wp_body_open()

・body_class()

・language_attributes()

・charset

・viewport

・title-tag

---

# footer.php

必ず以下を実装する。

・wp_footer()

---

# functions.php

・CSSは wp_enqueue_style() を使用する
・JavaScriptは wp_enqueue_script() を使用する
・filemtime()でキャッシュ対策を行う
・title-tagを有効化する
・アイキャッチ画像を有効化する
・メニュー登録を行う
・HTMLへ直接scriptやlinkを書かない

## CSS / JavaScript 読み込みルール

- CSS / JavaScript は `functions.php` の `wp_enqueue_style()` / `wp_enqueue_script()` で読み込む。
- HTMLへ直接 `link` や `script` を書かない。
- 開発中は `WP_DEBUG` が `true` の前提で、非圧縮ファイルを読み込む。
  - CSS：`assets/css/styles.css`
  - JavaScript：`assets/js/script.js`
- テスト環境・本番環境では `WP_DEBUG` が `false` の前提で、圧縮ファイルを読み込む。
  - CSS：`assets/css/styles.min.css`
  - JavaScript：`assets/js/script.min.js`
- `filemtime()` を使用してキャッシュ対策を行う。
- `styles.css` / `styles.min.css` / `script.js` / `script.min.js` は削除・リネームしない。
- `WP_DEBUG` を `false` にする前に、必ず `npm run build` で圧縮ファイルを最新化する。

---

# パス

・画像は get_template_directory_uri() を使用する
・トップページリンクは home_url('/') を使用する
・固定ページは home_url('/slug/') を使用する
・URLを直接記述しない

---

# WordPressループ

・一覧はメインループを利用する
・トップページなどの取得はWP_Queryを使用する
・サブループ後は wp_reset_postdata() を記述する
・投稿0件の場合の表示を用意する
・ページネーションは paginate_links() を使用する

---

# 固定ページ

更新頻度の低いページは固定ページで管理する。

例

・会社概要

・サービス

・採用情報

・お問い合わせ

・プライバシーポリシー

・Thanksページ

---

# 通常投稿

更新頻度の高いページは通常投稿で管理する。

例

・お知らせ

・ブログ

一覧

・home.php

詳細

・single-post.php

---

# カスタム投稿

通常投稿と分けるべきコンテンツはカスタム投稿で管理する。

例

・施工事例

・商品

・インタビュー

一覧

・archive-{post_type}.php

詳細

・single-{post_type}.php

分類

・taxonomy-{taxonomy}.php

---

# カスタムフィールド

案件で採用するカスタムフィールドプラグイン
（Advanced Custom Fields または Smart Custom Fields）
を使用する。

採用プラグインは
CLIENT_REQUIREMENTS.md
を参照する。

---

# エスケープ

・URLは esc_url()

・テキストは esc_html()

・属性値は esc_attr()

・本文は the_content()

・HTMLを許可する場合は wp_kses_post()

---

# 出力ルール

・作成するファイル名を最初に明記する
・ファイル単位でコードを出力する
・省略せずコピペできる完成形を出力する
・コードの前に長い説明を書かない
・必要な説明はコード出力後に簡潔にまとめる
・WordPress管理画面で必要な設定があれば最後に説明する

---

### アセット運用ルール

### 開発環境

開発中は必ず `WP_DEBUG` を `true` にする。

```php
define( 'WP_DEBUG', true );
```

この状態では以下のファイルを読み込む。

- CSS：`assets/css/styles.css`
- JavaScript：`assets/js/script.js`

デザイン確認・実装・レビューは、必ず非圧縮ファイルを基準に行う。

---

### テスト環境・本番環境

開発完了後、テスト環境へアップロードする前、または本番環境へデプロイする前は、必ず最新の圧縮ファイルを生成する。

実行コマンド

```bash
npm run build
```

`styles.min.css` と `script.min.js` が最新化されたことを確認した後、

```php
define( 'WP_DEBUG', false );
```

へ変更する。

この状態では以下のファイルを読み込む。

- CSS：`assets/css/styles.min.css`
- JavaScript：`assets/js/script.min.js`

---

## template-parts 運用ルール

複数ページで共通して使用するパーツは、`template-parts/` 配下へ切り出す。

### ディレクトリ構成

```text
template-parts/
├── common/
├── card/
├── form/
└── ...
```

### 共通化の基準

以下の条件に当てはまるパーツは、`template-parts/` へ切り出す。

- 2ページ以上で使用するパーツ
- 複数ページで使用することが設計上明らかなパーツ

例

- ページFV
- パンくずリスト
- ページリンクバナー
- ページネーション
- カード
- フォーム部品

ページ固有のレイアウトや、一度しか使用しないパーツは共通化しない。

### 共通化する代表的なパーツ

- page-fv
- breadcrumb
- page-link-banners
- pagination
- works-card
- news-card
- contact-form

案件によって追加・変更してもよい。

### 呼び出し方法

WordPress標準の `get_template_part()` を使用する。

#### 引数が不要な場合

```php
<?php get_template_part( 'template-parts/common/page-fv' ); ?>
```

#### 引数が必要な場合

```php
<?php
get_template_part(
    'template-parts/common/page-fv',
    null,
    $args
);
?>
```

### パンくずリスト

パンくずリストは、独自実装ではなく **Breadcrumb NavXT** プラグインを使用する。

#### 実装ルール

- 独自のパンくず生成関数は作成しない。
- `functions.php` にパンくず生成処理を追加しない。
- パンくず表示用の共通パーツは `template-parts/common/breadcrumb.php` に配置する。
- 各テンプレートでは `get_template_part( 'template-parts/common/breadcrumb' );` で呼び出す。
- `Breadcrumb NavXT` が有効な場合のみ表示する。
- PHPエラー防止のため、`function_exists( 'bcn_display' )` を使用する。
- template-partsはHTML・PHPの共通部品として管理し、UIの共通化はComponent（cクラス）で管理する。両者の役割を混同しないこと。

### CodeXへの指示

- 共通化できるパーツを見つけても、勝手に `template-parts` へ切り出さない。
- 共通化する前に、対象パーツ・影響範囲・切り出し方針を報告する。
- ユーザーの承認後に `template-parts` へ切り出す。
- 共通パーツの修正時は、影響を受けるテンプレートを報告する。
- WordPress標準機能や導入済みプラグインで実現できるものは、独自実装しない。