const gulp = require('gulp')
const concat = require('gulp-concat')
const uglify = require('gulp-uglify-es').default
const cleanCss = require('gulp-clean-css')
const rev = require('gulp-rev')
const del = require('del');
const git = require('gulp-git');
const imagemin = require('gulp-imagemin');
const htmlmin = require('gulp-htmlmin');
const rename = require('gulp-rename');

// remove old build files
gulp.task('clean', function () {
  return del([
    'build/*'
  ]);
});

// concatenate and minify JavaScript files
gulp.task('pack-js', function () {
  return gulp.src([
    './js/jquery.min.js',
    './js/plugins/jquery.mousewheel-3.0.6.pack.js',
    './js/plugins/imagesloaded.pkgd.min.js',
    './js/plugins/jquery.appear.min.js',
    './js/plugins/jquery.onepagenav.min.js',
    './js/plugins/jquery.bxslider/jquery.bxslider.min.js',
    './js/plugins/jquery.customscroll/jquery.mCustomScrollbar.concat.min.js',
    './js/plugins/jquery.owlcarousel/owl.carousel.min.js',
    './js/options.js',
    './js/site.js',
  ]).pipe(concat('bundle.js'))
  .pipe(uglify())
  .pipe(rev())
  .pipe(gulp.dest('build/js'))
  .pipe(rev.manifest('build/rev-manifest.json', {
    merge: true
  }))
  .pipe(gulp.dest('./'))
})

// concatenate and minify CSS files
gulp.task('pack-css', function () {
  return gulp.src([
    //'./fonts/fonts.css',
    './fonts/map-icons/css/map-icons.css',
    './fonts/icomoon/style.css',
    './js/plugins/jquery.bxslider/jquery.bxslider.css',
    './js/plugins/jquery.customscroll/jquery.mCustomScrollbar.min.css',
    './js/plugins/jquery.mediaelement/mediaelementplayer.min.css',
    './js/plugins/jquery.owlcarousel/owl.carousel.css',
    './js/plugins/jquery.owlcarousel/owl.theme.css',
    './style.css',
    './colors/green.css',
  ]).pipe(concat('bundle.css'))
  .pipe(cleanCss())
  .pipe(rev())
  .pipe(gulp.dest('build/css'))
  .pipe(rev.manifest('build/rev-manifest.json', {
    merge: true
  }))
  .pipe(gulp.dest('./'))
})

// compress the images to save space
gulp.task('optimize-images', function(){
  return gulp.src('./img/**/*')
  .pipe(imagemin())
  .pipe(gulp.dest('img'))
});

// minify HTML (it does not touch PHP code)
gulp.task('minify-html', () => {
  return gulp.src('./index-dev.php')
  .pipe(htmlmin({ collapseWhitespace: true, removeComments: true, minifyJS: true }))
  .pipe(rename({
    basename: 'index'
  }))
  .pipe(gulp.dest('.'));
});

// add the newly created bundle files to Git
gulp.task('git-add', function(){
  return gulp.src('./build/*')
  .pipe(git.add());
});

// run the above tasks after each other
gulp.task('default', gulp.series('clean', 'pack-js', 'pack-css', 'optimize-images', 'minify-html', 'git-add'))