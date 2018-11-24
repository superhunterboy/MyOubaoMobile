var gulp = require('gulp'),
        // 混淆代码
        // obfuscate = require('gulp-obfuscate'),
        uglify = require('gulp-uglify'),
        concat = require('gulp-concat'),
        rename = require('gulp-rename'),
        insert = require('gulp-insert'),
        imagemin = require('gulp-imagemin'),
        sass = require('gulp-sass'),
          svgmin       = require('gulp-svgmin'),
        autoprefixer = require('gulp-autoprefixer'),
        cssbeautify = require('gulp-cssbeautify'),
        FileCache = require("gulp-file-cache"),
        cache = require('gulp-cache'),
        minifycss = require('gulp-minify-css'),
        sourcemaps = require('gulp-sourcemaps'),
        pngquant = require('imagemin-pngquant'),
        watch = require('gulp-watch');

obfuscate_letter = '/*\u202e*/';
var uglify_options = {
    output: {
        max_line_len: 999999999
    }
};

gulp.task('gamedice-concat', function () {
    return gulp.src([
        'userpublic/assets/js/gamedice/dsgame.Gamedices.config.js',
        'userpublic/assets/js/gamedice/dsgame.Gamedices.gamedice.js',
        'userpublic/assets/js/gamedice/dsgame.Gamedices.utils.js',
        'userpublic/assets/js/gamedice/dsgame.Gamedices.bootstrap.js',
    ])
            .pipe(concat('dsgame.gamedice.src.js'))
            .pipe(gulp.dest('userpublic/assets/js/gamedice'))
            // .pipe(obfuscate())
            .pipe(uglify(uglify_options))
            .pipe(insert.prepend('/*\u202e*/'))
            .pipe(rename('dsgame.gamedice.min.js'))
            .pipe(gulp.dest('userpublic/assets/js-dist/gamedice'));
});

gulp.task('gamedice', function () {
    return gulp.src(['userpublic/assets/js/gamedice/**/*.js', '!userpublic/assets/js/gamedice/*.js'])
            // .pipe(obfuscate())
            .pipe(uglify(uglify_options))
            .pipe(rename({
                extname: '.min.js'
            }))
            .pipe(insert.prepend('/*\u202e*/'))
            .pipe(gulp.dest('userpublic/assets/js-dist/gamedice'));
});


gulp.task('game-concat', function () {
    return gulp.src([
        'userpublic/assets/js/game/dsgame.Games.js',
        'userpublic/assets/js/game/dsgame.Game.js',
        'userpublic/assets/js/game/dsgame.GameMethod.js',
        'userpublic/assets/js/game/dsgame.GameMessage.js',
        'userpublic/assets/js/game/dsgame.GameStatistics.js',
        'userpublic/assets/js/game/dsgame.GameTypes.js',
        'userpublic/assets/js/game/dsgame.GameOrder.js',
        'userpublic/assets/js/game/dsgame.GameTrace.js',
        'userpublic/assets/js/game/dsgame.GameSubmit.js'
    ])
            .pipe(concat('dsgame.game.src.js'))
            .pipe(gulp.dest('userpublic/assets/js/game'))
            // .pipe(obfuscate())
            .pipe(uglify(uglify_options))
            .pipe(insert.prepend('/*\u202e*/'))
            .pipe(rename('dsgame.game.min.js'))
            .pipe(gulp.dest('userpublic/assets/js-dist/game'));
});

gulp.task('game-ssc', function () {
    return gulp.src([
        'userpublic/assets/js/game/ssc/dsgame.Games.SSC.js',
        'userpublic/assets/js/game/ssc/dsgame.Games.SSC.config.js',
        'userpublic/assets/js/game/ssc/dsgame.Games.SSC.Message.js',
        'userpublic/assets/js/game/ssc/dsgame.Games.SSC.Danshi.js',
        'userpublic/assets/js/game/ssc/dsgame.Games.SSC.init.js'
    ])
            .pipe(concat('dsgame.game-ssc.src.js'))
            .pipe(gulp.dest('userpublic/assets/js/game'))
            // .pipe(obfuscate())
            .pipe(uglify(uglify_options))
            .pipe(insert.prepend('/*\u202e*/'))
            .pipe(rename('dsgame.game-ssc.min.js'))
            .pipe(gulp.dest('userpublic/assets/js-dist/game'));
});

