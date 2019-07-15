const gulp = require('gulp');

const rename = require('gulp-rename');
const htmlMIN = require('gulp-htmlmin');

const uglifyCSS = require('gulp-uglifycss');
const cssImport = require('gulp-cssimport');
const sass = require('gulp-sass');

const notify = require('gulp-notify');

sass.compiler = require('node-sass');

// html
gulp.task('html', () => {
    return gulp.src('source/html/**')
        .pipe(htmlMIN({
            collapseInlineTagWhitespace: true
        }))
        .on('error', notify.onError('Erro: <%= error.message %>'))
        .pipe(gulp.dest('C:\\wamp\\www\\php\\callmusic'));
});

// image
gulp.task('image', () => {
    return gulp.src('source/assets/images/*')
        .on('error', notify.onError('Erro: <%= error.message %>'))
        .pipe(gulp.dest('C:\\wamp\\www\\php\\callmusic\\assets\\images'));
});

// php
gulp.task('php', () => {
    return gulp.src('source/php/**')
        .on('error', notify.onError('Erro: <%= error.message %>'))
        .pipe(gulp.dest('C:\\wamp\\www\\php\\callmusic'));
});

// css
gulp.task('css', () => {
    return gulp.src('source/assets/css/*.css')
        .pipe(cssImport())
        .pipe(uglifyCSS({
            'maxLineLen': 80,
            'uglyComments': true
        }))
        .pipe(rename({
            extname: '.min.css'
        }))
        .pipe(gulp.dest('C:\\wamp\\www\\php\\callmusic\\assets\\css'));
});

// sass
gulp.task('sass', () => {
    return gulp.src('source/assets/scss/*.scss')
        .pipe(sass(
            {
                outputStyle: 'compressed'
            }
        )).on('error', notify.onError('Erro: <%= error.message %>'))
        .pipe(rename(
            {
                extname: '.min.css'
            }
        ))
        .pipe(gulp.dest('C:\\wamp\\www\\php\\callmusic\\assets\\css'));
});

// watch
gulp.task('watch', () => {
    gulp.watch('**/*.html', gulp.task('html'));
    gulp.watch('**/*.css', gulp.task('css'));
    gulp.watch('**/*.scss', gulp.task('sass'));
    gulp.watch('**/*.php', gulp.task('php'));
    gulp.watch('**/*.jpg', gulp.task('image'));
});


gulp.task('build',
    gulp.series(gulp.parallel('html', 'css', 'php', 'image', 'sass'),
        gulp.parallel('watch')));