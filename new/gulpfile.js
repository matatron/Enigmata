/** ===========================================================================
 *
 * Gulpfile setup.
 *
 * @since 1.0.0
 * @version 1.4.4
 * @author Dan Fisher
 *
 * ========================================================================= */

'use strict';


/** ---------------------------------------------------------------------------
 * Load plugins
 * ------------------------------------------------------------------------- */

import gulp         from 'gulp';
import gulpSass     from 'gulp-sass';
import * as nodeSass     from 'sass';
import {deleteAsync}     from 'del';
import panini       from 'panini';
import rename       from 'gulp-rename';
import plumber      from 'gulp-plumber';
import notify       from 'gulp-notify';
import minifyJS     from 'gulp-uglify';
import concatJS     from 'gulp-concat';
import includeJS    from 'gulp-include';
import cssNano      from 'gulp-cssnano';
import gulpIf       from 'gulp-if';
import autoprefixer from 'gulp-autoprefixer';
import replace      from 'gulp-replace';
import sourcemaps   from 'gulp-sourcemaps';
import svgSprites   from 'gulp-svg-sprites';
import imagemin     from 'gulp-imagemin';
import sync         from 'browser-sync';
import yargs        from 'yargs';

// Custom
import htmlmin      from 'gulp-htmlmin';

// Sass
const sass = gulpSass(nodeSass);


/** ---------------------------------------------------------------------------
 * Configuration.
 * ------------------------------------------------------------------------- */

const CONFIG = {
  "PATH": {
    "src": "source",
    "dist": "build",
    "src_js": "source/assets/js",
    "dist_js": "build/assets/js",
    "src_css": "source/assets/scss",
    "dist_css": "build/assets/css",
    "src_img": "source/assets/img",
    "dist_img": "build/assets/img"
  },
  "SERVER": {
    "port": 3000,
    "injectChanges": true,
    "server": {
      "baseDir": "build"
    },
    "ghostMode": {
      "clicks": false,
      "forms": false,
      "scroll": false
    }
  },
  "PANINI": {
    "root": "source/pages/",
    "layouts": "source/layouts/",
    "partials": "source/partials/",
    "helpers": "source/helpers/",
    "data": "source/data/"
  },
  "AUTOPREFIXER": {
    "browsers": [
      "last 2 versions",
      "IE 11",
      "Firefox ESR"
    ]
  },
  "COPY": [
    "source/**",
    "!source/{data,helpers,layouts,pages,partials}",
    "!source/{data,helpers,layouts,pages,partials}/**",
    "!source/assets/{img,scss}",
    "!source/assets/{img,scss}/**",
    "!source/assets/vendor/bootstrap/scss",
    "!source/assets/vendor/bootstrap/scss/**"
  ],
  "FTP": {
    "host": "",
    "port": 21,
    "user": "",
    "password": "",
    "localFiles": "build/**/*.*",
    "remoteFolder": ""
  }
};

const PATHS = CONFIG.PATH;
const FTP = CONFIG.FTP;


/** ---------------------------------------------------------------------------
 * Look for the --production flag.
 * ------------------------------------------------------------------------- */

const PRODUCTION = yargs.argv.production;



/** ---------------------------------------------------------------------------
  * Regular tasks.
  * ------------------------------------------------------------------------- */

// Deletes the dist folder so the build can start fresh.
export const reset = () => {
  return deleteAsync(PATHS.dist);
};

// Copies the necessary files from src to dist.
export const copy = () => {
  return gulp
    .src(CONFIG.COPY)
    .pipe(gulp.dest(PATHS.dist));
};

// Compiles Handlebars templates with Panini.
export const pages = () => {
  return gulp
    .src(PATHS.src + '/pages/**/*.hbs')
    .pipe(panini(CONFIG.PANINI))
    // .pipe(gulpIf(PRODUCTION, replace('.css"', '.min.css"')))
    // .pipe(gulpIf(PRODUCTION, replace('core.js', 'core.min.js')))
    .pipe(rename({
      extname: '.html'
    }))
    .pipe(gulpIf(PRODUCTION, htmlmin({collapseWhitespace: true})))
    .pipe(gulp.dest(PATHS.dist));
};



// Refresh Panini.
export const paniniRefresh = (done) => {
  panini.refresh();
  done();
};


// Creates a server with BrowserSync and watch for file changes.
export const watch = () => {
  sync.init(CONFIG.SERVER);

  // Watch for file changes.
  gulp.watch(
    PATHS.src + '/{data,helpers,layouts,pages,partials}/**/*',
    gulp.series(watchHtml)
  );
  gulp.watch(
    PATHS.src_css + '/**/*.scss',
    gulp.series(sassCompile)
  );
  gulp.watch(
    PATHS.src_js + '/**/*.js',
    gulp.series(watchJS)
  );
  gulp.watch(
    [
      PATHS.src_img + '/**/*.{png,jpg,gif,svg,ico}',
      '!' + PATHS.src_img + '/sprites/**'
    ],
    gulp.series(watchImg)
  );
  gulp.watch(
    PATHS.src_img + '/sprites/**/*.svg',
    gulp.series(sprites)
  );
}


