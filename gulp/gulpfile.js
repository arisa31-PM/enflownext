const { src, dest, watch, series, parallel } = require("gulp");

// 入出力先指定
const srcBase = '../src';
const themeName = "enflownext";
const distBase = '..';
const assetsBase = '../assets';
const srcPath = {
  css: `${srcBase}/sass/**/*.scss`,
  cssLib: [`${srcBase}/css/**/*.css`, `!${srcBase}/css/**/*.min.css`],
  cssLibMin: `${srcBase}/css/**/*.min.css`,
  img: srcBase + '/images/**/*',
  js: [`${srcBase}/js/**/*.js`, `!${srcBase}/js/**/*.min.js`], // ライブラリのmin済みは除外
  jsUnminified: `${srcBase}/js/swiper-bundle.min.js`
};
const assetsPath = {
  css: assetsBase + '/css/',
  img: assetsBase + '/images/',
  js: assetsBase + '/js/',
};

// ローカルサーバー立ち上げ
const browserSync = require("browser-sync");
const browserSyncOption = {
  proxy: 'http://enflownext.local',
  open: false,
  notify: false,
};
const browserSyncFunc = (done) => {
  browserSync.init(browserSyncOption);
  done();
};
const browserSyncReload = (done) => {
  browserSync.reload();
  done();
};

// Sassコンパイル
const sass = require('gulp-sass')(require('sass'));
const sassGlob = require('gulp-sass-glob-use-forward');
const plumber = require("gulp-plumber");
const notify = require("gulp-notify");
const postcss = require("gulp-postcss");
const autoprefixer = require("autoprefixer");
const cssDeclarationSorter = require("css-declaration-sorter");
const sourcemaps = require("gulp-sourcemaps");
const cleanCSS = require('gulp-clean-css');
const rename = require('gulp-rename');
const uglify = require('gulp-uglify');
const beautify = require('gulp-beautify');

// ブラウザ対応設定
const browsers = [
  'last 2 versions',
  '> 1%',
  'not dead',
  'not ie <= 10',
];

// ★ rem/px フォールバック設定（ここで切り替え）
const remFallbackEnabled = false; // true: px+rem / false: remのみ

// remにpxフォールバックを追加
const postcssRemFallback = (options = {}) => {
  const enabled = options.enabled !== undefined ? options.enabled : true;
  const baseValue = options.baseValue || 16;

  return {
    postcssPlugin: 'postcss-rem-fallback',
    Once(root) {
      if (!enabled) return;

      root.walkDecls((decl) => {
        // rem値を含むプロパティを検出
        if (decl.value && decl.value.includes('rem')) {
          const pxValue = decl.value.replace(/(\d+\.?\d*)rem/g, (match, remValue) => {
            const px = parseFloat(remValue) * baseValue;
            return `${px}px`;
          });
          // 元の宣言の前にpx値を挿入
          decl.cloneBefore({ value: pxValue });
        }
      });
    }
  };
};
postcssRemFallback.postcss = true;

// minファイルをストリームから除外するフィルター
const through2 = require('through2');
const skipMinified = () => through2.obj((file, _, cb) => {
  if (file.basename.includes('.min.')) {
    return cb(); // 既にminifiedならスキップ
  }
  cb(null, file);
});

// CSSコンパイル（通常版生成）
const cssSass = () => {
  return src(`${srcBase}/sass/styles.scss`)
    .pipe(plumber({
      errorHandler: notify.onError('Error:<%= error.message %>')
    }))
    .pipe(sourcemaps.init())
    .pipe(sassGlob())
    .pipe(sass.sync({
      includePaths: ['src/sass'],
      outputStyle: 'expanded',
      silenceDeprecations: ['legacy-js-api'],
    }))
    .pipe(postcss([
      autoprefixer({
        overrideBrowserslist: browsers,
        cascade: false,
        grid: 'autoplace',
      }),
      postcssRemFallback({
        enabled: remFallbackEnabled,
        baseValue: 16
      }), // ★ rem → px+rem 変換
      cssDeclarationSorter({
        order: 'alphabetical',
      }),
    ]))
    .pipe(beautify.css({
      indent_size: 2,
      indent_char: ' ',
    }))
    .pipe(sourcemaps.write())
    .pipe(dest(assetsPath.css))
    .pipe(notify({
      message: 'Sassをコンパイルしたで〜！',
      onLast: true
    }));
};

// CSS圧縮タスク
const cssMinify = () => {
  return src([`${assetsPath.css}styles.css`, `!${assetsPath.css}*.min.css`, `!${assetsPath.css}*.map`])
    .pipe(plumber({
      errorHandler: notify.onError('Error:<%= error.message %>')
    }))
    .pipe(cleanCSS({
      compatibility: 'ie11',
      level: {
        1: {
          specialComments: 0,
        },
      },
    }))
    .pipe(rename({ suffix: '.min' }))
    .pipe(dest(assetsPath.css))
    .pipe(notify({
      onLast: true
    }));
};

const imagemin = require("gulp-imagemin");
const imageminMozjpeg = require("imagemin-mozjpeg");
const imageminPngquant = require("imagemin-pngquant");
const imageminSvgo = require("imagemin-svgo");
const webp = require('gulp-webp');