gulp.task('game-l115', function () {
    return gulp.src([
        'userpublic/assets/js/game/l115/dsgame.Games.L115.js',
        'userpublic/assets/js/game/l115/dsgame.Games.L115.config.js',
        'userpublic/assets/js/game/l115/dsgame.Games.L115.Message.js',
        'userpublic/assets/js/game/l115/dsgame.Games.L115.Danshi.js',
        'userpublic/assets/js/game/l115/dsgame.Games.L115.init.js'
    ])
            .pipe(concat('dsgame.game-l115.src.js'))
            .pipe(gulp.dest('userpublic/assets/js/game'))
            // .pipe(obfuscate())
            .pipe(uglify(uglify_options))
            .pipe(insert.prepend('/*\u202e*/'))
            .pipe(rename('dsgame.game-l115.min.js'))
            .pipe(gulp.dest('userpublic/assets/js-dist/game'));
});

gulp.task('game-k3', function () {
    return gulp.src([
        'userpublic/assets/js/game/k3/dsgame.Games.K3.js',
        'userpublic/assets/js/game/k3/dsgame.Games.K3.config.js',
        'userpublic/assets/js/game/k3/dsgame.Games.K3.Message.js',
        'userpublic/assets/js/game/k3/dsgame.Games.K3.Danshi.js',
        'userpublic/assets/js/game/k3/dsgame.Games.K3.init.js'
    ])
            .pipe(concat('dsgame.game-k3.src.js'))
            .pipe(gulp.dest('userpublic/assets/js/game'))
            // .pipe(obfuscate())
            .pipe(uglify(uglify_options))
            .pipe(insert.prepend('/*\u202e*/'))
            .pipe(rename('dsgame.game-k3.min.js'))
            .pipe(gulp.dest('userpublic/assets/js-dist/game'));
});

gulp.task('game-pk10', function () {
    return gulp.src([
        'userpublic/assets/js/game/pk10/dsgame.Games.PK10.js',
        'userpublic/assets/js/game/pk10/dsgame.Games.PK10.config.js',
        'userpublic/assets/js/game/pk10/dsgame.Games.PK10.Message.js',
        'userpublic/assets/js/game/pk10/dsgame.Games.PK10.Danshi.js',
        'userpublic/assets/js/game/pk10/dsgame.Games.PK10.init.js'
    ])
            .pipe(concat('dsgame.game-pk10.src.js'))
            .pipe(gulp.dest('userpublic/assets/js/game'))
            // .pipe(obfuscate())
            .pipe(uglify(uglify_options))
            .pipe(insert.prepend('/*\u202e*/'))
            .pipe(rename('dsgame.game-pk10.min.js'))
            .pipe(gulp.dest('userpublic/assets/js-dist/game'));
});

gulp.task('game-nssc', function () {
    return gulp.src([
        'userpublic/assets/js/game/nssc/dsgame.Games.NSSC.js',
        'userpublic/assets/js/game/nssc/dsgame.Games.NSSC.config.js',
        'userpublic/assets/js/game/nssc/dsgame.Games.NSSC.Message.js',
        'userpublic/assets/js/game/nssc/dsgame.Games.NSSC.Danshi.js',
        'userpublic/assets/js/game/nssc/dsgame.Games.NSSC.init.js'
    ])
            .pipe(concat('dsgame.game-nssc.src.js'))
            .pipe(gulp.dest('userpublic/assets/js/game'))
            // .pipe(obfuscate())
            .pipe(uglify(uglify_options))
            .pipe(insert.prepend('/*\u202e*/'))
            .pipe(rename('dsgame.game-nssc.min.js'))
            .pipe(gulp.dest('userpublic/assets/js-dist/game'));
});

