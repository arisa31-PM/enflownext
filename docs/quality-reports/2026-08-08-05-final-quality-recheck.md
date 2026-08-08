--------------------------------

比較対象

・2026-08-08-04-quality-recheck.md

--------------------------------

# 品質チェックレポート

## プロジェクト情報

| 項目 | 内容 |
| --- | --- |
| 実施日 | 2026-08-08 |
| プロジェクト | ポートフォリオ課題 |
| 実行モード | 最終再チェック（調査のみ・修正禁止） |
| 比較対象 | 2026-08-08-04-quality-recheck.md |
| チェック対象コミット（任意） | Git操作禁止のため未確認 |
| 判定 | 軽微な確認後に提出可能 |

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

- `docs/prompts/15-quality-check.md` の最新ルールに従った最終再チェック
- `13-static-checklist.md`、`12-wordpress-checklist.md`、`14-production-checklist.md` の順で確認
- 最新レポート1件のみを比較対象として確認
- 現在のコード、Local DB読み取り、本番HTML、本番HTTP、本番CSS/JSを再調査
- 修正、ビルド、DB更新、Git操作、本番メール送信は未実施

---

## チェック結果サマリー

| 集計項目 | 件数 |
| --- | ---: |
| 総チェック項目数 | 38 |
| OK件数 | 27 |
| 要確認件数 | 7 |
| 修正必要件数 | 0 |
| 確認不可件数 | 4 |

---

## 優先度別結果

### A：公開・動作へ影響する重大問題

- 該当なし。

### B：品質・UXへ影響する問題

- 該当なし。

### C：軽微な改善

- 本番の一部ページで `og:image` が `http://enflownext.com/...` として出力されている。表示・提出を阻害する問題ではないが、公開運用時はSEO SIMPLE PACKまたはメディアURL設定でHTTPSへ統一するとよい。

### ユーザー確認

- Contact Form 7 の本番送信元は `info@enflownext.com` に設定済みとユーザー確認済み。CodeXから本番管理画面は確認不可。
- 本番メール送受信、迷惑メール、文字化け確認は実メール送信禁止のため未実施。
- Chrome / Edge / Safari / iPhone / Android の実ブラウザ・実機確認はCodeXでは確認不可。
- スクール提出後、本公開時に noindex / nofollow の解除タイミングを確認する。

### 本番環境確認

- `https://enflownext.com/` および主要ページはHTTP 200。404確認用URLはHTTP 404。
- `styles.min.css` は本番HTTP 200、Localと本番のSHA-256が一致。
- 本番HTMLは `styles.min.css?ver=1786164727` を読み込んでおり、filemtime由来のバージョン付与が機能している。
- `script.min.js` は本番HTTP 200、Localと本番のSHA-256が一致。
- 本番HTMLに `meta name="generator"` は存在しない。
- `https://enflownext.com/wp-sitemap.xml` と子サイトマップ6件はすべてHTTP 200。
- 本番HTMLに実際出力された131件のリソースURLはすべてHTTP 200で、画像切れは確認されない。
- 本番テーマURLで `package.json`、`docs/INDEX.md`、`src/sass/...`、`gulp/gulpfile.js`、`AGENTS.md`、`.DS_Store` はHTTP 404。

### 確認不可

- 実ブラウザでの 320 / 375 / 767 / 768 / 1440 / 1920 / 2650 表示確認。
- 実ブラウザでの Console / Network 確認。
- Edge / Safari / iPhone / Android 実機確認。
- PHP CLIによる構文チェック。`php` コマンドが利用不可。

---

## 詳細結果