const imgImagemin = () => {
  return src(srcPath.img)
    .pipe(imagemin([
      imageminMozjpeg({ quality: 80 }),
      imageminPngquant(),
      imageminSvgo({ plugins: [{ removeViewbox: false }] })
    ], { verbose: true }))
    .pipe(dest(assetsPath.img))
    .pipe(webp())
    .pipe(dest(assetsPath.img));
};

// JSコンパイル（開発用：圧縮なし）
const jsCompile = () => {
  return src(`${srcBase}/js/**/*.js`, {
    ignore: ['**/*.min.js'],
  })
    .pipe(skipMinified())
    .pipe(plumber({
      errorHandler: notify.onError('Error:<%= error.message %>')
    }))
    .pipe(beautify.js({
      indent_size: 2,
      indent_char: ' ',
    }))
    .pipe(dest(assetsPath.js))
    .pipe(notify({
      onLast: true
    }));
};

// JS圧縮（本番用）
const jsMinify = () => {
  return src(`${assetsPath.js}**/*.js`, {
    ignore: ['**/*.min.js'], // 既にmin済みは除外
  })
    .pipe(skipMinified())
    .pipe(plumber({
      errorHandler: notify.onError('Error:<%= error.message %>')
    }))
    .pipe(uglify())
    .pipe(rename({ suffix: '.min' }))
    .pipe(dest(assetsPath.js))
    .pipe(notify({
      onLast: true
    }));
};

const jsCopy = (done) => {
  src(srcPath.jsUnminified, { allowEmpty: true })
    .pipe(plumber({
      errorHandler: notify.onError('Error:<%= error.message %>')
    }))
    .pipe(dest(assetsPath.js));
  done();
};

// ライブラリCSSコピー（既にminify済みのファイル）
const cssLibCopy = (done) => {
  src(srcPath.cssLibMin, { allowEmpty: true })
    .pipe(plumber({
      errorHandler: notify.onError('Error:<%= error.message %>')
    }))
    .pipe(dest(assetsPath.css));
  done();
};

// ライブラリCSSコピー（通常のCSSファイル、開発用）
const cssLibCompile = () => {
  return src(`${srcBase}/css/**/*.css`, {
    allowEmpty: true,
    ignore: ['**/*.min.css'],
  })
    .pipe(skipMinified())
    .pipe(plumber({
      errorHandler: notify.onError('Error:<%= error.message %>')
    }))
    .pipe(dest(assetsPath.css))
    .pipe(notify({
      onLast: true
    }));
};

// ライブラリCSS圧縮（本番用）
const cssLibMinify = () => {
  return src(`${assetsPath.css}**/*.css`, {
    allowEmpty: true,
    ignore: [
      '**/*.min.css', // 既にmin済みは除外
      '**/*.map',
      '**/styles.css',
    ],
  })
    .pipe(skipMinified())
    .pipe(plumber({
      errorHandler: notify.onError('Error:<%= error.message %>')
    }))
    .pipe(cleanCSS({
      compatibility: 'ie11',
      level: {
        1: {
          specialComments: 0,
        },
      },
    }))
    .pipe(rename({ suffix: '.min' }))
    .pipe(dest(assetsPath.css))
    .pipe(notify({
      onLast: true
    }));
};

const watchFiles = (done) => {
  watch(srcPath.css, series(cssSass, browserSyncReload));
  watch(srcPath.cssLib, series(cssLibCompile, browserSyncReload));
  watch(srcPath.cssLibMin, series(cssLibCopy, browserSyncReload));
  watch(srcPath.img, series(imgImagemin, browserSyncReload));
  watch(srcPath.js, series(jsCompile, browserSyncReload));
  watch(srcPath.jsUnminified, series(jsCopy, browserSyncReload));
  watch(`${distBase}/**/*.php`, browserSyncReload);
  done();
};

const del = require('del');
const delPath = {
  css: [`${assetsBase}/css/**/*.css`],
  cssMap: `${assetsBase}/css/**/*.css.map`,
  img: `${assetsBase}/images/**/*`,
  js: [`${assetsBase}/js/**/*.js`],
};

const clean = (done) => {
  del([...delPath.css, delPath.cssMap, delPath.img, ...delPath.js], { force: true });
  done();
};

// エクスポート
exports.cssSass = cssSass;
exports.cssMinify = cssMinify;
exports.cssLibCopy = cssLibCopy;
exports.cssLibCompile = cssLibCompile;
exports.cssLibMinify = cssLibMinify;
exports.imgImagemin = imgImagemin;
exports.jsCompile = jsCompile;
exports.jsMinify = jsMinify;
exports.jsCopy = jsCopy;
exports.watch = watchFiles;
exports.clean = clean;

// 開発用タスク（圧縮なし）
exports.dev = series(clean, imgImagemin, cssSass, cssLibCompile, cssLibCopy, jsCompile, jsCopy, parallel(watchFiles, browserSyncFunc));

// 本番用タスク（圧縮あり）
exports.build = series(
  clean,
  imgImagemin,
  cssSass,
  cssMinify,
  cssLibCompile,
  cssLibMinify,
  cssLibCopy, // min済みライブラリは最後にコピーして再minifyを防止
  jsCompile,
  jsMinify,
  jsCopy
);

// デフォルトは開発用
exports.default = exports.dev;

// デバッグ用
exports.testSass = () => {
  return src(srcPath.css)
    .pipe(sassGlob())
    .pipe(sass.sync({ outputStyle: 'expanded' }))
    .pipe(dest(assetsPath.css));
};