// Compiles Sass to CSS.
export const sassCompile = () => {
  return gulp
    .src(PATHS.src_css + '/**/*.scss')
    .pipe(gulpIf(!PRODUCTION, sourcemaps.init()))
    .pipe(plumber({
      errorHandler: notify.onError({
        title: 'Gulp error in the <%= error.plugin %> plugin',
        message: '<%= error.message %>'
      })
    }))
    .pipe(sass({
      outputStyle: 'expanded'
    }))
    .pipe(autoprefixer(CONFIG.AUTOPREFIXER))
    .pipe(replace('/**/', ''))
    .pipe(plumber.stop())
    .pipe(gulpIf(!PRODUCTION, sourcemaps.write('/maps')))
    .pipe(gulpIf(PRODUCTION, cssNano()))
    .pipe(gulp.dest(PATHS.dist_css))
    .pipe(sync.stream());
}


// Check JS code for errors.
export const lintJS = () => {
  return gulp
    .src([
      PATHS.src_js + '/**/*.js',
      '!' + PATHS.src_js + '/{cdn-fallback,vendor}/**/*'
    ])
    .pipe(jshint())
    .pipe(jshint.reporter('jshint-stylish'))
    .pipe(jshint.reporter('fail')) // task fails on JSHint error
    .pipe(sync.stream());
};


// Concatenate and minify JS.
export const js = () => {
  return gulp
    .src([
      PATHS.src_js + '/core.js'
    ])
    .pipe(gulpIf(!PRODUCTION, sourcemaps.init()))
    .pipe(includeJS())
    .pipe(concatJS('core.js'))
    .pipe(gulpIf(!PRODUCTION, sourcemaps.write('/maps')))
    .pipe(gulpIf(PRODUCTION, minifyJS()))
    .pipe(gulp.dest(PATHS.dist_js))
    .pipe(sync.stream());
};


// Minify JS init.
export const jsInit = () => {
  return gulp
    .src([
      PATHS.src_js + '/init.js'
    ])
    .pipe(gulpIf(PRODUCTION, minifyJS()))
    .pipe(gulp.dest(PATHS.dist_js))
    .pipe(sync.stream());
  };


// Creates sprites from SVG files.
export const sprites = () => {
  return gulp
    .src(PATHS.src_img + '/sprites/**/*.svg')
    .pipe(svgSprites({
      cssFile: 'assets/scss/components/_sprites.scss',
      common: 'icon-svg',
      padding: 0,
      baseSize: 10,
      templates: {
        scss: true
      },
      preview: false,
      svg: {
        sprite: 'assets/img/sprite.svg'
      },
      svgPath: "../img/sprite.svg",
      pngPath: "../img/sprite.svg"
    }))
    .pipe(gulp.dest(PATHS.src));
};


// Compresses images.
export const img = () => {
  return gulp
    .src([
      PATHS.src_img + '/**/*.{png,jpg,gif,svg,ico}',
      '!' + PATHS.src_img + '/*.{svg}',
      '!' + PATHS.src_img + '/sprites/**'
    ])
    .pipe(gulpIf(PRODUCTION, imagemin([
      imagemin.optipng({optimizationLevel: 3}),
      imagemin.jpegtran({progressive: true})
    ], {
      verbose: true
    })))
    .pipe(gulp.dest(PATHS.dist_img));
};




/** ---------------------------------------------------------------------------
 * Watch tasks
 * ------------------------------------------------------------------------- */

// HTML
export const watchHtml = gulp.series(
  paniniRefresh,
  pages,
  (cb) => {
    sync.reload();
    cb();
  }
);

// JS
export const watchJS = gulp.series(
  js,
  jsInit,
  (cb) => {
    sync.reload();
    cb();
  }
);

// Images
export const watchImg = gulp.series(
  img,
  (cb) => {
    sync.reload();
    cb();
  }
);



/** ---------------------------------------------------------------------------
 * Other tasks.
 * ------------------------------------------------------------------------- */

// Compiles Bootstrap.
export const bootstrap = () => {
  return gulp
    .src(PATHS.src + '/assets/vendor/bootstrap/scss/*.scss')
    .pipe(gulpIf(!PRODUCTION, sourcemaps.init()))
    .pipe(plumber({
      errorHandler: notify.onError({
        title: 'Gulp error in the <%= error.plugin %> plugin',
        message: '<%= error.message %>'
      })
    }))
    .pipe(sass({
      outputStyle: 'compressed'
    }))
    .pipe(autoprefixer(CONFIG.AUTOPREFIXER))
    .pipe(replace('/**/', ''))
    .pipe(plumber.stop())
    .pipe(gulpIf(!PRODUCTION, sourcemaps.write('/maps')))
    .pipe(gulpIf(PRODUCTION, cssNano()))
    .pipe(gulp.dest(PATHS.dist + '/assets/vendor/bootstrap/css'))
    .pipe(sync.stream());
};


/** ---------------------------------------------------------------------------
 * Main tasks.
 * ------------------------------------------------------------------------- */

export const build = gulp.series(
  reset,
  gulp.parallel(
    copy,
    pages,
    sprites
  ),
  gulp.parallel(
    sassCompile,
    bootstrap,
    js,
    jsInit,
    img
  )
);

export default gulp.series(
  build,
  watch,
);

export const deploy = gulp.series(
  build
);