| 項目 | 結果 | 確認方法 | 対象ページ | 対象ファイル | 問題内容 | 推奨対応 | 優先度 | 備考 |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| 最新レポート確認 | ✅ OK | `ls -t docs/quality-reports`、最新1件のみ読込 | 全体 | `2026-08-08-04-quality-recheck.md` | 比較対象を最新1件に限定 | 次回は本レポートのみ比較対象 | - | 以前のレポートは履歴扱い |
| 本番主要ページ | ✅ OK | `curl` | `/` `/works/` `/price/` `/profile/` `/news/` `/faq/` `/contact/` `/contact/thanks/` | - | 主要ページはHTTP 200 | - | - | 404確認用URLはHTTP 404 |
| ヘッダー現在地表示設計 | ✅ OK | コード確認 | 全体 | `header.php` | `$current_nav_key` で一覧・詳細・カテゴリー・タクソノミー・固定ページを判定 | - | - | `is_home()`、`is_category()`、`is_singular()`、`is_post_type_archive()`、`is_tax()` を使用 |
| `is-current` 付与 | ✅ OK | 本番HTML検索 | `/works/` `/price/` `/profile/` `/news/` `/faq/` `/contact/` `/contact/thanks/` | `header.php` | 現在ページのPC/ドロワーリンクに付与 | - | - | トップと404は該当ナビなしのため0件 |
| `aria-current="page"` | ✅ OK | 本番HTML検索 | 同上 | `header.php` | `is-current` と同じリンクに付与 | - | - | ページネーションの `aria-current` とは区別して確認 |
| 他ページの誤現在地表示 | ✅ OK | 本番HTML検索 | 主要ページ | `header.php` | 各ページで対象ナビのみ現在地表示 | - | - | WORKS/NEWSはページネーションにも `aria-current` あり |
| ヘッダー現在地スタイル | ✅ OK | SCSS/CSS確認 | 全体 | `_p-header.scss`、`styles.min.css` | `.p-header__nav-link.is-current`、`.p-header__drawer-link.is-current` が生成CSSに反映 | - | - | CONTACTはベース表示が強いためclass/ARIA中心 |
| HTML基本構造 | ✅ OK | 本番HTML検索 | 主要ページ | `header.php` ほか | h1は各ページ1件、nav aria-labelあり | - | - | FAQはdl/dt/ddを確認 |
| WordPress generator | ✅ OK | 本番HTML検索 | 主要ページ、404 | `functions.php` | `meta name="generator"` は0件 | - | - | `remove_action( 'wp_head', 'wp_generator' )` 確認 |
| XMLサイトマップ親 | ✅ OK | `curl` | `/wp-sitemap.xml` | - | HTTP 200 | - | - | WordPress標準サイトマップ |
| XMLサイトマップ子 | ✅ OK | `curl` | 子サイトマップ6件 | - | 6件すべてHTTP 200 | - | - | posts/page/works/taxonomies/users |
| CSS本番HTTP | ✅ OK | `curl -D` | 全体 | `assets/css/styles.min.css` | HTTP 200 / `content-type: text/css` | - | - | 117120 bytes |
| CSS Local/本番一致 | ✅ OK | SHA-256比較 | 全体 | `assets/css/styles.min.css` | Localと本番が一致 | - | - | `764d3c81...` |
| CSS filemtime | ✅ OK | 本番HTML、`stat`、HTTPヘッダー | 全体 | `functions.php` | 本番HTMLに `?ver=1786164727` | - | - | Local filemtimeとは環境差あり。内容は一致 |
| SCSSと生成CSS | ✅ OK | mtime、CSS検索 | 全体 | `_p-header.scss`、`_p-profile.scss`、`styles.css`、`styles.min.css` | SCSS更新後に生成CSSが更新されている | - | - | 今回は `npm run build` 禁止のためビルド未実施 |
| JS本番HTTP/一致 | ✅ OK | `curl`、SHA-256比較 | 全体 | `assets/js/script.min.js` | HTTP 200、Localと本番が一致 | - | - | `1dfd418d...` |
| `_p-profile.scss` 1350px専用MQ | ✅ OK | `rg` | トップPROFILE | `_p-profile.scss` | 1350px専用メディアクエリは残っていない | - | - | 前回指摘は解消 |
| SCSS幅指定メディアクエリ | ✅ OK | `rg '@media'`、コード確認 | 全体 | `src/sass` | 768px以外の幅指定は合理的例外のみ | - | - | `html`の375/1350はルートフォント可読性・最大幅固定、600はWP管理バー、767はCF7チェックボックスのモバイル挙動調整 |
| SCSS hover/reduced-motion | ✅ OK | `rg '@media'`、コード確認 | 全体 | `src/sass` | 幅ブレークポイントではない | - | - | hover/pointerは入力デバイス、reduced-motionはアクセシビリティ対応のため例外 |
| SCSS calc/vw/overflow/height | ✅ OK | コード確認 | 全体 | `_p-profile.scss` ほか | 合理的理由のある使用を確認 | - | - | 画像比率維持、横幅演出、テキスト省略、アニメーション領域、アクセシビリティ制御のため例外 |
| `!important` | ✅ OK | コード確認 | 全体 | `_reset.scss`、本番EWWW出力 | reduced-motionとEWWW由来 | - | - | アクセシビリティ・プラグイン出力のため例外 |
| FVフォールバック設計 | ✅ OK | コード確認 | 下層FV | `template-parts/common/page-fv.php` | 静的画像が存在しない場合 `no-image.webp/png` へ安全にフォールバック | - | - | 動的アイキャッチ優先 |
| FV本番画像 | ✅ OK | 本番HTML、リソースHTTP確認 | 下層FV | - | 本番FVはアップロード画像を参照しHTTP 200 | - | - | 削除済みテーマ画像名はHTMLに出力されない |
| no-image本番 | ✅ OK | `curl`、HTML検索 | 一覧カード等 | `assets/images/no-image.webp/png` | no-image参照はHTTP 200 | - | - | アイキャッチ未設定時も画像切れなし |
| 本番画像切れ | ✅ OK | HTMLリソースURL抽出、HTTP確認 | 主要ページ | - | 131件すべてHTTP 200 | - | - | Console/Network実測とは別 |
| Contact Form 7本番送信元 | ✅ OK | ユーザー確認 | 本番管理画面 | - | `info@enflownext.com` 設定済み | - | - | CodeXでは本番管理画面確認不可 |
| Contact Form 7 Local参考 | ⚠️ 要確認 | Local DB読み取り | Local | DB | Local DBは旧送信元と `_config_validation` が残存 | 本番との差異として把握のみ | ユーザー確認 | Local DBのみを根拠に修正必要判定しない |
| Contact Form 7フォームHTML | ✅ OK | 本番HTML検索 | `/contact/` | - | 必須項目、ふりがなclass、同意チェック、確認ボタンあり | - | - | 実送信は禁止のため未実施 |
| タイムゾーン | ✅ OK | Local DB読み取り | Local | `wp_options` | `timezone_string=Asia/Tokyo` | - | - | Local URL画面は接続不可 |
| パーマリンク | ✅ OK | Local DB読み取り | Local | `wp_options` | `/%postname%/` | - | - | - |
| 有効テーマ | ✅ OK | Local DB読み取り | Local | `wp_options` | `template=stylesheet=enflownext` | - | - | - |
| noindex / nofollow | ⚠️ 要確認 | 本番HTML検索 | `/works/`、404 | SEO SIMPLE PACK | `/works/` と404に `noindex` | スクール提出前は現状許容。公開時に解除確認 | ユーザー確認 | nofollowはprefetch除外条件の文字列のみ |
| SEO head | ⚠️ 要確認 | 本番HTML検索 | 主要ページ | SEO SIMPLE PACK | title/description/canonical/OGP/faviconを確認 | `og:image` のHTTP URLは公開運用時にHTTPS統一推奨 | C | テーマ側で独自SEO実装なし |
| プライバシーポリシー | ✅ OK | 本番HTML検索 | `/contact/` footer | - | フッターリンク空は確認 | 今回スクール課題対象外 | - | 修正必要にしない |
| Local開発ファイル | ✅ OK | Localファイル確認、本番HTTP確認 | 本番テーマURL | `src` `gulp` `node_modules` `docs` ほか | Localには存在。本番URLでは確認対象ファイルが404 | - | - | Local存在のみでは問題なし |
| Local URL表示 | ➖ 確認不可 | `curl -I http://enflownext.local/` | Local | - | CodeX環境から接続不可 | ユーザー環境で確認 | 確認不可 | DB読み取りとは分離 |
| 実ブラウザ表示 | ➖ 確認不可 | Browser plugin | 320-2650 | - | 利用可能ブラウザ0件 | ユーザー環境で確認 | 確認不可 | 推測でOKにしない |
| Console / Network | ➖ 確認不可 | Browser plugin | 主要ページ | - | 利用可能ブラウザ0件 | ユーザー環境で確認 | 確認不可 | HTTP確認とは分離 |
| PHP構文チェック | ➖ 確認不可 | `php -v` | テーマPHP | PHP全体 | `php` コマンドなし | PHP CLIまたはWP_DEBUGログで確認 | 確認不可 | - |

