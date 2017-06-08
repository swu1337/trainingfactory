import gulp from 'gulp';
import rename from 'gulp-rename';
import cssnano from 'gulp-cssnano';
import runSequence from 'run-sequence';
import concat from 'gulp-concat';
import bowerfiles from 'main-bower-files';
import inject from 'gulp-inject';
import uglify from 'gulp-uglify';
import babel from 'gulp-babel';
import postcss from 'gulp-postcss';
import autoprefixer from 'autoprefixer';

const stylesprop = {
    src: 'css/**/*.css',
    dest: 'build/css',
    rename: 'app.min.css'    
}

const scriptsprop =  {
    src: 'js/**/*.js',
    dest: 'build/js/',
    name: 'app.js',
    rename: 'app.min.js'
}

const injectprop = {
    jssrc: 'dev/view/templates/includes/footer.php',
    jsdest: 'dev/view/templates/includes/',
    jsinjectsrc: 'build/js/app.min.js',
    csssrc: 'dev/view/templates/includes/header.php',
    cssdest: 'dev/view/templates/includes/',
    cssinjectsrc: 'build/css/app.min.css'
}

gulp.task('scripts', () =>
    gulp.src(scriptsprop.src)
        .pipe(babel())
        .pipe(concat(scriptsprop.name))
        .pipe(uglify().on('error', (e) => {
            console.log(e);
        }))
        .pipe(rename(scriptsprop.rename))
        .pipe(gulp.dest(scriptsprop.dest))
);

gulp.task('styles', () =>
    gulp.src(stylesprop.src)
        .pipe(concat(stylesprop.rename))
        .pipe(cssnano())
        .pipe(gulp.dest(stylesprop.dest))
);

gulp.task('default', () =>
    runSequence(['scripts', 'styles'], ['inject:scripts', 'inject:styles'])
);
    
gulp.task('inject:styles', () => 
    gulp.src(injectprop.csssrc)
        .pipe(inject(gulp.src(bowerfiles(), { read: false }), { name: 'bower' }))
        .pipe(inject(gulp.src(injectprop.cssinjectsrc)))
        .pipe(gulp.dest(injectprop.cssdest))
);
    
gulp.task('inject:scripts', () =>
    gulp.src(injectprop.jssrc)
        .pipe(inject(gulp.src(bowerfiles(), { read: false }), { name: 'bower'}))
        .pipe(inject(gulp.src(injectprop.jsinjectsrc)))
        .pipe(gulp.dest(injectprop.jsdest))
);