gulp.task('images', function () {
    return gulp.src([
        'userpublic/assets/images/*',
        'userpublic/assets/images/*/*',
        '!userpublic/assets/images/*/*.css'
    ])
            .pipe(imagemin({
                progressive: true,
                svgoPlugins: [{removeViewBox: false}],
                use: [pngquant()]
            }))
            .pipe(gulp.dest('userpublic/assets/images/'));
});


gulp.task('default',
        [
            'gamedice-concat',
            'gamedice',
            'game-concat',
            'game-ssc',
            'game-l115',
            'game-k3',
            'game-pk10',
            'game-nssc',
            'images'
        ], function () {

});



/*
 *** ################################### 手机版
 */
gulp.task('mp-images', function () {
    return gulp.src([
        'mobilepublic/assets/src/images/*',
        'mobilepublic/assets/src/images/*/*',
        'mobilepublic/assets/src/images/*/*/*',
        '!mobilepublic/assets/src/images/*/images',
        '!mobilepublic/assets/src/images/*/images/*',
        '!mobilepublic/assets/src/images/*/*/images'
    ])
            // .pipe(filecache.filter())
            .pipe(imagemin({
                progressive: true,
                svgoPlugins: [{removeViewBox: false}],
                use: [pngquant()]
            }))
            // .pipe(filecache.cache())
            .pipe(gulp.dest('mobilepublic/assets/dist/images'));
});
gulp.task('mp-script', function () {
    return gulp.src([
        'mobilepublic/assets/src/js/*.js',
        'mobilepublic/assets/src/js/game/*.js'
    ])
            .pipe(uglify(uglify_options))
            .pipe(rename({
                extname: '.min.js'
            }))
            .pipe(insert.prepend(obfuscate_letter))
            .pipe(gulp.dest('mobilepublic/assets/dist/js'));
});
gulp.task('mp-concat-js', function () {
    return gulp.src([
        'mobilepublic/assets/third/js/jquery-1.9.1.min.js',
        'mobilepublic/assets/third/bootstrap/js/bootstrap.min.js',
        'mobilepublic/assets/third/bootstrap3-dialog/dist/js/bootstrap-dialog.min.js',
        'mobilepublic/assets/third/js/jquery.mobile.custom.min.js',
        'mobilepublic/assets/third/js/fastclick.js',
        'mobilepublic/assets/third/clipboard.js/clipboard.js'
    ])
            .pipe(concat('third.min.js'))
            .pipe(uglify(uglify_options))
            .pipe(insert.prepend(obfuscate_letter))
            .pipe(gulp.dest('mobilepublic/assets/dist/js'));
});
gulp.task('mp-concat-css', function () {
    return gulp.src([
        'mobilepublic/assets/third/bootstrap/css/bootstrap.min.css',
        'mobilepublic/assets/third/bootstrap/css/bootstrap-theme.min.css',
        'mobilepublic/assets/third/bootstrap3-dialog/dist/css/bootstrap-dialog.min.css'
    ])
            .pipe(concat('third.min.css'))
            // .pipe(minifycss())
            // .pipe(rename({
            //  extname: '.min.js'
            // }))
            // .pipe(insert.prepend(obfuscate_letter))
            .pipe(gulp.dest('mobilepublic/assets/third/bootstrap/css/'));
    // 因为需要bootstrap的字体，所以生成到bootstrap目录下
});
gulp.task('mp-games-js', function () {
    return gulp.src([
        'mobilepublic/assets/src/js/games/betgame.base.js',
        'mobilepublic/assets/src/js/games/betgame.Games.js',
        'mobilepublic/assets/src/js/games/betgame.Game.js',
        'mobilepublic/assets/src/js/games/betgame.GameMessage.js',
        'mobilepublic/assets/src/js/games/betgame.GameMethod.js',
        'mobilepublic/assets/src/js/games/betgame.GameOrder.js',
        'mobilepublic/assets/src/js/games/betgame.GameRecords.js',
        'mobilepublic/assets/src/js/games/betgame.GameStatistics.js',
        'mobilepublic/assets/src/js/games/betgame.GameSubmit.js',
        'mobilepublic/assets/src/js/games/betgame.GameTrace.js',
        'mobilepublic/assets/src/js/games/betgame.GameTypes.js',
        'mobilepublic/assets/src/js/games/*.js'
    ])
            .pipe(concat('betgame.Games.all.js'))
            .pipe(uglify(uglify_options))
            .pipe(rename({
                extname: '.min.js'
            }))
            .pipe(insert.prepend(obfuscate_letter))
            .pipe(gulp.dest('mobilepublic/assets/dist/js'));
});
gulp.task('mp-game-js', function () {
    return gulp.src([
        'mobilepublic/assets/src/js/game/*/*.js',
        '!mobilepublic/assets/src/js/game/*/betgame.Games.SSC.js',
        '!mobilepublic/assets/src/js/game/*/betgame.Games.L115.js',
        '!mobilepublic/assets/src/js/game/*/betgame.Games.K3.js',
        '!mobilepublic/assets/src/js/game/*/betgame.Games.*.config.js',
        '!mobilepublic/assets/src/js/game/*/betgame.Games.*.Message.js'
    ])
            // .pipe(filecache.filter())
            .pipe(uglify(uglify_options))
            .pipe(insert.prepend(obfuscate_letter))
            // .pipe(filecache.cache())
            .pipe(gulp.dest('mobilepublic/assets/dist/js/game/'));
});