---

## 修正履歴

| 修正日 | 修正内容 | 担当 | 再チェック結果 |
| --- | --- | --- | --- |
| 2026-08-08 | 最終再チェックのみ。PHP/SCSS/CSS/JS/画像/DB/設定/プラグイン/ビルド/Git/メール送信は未実施。 | Codex | 現在状態を基準に再判定 |

---

## 最終判定

軽微な確認後に提出可能。

今回のスクール課題として、コード・本番HTML・本番CSS/JS・サイトマップ・画像参照・WordPress generator・FVフォールバック・タイムゾーンは提出を阻害する問題なし。残る項目は、CodeXから利用可能な実ブラウザがないことによる表示/Console/Network未確認、ユーザー確認済みの本番管理画面設定、公開時に解除確認すべきnoindexなどであり、今回の提出不可理由にはしない。

---

## 備考

- CSS/JS生成ファイルは手動編集していない。
- `npm run build` は今回の禁止事項のため実行していない。
- 本番管理画面はCodeXから確認不可。Contact Form 7の本番送信元はユーザー確認済みとして扱った。
- Localの `src`、`gulp`、`node_modules`、`docs`、`AGENTS.md`、`package.json`、`package-lock.json` は開発環境に必要なため、Local存在のみでは問題なし。
- 本番テーマURLで代表的な開発ファイルは404だったため、本番公開ファイルとしての問題は確認されない。

