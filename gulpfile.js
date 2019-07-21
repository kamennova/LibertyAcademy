var gulp = require('gulp');
var minifyCSS = require('gulp-clean-css');
// var watch = require('gulp-watch');
var uglify = require('gulp-uglify');
var babel = require('gulp-babel');

function css(){
    return gulp.src('./web/css/*.css')
        .pipe(minifyCSS())
        .pipe(gulp.dest('./web/build'))
}

function js(){
    return gulp.src('./web/js/*.js')
        .pipe(babel({
            presets: ['@babel/preset-env']
        }))
        .pipe(uglify())
        .pipe(gulp.dest('./web/build'))
}

function watch() {
    gulp.watch('public/css/*.[less|css]', ['css']);
    gulp.watch('public/js/*.js', ['js']);
}

let my_task = gulp.series(css, js);

gulp.task('default', my_task);