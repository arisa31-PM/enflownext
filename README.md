# enflownext WordPress Theme

## 動作が確認できている環境
- Nodeバージョン v18.20.5
- Gulp 4系

## 使い方
- enflownextフォルダをエディターで開く
- テーマフォルダは `enflownext`
- gulpfile.jsの `themeName` は `enflownext`
- gulpfile.jsの `proxy` はLocalのサイトURLに合わせて設定する
- ターミナルを開き、「 cd enflownext 」とコマンドを入力する
- ターミナルを開き、「 npm i 」とコマンドを入力する
- enflownextフォルダ直下に、node_modulesとpackage-lock.jsonが生成されるのを確認する
- 「 npm run dev 」とコマンドを入力するとgulpが動き出す

## 作業ディレクトリ
- sass・jsの記述はsrcフォルダの中で行う
- 画像はsrcフォルダのimagesの中に格納する
- コンパイルされたCSS・jsと圧縮された画像はenflownext/assetsフォルダの中に出力される
- phpはテーマフォルダ直下のphpファイルに直接記述する

## 圧縮（本番環境などに）
- 「 npm run build 」で本番用(min化)を1回だけ実行します（watchなし）。
- 開発時は「 npx gulp 」を使うと非minのまま自動コンパイル&watchします。
-ビルド後もfunctions.phpの書き換えは不要です

## 注意事項
- min済みライブラリ（例: swiper-bundle.min.js / .css）は再min化しない設定です。
- 二重minを避けるため、開発中は「 npm run dev 」、本番前だけ「 npm run build 」を実行してください。
- 「 npm run build 」はタスク完了後に終了し、変更監視は行いません。

## 備考
- CSS設計はFLOCSS( https://github.com/hiloki/flocss )を採用
- スマホファースト
- rem記述を前提