---

## 前回レポートとの比較

### 解消した問題

- ヘッダーナビ現在地表示はコード・本番HTMLともに解消。`is-current` と `aria-current="page"` を確認。
- `_p-profile.scss` の1350px専用メディアクエリは削除済み。
- SCSSルール違反候補は最新ルールを適用し、合理的例外として扱えるものを修正必要から除外。
- Contact Form 7の本番送信元はユーザー確認済みのため、Local DBのみを根拠に修正必要とは判定しない。
- Local開発ファイルは本番URLで代表ファイルが404のため、Local存在のみを修正必要とは判定しない。

### 継続している問題

- 実ブラウザ/実機でのレスポンシブ、Console、Network確認はCodeXでは未実施。
- PHP CLIによる構文チェックは `php` コマンドがないため未実施。
- 本番管理画面の詳細設定はCodeXでは確認不可。

### 新しく発見した問題

- 提出を阻害する新規問題はなし。
- 軽微な注意として、一部ページの `og:image` がHTTP URLで出力されている。

### 確認不可

- 320 / 375 / 767 / 768 / 1440 / 1920 / 2650 の実ブラウザ表示。
- Chrome / Edge / Safari / iPhone / Android。
- 実ブラウザConsole / Network。
- 本番管理画面のContact Form 7、SEO SIMPLE PACK、Analytics/Search Console設定。
- 本番メール送受信。

### 今回案件では問題なし

- プライバシーポリシーはスクール課題対象外のため修正必要にしない。
- noindex / nofollowはスクール提出前の案件限定ルールにより、公開時の解除注意として扱う。
- Local開発ファイル、Local開発プラグイン、Local DB上の旧CF7情報は、本番公開状態またはユーザー確認済み事項と分けて扱う。
- `hover` / `any-hover` / `prefers-reduced-motion` メディアクエリ、画像比率維持・アニメーション・テキスト省略目的の `overflow` / `height` / `calc` は合理的例外として扱う。

---

## 次回の品質チェックで重点的に確認する項目

- 実ブラウザでの 320 / 375 / 767 / 768 / 1440 / 1920 / 2650 表示
- Console / Network
- 本番管理画面のSEO SIMPLE PACK、Contact Form 7、Analytics/Search Console設定
- 公開時の noindex / nofollow 解除
- `og:image` のHTTPS統一

---

## 参照チェックリスト

チェック項目は以下を参照し、このファイルには重複して記載しない。

- `13-static-checklist.md`
- `12-wordpress-checklist.md`
- `14-production-checklist.md`

---

## 次回アクション

### CodeX対応

なし

### ユーザー対応

- 実ブラウザ/実機で 320 / 375 / 767 / 768 / 1440 / 1920 / 2650、Chrome / Edge / Safari / iPhone / Android を確認する。
- 実ブラウザのConsole / Networkでエラーや404リソースがないことを確認する。
- 公開運用時に noindex / nofollow を解除する。
- 公開運用時に `og:image` がHTTPSで出力されるようSEO SIMPLE PACKまたはメディアURL設定を確認する。

### 確認待ち

- 本番管理画面のContact Form 7設定はユーザー確認済み。必要に応じて送受信、迷惑メール、文字化けをユーザー側で確認。
- Google Analytics / Search Console の接続状態。
