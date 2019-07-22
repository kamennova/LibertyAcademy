var gulp = require('gulp');
var minifyCSS = require('gulp-clean-css');
// var watch = require('gulp-watch');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var babel = require('gulp-babel');

function css() {
    return gulp.src(['./web/css/article_profile.css', './web/css/create-form.css', './web/css/forms.css',
        './web/css/profile.css', './web/css/sort-by-form.css'], {base: './web'})
        .pipe(minifyCSS())
        .pipe(gulp.dest('./web/build'))
}

function css_concat_layout() {
    return gulp.src(['./web/css/site.css', './web/css/list_layout.css', './web/css/article_index.css',
        './web/css/event_index.css', './web/css/trainer_view.css'], {base: './web/'})
        .pipe(concat('filter_layout.css'))
        .pipe(minifyCSS())
        .pipe(gulp.dest('./web/build'))
}

function css_concat_forms() {
    return gulp.src(['./web/css/site.css', './web/css/register.css', './web/css/forms.css'], {base: './web/'})
        .pipe(concat('trainer_forms.css'))
        .pipe(minifyCSS())
        .pipe(gulp.dest('./web/build'))
}

function css_concat_index() {
    return gulp.src(['./web/css/site.css', './web/css/site_index.css'], {base: './web/'})
        .pipe(concat('index.css'))
        .pipe(minifyCSS())
        .pipe(gulp.dest('./web/build'))
}

function js() {
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

let my_task = gulp.series(css, css_concat_index, css_concat_forms, css_concat_layout, js);

gulp.task('default', my_task);