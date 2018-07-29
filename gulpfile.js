var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var notify = require('gulp-notify');
var jshint = require('gulp-jshint');
var imagemin = require('gulp-imagemin')
var sass = require('gulp-sass');
var minifyCSS = require('gulp-minify-css');


gulp.task('script', function(cb){
	// tarea script
	  return gulp.src('src/js/*.js')
        .pipe(concat('all.js'))
        .pipe(gulp.dest('dist'))
        .pipe(rename('all.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('dist/js'));
});

gulp.task('style', function() {
	// tarea style
	return gulp.src('src/sass/main.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(concat('main.min.css'))
    .pipe(gulp.dest('dist'))
    .pipe(minifyCSS())
    .pipe(gulp.dest('dist/css'));
});

gulp.task('images', function() {
	// tarea images
return gulp.src('img/*.jpeg')
	.pipe(gulp.dest('dist/'))
	.pipe(imagemin())
	.pipe(gulp.dest('dist/img/'));
});

var cachebust = require('gulp-cache-refresh');

gulp.src('./dist/*/*.html')
    .pipe(cachebust({
    type: 'timestamp'
    }))
.pipe(gulp.dest('./dist'));

gulp.task('watch', function() {
    gulp.watch('js/*.js', ['lint', 'scripts']);
    gulp.watch('./sass/**/*.scss', ['sass']);
});

gulp.task('default', ['images', 'style', 'script']);