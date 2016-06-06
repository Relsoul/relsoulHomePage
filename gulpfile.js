'use strict';

const gulp=require("gulp");
const sass=require("gulp-sass");
const webpack=require("gulp-webpack");
const livereload=require("gulp-livereload");
const gulpif = require('gulp-if');
const sprity=require("sprity");
const rename=require("gulp-rename");
const sourcemaps = require('gulp-sourcemaps');
//const nodemon=require("gulp-nodemon");

gulp.task("default",["watch"]);

gulp.task("watch",function(){
    livereload.listen();
    gulp.watch("front-dev/sass/**/*.scss",["sass:compile"]);
    gulp.watch(["front-dev/vue/**/*.js","front-dev/vue/**/*.vue"],["webpack:compipe"]);
    gulp.watch(["front-dev/*.html"],["copy"]);
    gulp.watch(["front-dev/img/*.*"],["copy"]);
});

gulp.task("build:file",function () {
    gulp.src("node_modules/materialize-css/dist/**/*.*").pipe(gulp.dest("front-dev/lib/materialize"));
    gulp.src("node_modules/jquery/dist/jquery.min.js").pipe(gulp.dest("front-dev/lib/"));
    gulp.src("node_modules/jquery/dist/jquery.min.js").pipe(gulp.dest("front-dev/lib/"));
    gulp.src("node_modules/markdown/lib/markdown.js").pipe(gulp.dest("front-dev/lib/"))
});

gulp.task("copy",function(){
    //img copy
    gulp.src("front-dev/img/**/*.*").pipe(gulp.dest("./public/img"));
    //lib copy
    gulp.src("front-dev/lib/**/*.*").pipe(gulp.dest("./public/lib"));
    //html copy
    gulp.src("front-dev/*.html")

        .pipe(rename(function(path){
            path.extname=".blade.php"
        }))
        .pipe(gulp.dest("./resources/views"))
});

gulp.task("sass:compile",function(){
    gulp.src("front-dev/sass/main.scss")
        .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(sourcemaps.write("/"))
        .pipe(gulp.dest('public/css'))
        .pipe(livereload());
});

gulp.task("webpack:compipe",function() {
    gulp.src("front-dev/vue/main.js")
        .pipe(webpack(require("./webpack.config.js")))
        .pipe(gulp.dest("public/js/"))
        .pipe(livereload())
});

gulp.task("spriter",function(cb){
    sprity.src({
        src:"./front-dev/slice/*.png",
        style:"./slice.scss",
        processor:"sass",
        "style-type":"scss"
    }).pipe(gulpif("*.png",gulp.dest("./public/img"),gulp.dest("./front-dev/sass/sprite-sass")));

});