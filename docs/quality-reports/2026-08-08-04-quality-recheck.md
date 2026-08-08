# 品質チェックレポート

## プロジェクト情報

| 項目 | 内容 |
| --- | --- |
| 実施日 | 2026-08-08 |
| プロジェクト | ポートフォリオ課題 |
| 実行モード | 再チェック（調査のみ） |
| 比較対象 | 2026-08-08-03-report-quality-improvement.md |
| チェック対象コミット（任意） | Git操作禁止のため未確認 |
| 判定 | 修正完了後に再チェック |

---

## サイト情報

| 項目 | 内容 |
| --- | --- |
| テーマ名 | enflownext |
| Local URL | http://enflownext.local/ |
| 本番URL | https://enflownext.com/ |
| GitHub Repository | https://github.com/arisa31-PM/enflownext |
| 担当 | Codex |

---

## 実施内容

- `docs/prompts/15-quality-check.md` に従った再チェック
- `13-static-checklist.md`、`12-wordpress-checklist.md`、`14-production-checklist.md` の順で確認
- 最新レポート1件のみとの比較
- 現在のコード、Local DB、本番HTML、本番HTTP、生成CSS/JSの再調査
- CSS / レスポンシブ、CSSビルド、削除画像参照、FVフォールバック、WordPress generator、XMLサイトマップ、タイムゾーン、Contact Form 7 を重点確認

---

## チェック結果サマリー

| 集計項目 | 件数 |
| --- | ---: |
| 総チェック項目数 | 39 |
| OK件数 | 19 |
| 要確認件数 | 7 |
| 修正必要件数 | 9 |
| 確認不可件数 | 4 |

---

## 優先度別結果

### A：公開・動作へ影響する重大問題

- Contact Form 7 の送信元メールが Local DB で `wordpress@codoassistportfolio.local` のまま。
- Contact Form 7 の `_config_validation` に `unsafe_email_without_protection` が残っている。

### B：品質・UXへ影響する問題

- `src/sass/object/project/_p-profile.scss` に 768px以外の幅指定メディアクエリが残っている。
- 指定重点SCSSに `calc()`、`vw`、`overflow: hidden`、固定的な `height` 指定が残っている。
- SCSS全体でも 375px、600px、1350px、767px、hover、reduced-motion など、768px以外のメディアクエリが残っている。
- テーマ内に本番不要ファイル・ディレクトリが残っている。`.DS_Store`、`node_modules`、`src`、`gulp`、`package.json`、`package-lock.json`。
- Localで開発・移行補助系プラグインが有効。`admin-bar-position`、`all-in-one-wp-migration`、`duplicate-post`、`show-current-template`、`stops-core-theme-and-plugin-updates`。
- Localにゴミ箱投稿が残っている。`page` 2件、`post` 45件、`works` 1件。

### C：軽微な改善

- PHPテンプレートに削除済みFV画像ファイル名の静的引数が残っている。ただし現在の本番HTMLではアップロード画像または `no-image` により画像切れは発生していない。
- `src/sass/foundation/_reset.scss` に reduced-motion 用の `!important` がある。アクセシビリティ上の意図は妥当だが、ルール上は例外扱いの明文化が必要。
- `src/sass/foundation/_base.scss` のルートフォント制御で `vw` が使われている。

### ユーザー確認

- Contact Form 7 の管理者宛メール受信、自動返信メール受信、迷惑メール確認、文字化け確認。
- 本番公開時に noindex / nofollow を解除するタイミング。
- 本番サーバー上の不要ファイル有無。
- Google Analytics / Search Console の接続状態。

### 本番環境確認

- `https://enflownext.com/` は HTTP 200。
- `https://enflownext.com/wp-sitemap.xml` は HTTP 200。
- 子サイトマップ6件は HTTP 200。
- `styles.min.css` は HTTP 200、Localの `assets/css/styles.min.css` とハッシュ一致。
- 本番HTMLは `styles.min.css?ver=1786162491` を読み込み。filemtime由来のバージョンとして機能している。
- `script.min.js` は HTTP 200、Localの `assets/js/script.min.js` とハッシュ一致。
- 本番HTMLから `meta name="generator"` は消えている。
- 本番 `/works/` には `meta name="robots" content="noindex"` が出力されている。