gulp.task('mp-ssc-js', function () {
    return gulp.src([
        'mobilepublic/assets/src/js/game/ssc/betgame.Games.SSC.js',
        'mobilepublic/assets/src/js/game/ssc/betgame.Games.SSC.config.js',
        'mobilepublic/assets/src/js/game/ssc/betgame.Games.SSC.Message.js',
        'mobilepublic/assets/src/js/game/ssc/betgame.Games.SSC.Danshi.js'
    ])
            .pipe(concat('betgame.Games.SSC.js'))
            .pipe(uglify(uglify_options))
            .pipe(rename({
                extname: '.min.js'
            }))
            .pipe(insert.prepend(obfuscate_letter))
            .pipe(gulp.dest('mobilepublic/assets/dist/js'));
});
gulp.task('mp-l115-js', function () {
    return gulp.src([
        'mobilepublic/assets/src/js/game/l115/betgame.Games.L115.js',
        'mobilepublic/assets/src/js/game/l115/betgame.Games.L115.config.js',
        'mobilepublic/assets/src/js/game/l115/betgame.Games.L115.Message.js',
        'mobilepublic/assets/src/js/game/l115/betgame.Games.L115.Danshi.js'
    ])
            .pipe(concat('betgame.Games.L115.js'))
            .pipe(uglify(uglify_options))
            .pipe(rename({
                extname: '.min.js'
            }))
            .pipe(insert.prepend(obfuscate_letter))
            .pipe(gulp.dest('mobilepublic/assets/dist/js'));
});
gulp.task('mp-k3-js', function () {
    return gulp.src([
        'mobilepublic/assets/src/js/game/k3/betgame.Games.K3.js',
        'mobilepublic/assets/src/js/game/k3/betgame.Games.K3.config.js',
        'mobilepublic/assets/src/js/game/k3/betgame.Games.K3.Message.js',
        'mobilepublic/assets/src/js/game/k3/betgame.Games.K3.Danshi.js'
    ])
            .pipe(concat('betgame.Games.K3.js'))
            .pipe(uglify(uglify_options))
            .pipe(rename({
                extname: '.min.js'
            }))
            .pipe(insert.prepend(obfuscate_letter))
            .pipe(gulp.dest('mobilepublic/assets/dist/js'));
});

