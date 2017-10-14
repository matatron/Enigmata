// gulp
var gulp = require('gulp');

// plugins
var jshint = require('gulp-jshint');
var uglify = require('gulp-uglify');
var sass = require('gulp-sass');
var minifyCSS = require('gulp-minify-css');
var clean = require('gulp-clean');
var runSequence = require('run-sequence');
var sassIncludes = [
    './bower_components/materialize/sass/',
];

// tasks
gulp.task('minify-css', function() {
    var opts = {comments:true,spare:true};
    return gulp.src(['./app/scss/**/*.scss'])
        .pipe(sass({includePaths: sassIncludes}).on('error', sass.logError))
        .pipe(minifyCSS(opts))
        .pipe(gulp.dest('../htdocs/'))
});
// default task
gulp.task('default', function() {
    runSequence(
        ['minify-css']
    );
    gulp.watch('./app/scss/**/*.css', ['minify-css']);
});