### 確認不可

- 実ブラウザでの 320 / 375 / 767 / 768 / 1440 / 1920 / 2650 表示確認。
- 実ブラウザでの Console / Network 確認。
- Chrome / Edge / Safari / iOS / Android 実機確認。
- PHP構文チェック。`php` コマンドが利用不可。

### 今回案件では対応対象外

- プライバシーポリシーページおよびフッターのプライバシーポリシーリンク。スクール課題の対象外のため、今回の修正必要には含めない。

---

## 詳細結果

| 項目 | 結果 | 確認方法 | 対象ページ | 対象ファイル | 問題内容 | 推奨対応 | 優先度 | 備考 |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| 最新レポート確認 | OK | `find docs/quality-reports`、最新1件のみ読込 | 全体 | `2026-08-08-03-report-quality-improvement.md` | 比較対象は最新1件のみ | 次回は本レポートのみ比較対象にする | - | それ以前は履歴扱い |
| 本番トップ表示 | OK | `curl`、Web取得 | `/` | - | HTTP 200 | - | - | Webツールでも内容取得 |
| 本番主要ページ | OK | `curl` | `/works/` `/price/` `/profile/` `/news/` `/faq/` `/contact/` `/contact/thanks/` | - | 主要ページはHTTP 200 | - | - | 404テストURLはHTTP 404 |
| WordPress generator meta | OK | 本番HTML検索 | `/` `/works/` `/contact/` ほか | `functions.php:29` | `meta name="generator"` は0件 | - | - | `generator` 文字列はGlotPress翻訳JSONにあるが、WP generator metaではない |
| XMLサイトマップ | OK | `curl` | `/wp-sitemap.xml` | - | 親サイトマップHTTP 200 | - | - | 子サイトマップURLを取得 |
| 子サイトマップ | OK | `curl` | posts/page/works/taxonomy/users | - | 6件すべてHTTP 200 | - | - | `post`、`page`、`works`、`category`、`works_category`、`users` |
| noindex / nofollow | 要確認 | 本番HTML、Local DB | `/works/`、Local | DB `blog_public` | 本番 `/works/` に `noindex`、Local `blog_public=0` | スクール提出前・公開前は現状許容。公開時に解除確認 | C | `/` は `max-image-preview:large` のみ |
| CSSビルド | OK | `stat`、本番CSS取得、SHA-256比較 | 全体 | `assets/css/styles.min.css` | Localと本番のCSSハッシュ一致 | - | - | CSS本体は最新反映済み |
| 本番CSS HTTP | OK | `curl` | 全体 | `styles.min.css?ver=1786162491` | HTTP 200 / text/css | - | - | 117020 bytes |
| filemtime | OK | 本番HTML、`date -r`、ハッシュ比較 | 全体 | `functions.php:1255` | 本番HTMLが `styles.min.css` をバージョン付きで読み込み | - | - | 本番CSSの `ver` は2026-08-08 13:14:51相当 |
| JS配信 | OK | `curl`、SHA-256比較 | 全体 | `assets/js/script.min.js` | HTTP 200、Localと本番のJSハッシュ一致 | - | - | 12238 bytes |
| Local画面接続 | 確認不可 | `curl -I http://enflownext.local/` | Local | - | Codex環境から接続不可 | ユーザー環境または接続可能なブラウザで確認 | 確認不可 | DBは別途確認済み |
| Local DB特定 | OK | MySQLソケット2件を照合 | Local | DB | `AhILvb5_t` が `siteurl=http://enflownext.local`、テーマ `enflownext` | - | - | `dFkF0ApRe` は別サイトのため現在判定に使わない |
| タイムゾーン | OK | Local DB | Local | `wp_options` | `timezone_string=Asia/Tokyo` | - | - | 前回問題は解消 |
| Contact Form 7 送信元 | 修正必要 | Local DB | Contact Form 7 ID 175 | `_mail` `_mail_2` | `[_site_title] <wordpress@codoassistportfolio.local>` | 本番ドメインの送信元へ変更 | A | ユーザー側設定済みとのことだが、現在Local DBでは未解消 |
| Contact Form 7 Reply-To | OK | Local DB | Contact Form 7 ID 175 | `_mail` `_mail_2` | 管理者宛 `Reply-To: [your-email]`、自動返信 `Reply-To: [_site_admin_email]` | - | - | 設計として妥当 |
| Contact Form 7 自動返信 | OK | Local DB | Contact Form 7 ID 175 | `_mail_2` | `active=true`、宛先 `[your-email]` | 実送信はユーザー確認 | - | メール送信は禁止のため未実施 |
| unsafe_email_without_protection | 修正必要 | Local DB | Contact Form 7 ID 175 | `_config_validation` | `mail_2.recipient` に警告残存 | CF7推奨に沿って保護または設定調整 | A | 実送信は未実施 |
| ふりがなバリデーション | OK | コード確認 | `/contact/` | `functions.php:879` | `your-kana` をひらがな対象として検証 | - | - | `wpcf7_validate_text*` にフックあり |
| FVフォールバック | OK | コード、本番HTML、画像HTTP | 下層FV | `template-parts/common/page-fv.php` | 静的画像が存在しない場合 `no-image.webp/png` へフォールバック | - | - | 本番ではアップロードFV画像がHTTP 200 |
| 削除FV画像参照 | 要確認 | `rg`、HTTP | PHP / 本番 | `archive-works.php` ほか | `contact-fv-pc.webp` 等の静的引数が残存。該当テーマ画像URLは本番404 | 不要なら引数を削除または存在画像名へ整理 | C | 現在HTMLには該当テーマ画像URLは出力されない |
| no-image | OK | ファイル確認、HTTP | 全体 | `assets/images/no-image.webp/png` | Local存在、本番 `no-image.webp` HTTP 200 | - | - | アイキャッチ未設定時の出力も確認 |
| 指定SCSSのメディアクエリ | 修正必要 | `rg` | 全体 | `_p-profile.scss:21` | 768px以外の幅指定メディアクエリあり | 768pxのみの設計へ整理 | B | `min-width: 1350px` 相当 |
| SCSS全体のメディアクエリ | 修正必要 | `rg` | 全体 | `src/sass` | 375px、600px、767px、1350px、hover、reduced-motion等が残存 | 案件ルールとして許容する例外を明文化、不要な幅指定を削除 | B | hover/reduced-motionは幅ブレークポイントではないが、ルール上確認対象 |
| calc / vw | 修正必要 | `rg` | 全体 | `_p-faq.scss` `_p-profile.scss` `_base.scss` ほか | `calc()`、`100vw`、`vw()` が残存 | 代替可能な箇所をrem/padding/gridで整理 | B | 原則禁止ルール対象 |
| 固定height / overflow hidden | 修正必要 | `rg` | 全体 | `_p-works.scss` `_p-profile.scss` `_p-faq.scss` `_p-news.scss` ほか | 画像比率、アイコン、テキスト省略、アニメーション等で複数使用 | 必要箇所と不要箇所を分類し、不要なものだけ削除 | B | すべてが即不具合とは限らない |
| `!important` | 要確認 | `rg` | 全体 | `_reset.scss`、本番HTML(EWWW) | reduced-motionとEWWW出力に `!important` あり | テーマ側の例外方針を整理 | C | EWWW出力はテーマ修正対象外 |
| 不要SCSS / CSS | 要確認 | ファイル構成、`rg` | 全体 | `src`、`assets/css` | ソースと生成物がテーマ内に同梱 | 納品対象を整理 | B | Local開発環境には必要、本番納品物としては除外候補 |
| PHP構文チェック | 確認不可 | `php -l` | テーマ | PHP全体 | `php` コマンドなし | PHP CLIまたはWP_DEBUGログで確認 | 確認不可 | コード実行確認は未実施 |
| header基本実装 | OK | コード確認 | 全体 | `header.php` | `language_attributes`、`charset`、`viewport`、`wp_head`、`body_class`、`wp_body_open` あり | - | - | `title-tag` は `functions.php` |
| footer基本実装 | OK | コード確認 | 全体 | `footer.php` | `wp_footer()` あり | - | - | - |
| CSS/JS enqueue | OK | コード確認 | 全体 | `functions.php:1255` | `wp_enqueue_style` / `wp_enqueue_script`、`filemtime()` 使用 | - | - | 本番はminファイル読込 |
| h1構造 | OK | コード、本番HTML | 主要ページ | `page-fv.php` ほか | 下層は `page-fv.php` のh1、トップ/詳細もh1あり | - | - | 実ブラウザでのDOM完全検証は未実施 |
| パンくず | OK | コード確認 | 下層 | `template-parts/common/breadcrumb.php` | `nav aria-label="パンくずリスト"` 使用 | - | - | Breadcrumb NavXT前提 |
| 現在地表示 | 修正必要 | コード検索 | ヘッダー | `header.php` | ヘッダーメニューに現在地クラスや `aria-current` が見当たらない | 条件分岐で現在地表示を追加 | B | WordPress品質チェック対象 |
| Smart Custom Fields | OK | Local DB、コード確認 | FAQ/FV/works | `page-faq.php` `functions.php` | SCF有効、FAQはSCF/メタから取得し空なら非表示 | - | - | SCF管理画面の入力例/説明文は未確認 |
| プラグイン | 修正必要 | Local DB | Local | `active_plugins` | 開発・移行補助系プラグインが有効 | 納品前に不要プラグインを停止/削除 | B | ACFは現在のenflownext DBでは有効ではない |
| 管理者ユーザー名 | OK | Local DB | Local | `wp_users` | `admin` ではなく `demo` | - | - | メールはLocal開発用 |
| 投稿データ整理 | 修正必要 | Local DB | Local | `wp_posts` | ゴミ箱投稿が複数残存 | 納品前に不要データ整理 | B | 調査のみのため未変更 |
| テーマscreenshot | OK | `ls -l` | テーマ | `screenshot.png` | ファイル存在 | - | - | 内容の目視確認は未実施 |
| 本番不要ファイル | 修正必要 | `find` | テーマ | `.DS_Store` `src` `gulp` `node_modules` ほか | 納品対象として不要なファイルが残存 | 本番アップロード対象から除外 | B | Local開発環境には必要なものも含む |
| 実ブラウザレスポンシブ | 確認不可 | Browser plugin | 320-2650 | - | 利用可能ブラウザ0件 | ブラウザ接続後に確認 | 確認不可 | 推測でOKにしない |
| Console / Network | 確認不可 | Browser plugin | 全体 | - | 利用可能ブラウザ0件 | ブラウザ接続後に確認 | 確認不可 | HTTP確認とは分離 |