gulp.task('mp-pk10-js', function(){
  return gulp.src([
      'mobilepublic/assets/src/js/game/pk10/betgame.Games.PK10.js',
      'mobilepublic/assets/src/js/game/pk10/betgame.Games.PK10.config.js',
      'mobilepublic/assets/src/js/game/pk10/betgame.Games.PK10.Message.js',
      'mobilepublic/assets/src/js/game/pk10/betgame.Games.PK10.Danshi.js'
    ])
    .pipe(concat('betgame.Games.PK10.js'))
    .pipe(uglify(uglify_options))
    .pipe(insert.prepend( obfuscate_letter ))
    .pipe(rename({
      extname: '.min.js'
    }))
    .pipe(gulp.dest('mobilepublic/assets/dist/js/'));
});

gulp.task('mp-sass', function () {
    return gulp.src([
        'mobilepublic/assets/src/scss/*.scss',
        '!mobilepublic/assets/src/scss/common.scss'
    ])
            .pipe(sass())
            // .pipe(sass())
            .pipe(autoprefixer())
            .pipe(cssbeautify({
                indent: '  ',
                openbrace: 'end-of-line',
                autosemicolon: true
            }))
            // .pipe(sourcemaps.init())
            .pipe(minifycss())
            .pipe(insert.prepend(obfuscate_letter))
            .pipe(rename({
                extname: '.min.css'
            }))
            // .pipe(sourcemaps.write('../maps'))
            .pipe(gulp.dest('mobilepublic/assets/dist/css'));
});

gulp.task('mp-svg', function () {
    return gulp.src([
        'mobilepublic/assets/src/images/svg/*.svg',
        'mobilepublic/assets/src/images/svg/*/*.svg'
    ])
            // .pipe(filecache.filter())
            // .pipe(cache(svgmin()))
            .pipe(svgmin())
            // .pipe(filecache.cache())
            .pipe(gulp.dest('mobilepublic/assets/dist/images/svg'));
});

var onchange = function (event) {
    console.log('File ' + event.path.split('userpublic')[1] + ' was ' + event.type + ', running tasks...');
};

gulp.watch([
    'userpublic/assets/js/gamedice/dsgame.Gamedices.**.js'
], ['gamedice-concat']).on('change', onchange);

gulp.watch([
    'userpublic/assets/js/gamedice/**/*.js',
    '!userpublic/assets/js/gamedice/*.js'
], ['gamedice']).on('change', onchange);

gulp.watch([
    'userpublic/assets/js/game/dsgame.Game**.js'
], ['game-concat']).on('change', onchange);

gulp.watch([
    'userpublic/assets/js/game/ssc/dsgame.Games.SSC.js',
    'userpublic/assets/js/game/ssc/dsgame.Games.SSC.config.js',
    'userpublic/assets/js/game/ssc/dsgame.Games.SSC.Message.js',
    'userpublic/assets/js/game/ssc/dsgame.Games.SSC.Danshi.js',
    'userpublic/assets/js/game/ssc/dsgame.Games.SSC.init.js'
], ['game-ssc']).on('change', onchange);

gulp.watch([
    'userpublic/assets/js/game/l115/dsgame.Games.L115.js',
    'userpublic/assets/js/game/l115/dsgame.Games.L115.config.js',
    'userpublic/assets/js/game/l115/dsgame.Games.L115.Message.js',
    'userpublic/assets/js/game/l115/dsgame.Games.L115.Danshi.js',
    'userpublic/assets/js/game/l115/dsgame.Games.L115.init.js'
], ['game-l115']).on('change', onchange);

gulp.watch([
    'userpublic/assets/js/game/k3/dsgame.Games.K3.js',
    'userpublic/assets/js/game/k3/dsgame.Games.K3.config.js',
    'userpublic/assets/js/game/k3/dsgame.Games.K3.Message.js',
    'userpublic/assets/js/game/k3/dsgame.Games.K3.Danshi.js',
    'userpublic/assets/js/game/k3/dsgame.Games.K3.init.js'
], ['game-k3']).on('change', onchange);