---

## 修正履歴

| 修正日 | 修正内容 | 担当 | 再チェック結果 |
| --- | --- | --- | --- |
| 2026-08-08 | 調査のみ。コード修正、ファイル削除、画像変更、DB更新、WordPress設定変更、プラグイン変更、ビルド、Git操作、本番メール送信は未実施。 | Codex | 新規レポートを作成 |

---

## 最終判定

修正完了後に再チェック。

本番の WordPress generator meta、XMLサイトマップ、タイムゾーン、CSS本番反映は改善を確認した。一方で、Contact Form 7 の送信元メールと `unsafe_email_without_protection`、CSS/SCSSルール違反候補、現在地表示、本番不要ファイル、不要プラグイン/ゴミ箱投稿が残るため、現時点では「納品・提出可能」とは判断しない。

---

## 備考

- プライバシーポリシーは今回案件限定ルールにより修正必要に含めない。
- Local画面はCodex環境からHTTP接続不可だったため、画面表示・Console・Network・レスポンシブの確定判定は行っていない。
- Local DBは `AhILvb5_t` のMySQLソケットを現在の `enflownext.local` として確認した。別ソケット `dFkF0ApRe` は `assist-company.local` であり、本チェックの現在判定には使用しない。
- 本番HTMLにはEWWW Image Optimizer由来の lazyload 変換が入っている。FVは `skip-lazy`、`loading="eager"`、`fetchpriority="high"` を確認した。

---

## 前回レポートとの比較

### 解消した問題

- 本番HTMLの `meta name="generator"` は解消。トップ、主要下層、404で0件。
- Localタイムゾーンは `Asia/Tokyo` に変更済み。
- `styles.min.css` は本番HTTP 200、Localと本番のハッシュ一致。CSSビルド反映を確認。
- 本番HTMLは最新の `styles.min.css` を読み込み、filemtime由来のバージョンが付いている。
- XMLサイトマップは親・子ともHTTP 200。
- FVフォールバックは `no-image.webp/png` へ安全に落ちる実装を確認。本番下層FVもアップロード画像でHTTP 200。

### 継続している問題

- Contact Form 7 の送信元メールが `wordpress@codoassistportfolio.local`。
- Contact Form 7 の `unsafe_email_without_protection` が残存。
- テーマ内に本番不要ファイル・ディレクトリが残存。
- 削除済みFV画像名がPHPの静的引数として残存。ただし現在の本番HTMLには直接出力されない。
- Browser/実機でのレスポンシブ、Console、Network確認は未実施。

### 新しく発見した問題

- 指定重点SCSSに `calc()`、`vw`、`overflow: hidden`、固定的な `height` 指定が複数残存。
- `_p-profile.scss` に 768px以外の幅指定メディアクエリが残存。
- SCSS全体に 768px以外の幅指定メディアクエリが複数残存。
- ヘッダーナビに現在地表示用のクラスまたは `aria-current` が見当たらない。
- Localのenflownext DBで開発・移行補助系プラグインが有効。
- Localにゴミ箱投稿が残存。