gulp.watch([
    'userpublic/assets/js/game/pk10/dsgame.Games.PK10.js',
    'userpublic/assets/js/game/pk10/dsgame.Games.PK10.config.js',
    'userpublic/assets/js/game/pk10/dsgame.Games.PK10.Message.js',
    'userpublic/assets/js/game/pk10/dsgame.Games.PK10.Danshi.js',
    'userpublic/assets/js/game/pk10/dsgame.Games.PK10.init.js'
], ['game-pk10']).on('change', onchange);

gulp.watch([
    'userpublic/assets/js/game/nssc/dsgame.Games.NSSC.js',
    'userpublic/assets/js/game/nssc/dsgame.Games.NSSC.config.js',
    'userpublic/assets/js/game/nssc/dsgame.Games.NSSC.Message.js',
    'userpublic/assets/js/game/nssc/dsgame.Games.NSSC.Danshi.js',
    'userpublic/assets/js/game/nssc/dsgame.Games.NSSC.init.js'
], ['game-nssc']).on('change', onchange);


// MOBILE
gulp.watch([
    'mobilepublic/assets/src/js/*.js',
    'mobilepublic/assets/src/js/game/*.js'
], ['mp-script']).on('change', onchange);

gulp.watch([
    'mobilepublic/assets/src/js/game/ssc/betgame.Games.SSC.js',
    'mobilepublic/assets/src/js/game/ssc/betgame.Games.SSC.config.js',
    'mobilepublic/assets/src/js/game/ssc/betgame.Games.SSC.Message.js',
    'mobilepublic/assets/src/js/game/ssc/betgame.Games.SSC.Danshi.js'
], ['mp-ssc-js']).on('change', onchange);
gulp.watch([
    'mobilepublic/assets/src/js/game/l115/betgame.Games.L115.js',
    'mobilepublic/assets/src/js/game/l115/betgame.Games.L115.config.js',
    'mobilepublic/assets/src/js/game/l115/betgame.Games.L115.Message.js',
     'mobilepublic/assets/src/js/game/l115/betgame.Games.L115.Danshi.js'
], ['mp-l115-js']).on('change', onchange);
gulp.watch([
    'mobilepublic/assets/src/js/game/k3/betgame.Games.K3.js',
    'mobilepublic/assets/src/js/game/k3/betgame.Games.K3.config.js',
    'mobilepublic/assets/src/js/game/k3/betgame.Games.K3.Message.js',
    'mobilepublic/assets/src/js/game/k3/betgame.Games.K3.Danshi.js'
], ['mp-k3-js']).on('change', onchange);
gulp.watch([
      'mobilepublic/assets/src/js/game/pk10/betgame.Games.PK10.js',
      'mobilepublic/assets/src/js/game/pk10/betgame.Games.PK10.config.js',
      'mobilepublic/assets/src/js/game/pk10/betgame.Games.PK10.Message.js',
      'mobilepublic/assets/src/js/game/pk10/betgame.Games.PK10.Danshi.js'
], ['mp-pk10-js']).on('change', onchange);

gulp.watch(['mobilepublic/assets/src/js/games/*.js'], ['mp-games-js']).on('change', onchange);
gulp.watch(['mobilepublic/assets/src/js/game/*/*.js'], ['mp-game-js']).on('change', onchange);
gulp.watch(['mobilepublic/assets/src/scss/*.scss'], ['mp-sass']).on('change', onchange);
gulp.watch(['mobilepublic/assets/src/images/svg/*.svg'], ['mp-svg']).on('change', onchange);

gulp.watch([
    'mobilepublic/assets/src/images/*',
    'mobilepublic/assets/src/images/*/*',
    'mobilepublic/assets/src/images/*/*/*',
    '!mobilepublic/assets/src/images/*/images',
    '!mobilepublic/assets/src/images/*/images/*',
    '!mobilepublic/assets/src/images/*/*/images'
], ['mp-images']).on('change', onchange);

gulp.task('mobile', [
    'mp-script',
    'mp-games-js',
    'mp-game-js',
    'mp-ssc-js',
    'mp-l115-js',
    'mp-k3-js',
    'mp-pk10-js',
    'mp-concat-js',
    'mp-concat-css',
    'mp-images',
    'mp-sass',
    'mp-svg'
]);