### 確認不可

- 実ブラウザでの 320 / 375 / 767 / 768 / 1440 / 1920 / 2650 表示確認。
- 実ブラウザのConsole / Network。
- Chrome / Edge / Safari / iOS / Android。
- PHP CLIによる構文チェック。
- 本番メール送受信。

---

## 次回の品質チェックで重点的に確認する項目

- Contact Form 7 の送信元・自動返信・`unsafe_email_without_protection`
- 指定重点SCSSのルール違反候補
- 768px以外のメディアクエリの例外整理
- 本番不要ファイル・不要プラグイン・ゴミ箱投稿
- 実ブラウザでのレスポンシブ、Console、Network

---

## 参照チェックリスト

チェック項目は以下を参照し、このファイルには重複して記載しない。

- `13-static-checklist.md`
- `12-wordpress-checklist.md`
- `14-production-checklist.md`

---

## 次回アクション

### CodeX対応

- 指定重点SCSSの `calc()`、`vw`、`overflow: hidden`、固定的な `height`、768px以外のメディアクエリを分類し、不要なものを修正する。
- ヘッダーナビの現在地表示を実装する。
- 削除済みFV画像名の静的引数を整理する。
- 本番不要ファイルの除外方針を整理する。

### ユーザー対応

- Contact Form 7 の送信元メールを本番ドメインのメールアドレスへ変更する。
- Contact Form 7 の `unsafe_email_without_protection` を解消する。
- 管理者宛メール、自動返信メール、迷惑メール、文字化けを実送信で確認する。
- 納品前に開発・移行補助系プラグインとゴミ箱投稿を整理する。
- 公開時に noindex / nofollow を解除する。

### 確認待ち

- ブラウザ接続後の 320 / 375 / 767 / 768 / 1440 / 1920 / 2650 表示確認。
- Console / Network のエラー有無。
- PHP CLIまたはWP_DEBUGログでのPHPエラー確認。
- Google Analytics / Search Console の接続状態。
