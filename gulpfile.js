const { src, dest, series, watch } = require('gulp')
const concat = require('gulp-concat')
const htmlMin = require('gulp-htmlmin')
const sass = require('gulp-sass')(require('sass'));
const autoprefixes = require('gulp-autoprefixer')
const cleanСss = require('gulp-clean-css')
const svgSprite = require('gulp-svg-sprite')
const image = require('gulp-image')
const webp = require('gulp-webp')
const babel = require('gulp-babel')
const uglify = require('gulp-uglify-es').default
const notify = require('gulp-notify')
const sourcemaps = require('gulp-sourcemaps')
const del = require('del')
const browserSync = require('browser-sync').create()

const clean = () =>{
    return del(['dist'])
}

const resources = () =>{
    return src('src/resources/**')
    .pipe(dest('dist'))
}

const fonts = () => {
    return src(
    [
        'src/fonts/*.woff2',
        'src/fonts/*.woff'
    ]    
    )
    .pipe(dest('dist/fonts'))
}

const styles = () => {
    return src('src/css/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(concat('main.css'))
        .pipe(autoprefixes({
            cascade: false
        }))
        .pipe(cleanСss({
            level: 2
        } ))
        .pipe(sourcemaps.write())
        .pipe(dest('dist'))
        .pipe(browserSync.stream())
}

const htmlMinify = () =>{
    return src('src/**/*.html')
        .pipe(htmlMin({
            collapseWhitespace: true,
        }))
        .pipe(dest('dist'))
        .pipe(browserSync.stream())
}

const images = () => {
    return src(
    [
        'src/img/**/*.png',
        'src/img/*.svg'
    ]    
    )
    .pipe(image())
    .pipe(dest('dist/images'))
}

const toWebp = () => {
    return src (
    [
        'src/img/**/*.jpg',
        'src/img/**/*.jpeg'
    ]
    )
    .pipe(webp({quality: 75}))
    .pipe(dest('dist/images'))
}

const svgSprites = () => {
    return src('src/img/svg/**/*.svg')
        .pipe(svgSprite({
            mode:{
                stack:{
                    sprite: '../sprite.svg'
                }
            }
        }))
        .pipe(dest('dist/images'))
}


const scripts = () => {
    return src(
    [ 
        'src/js/*.js'
    ]    
    )
    .pipe(sourcemaps.init())
    .pipe(babel({
        presets: ['@babel/env']
    }))
    .pipe(concat('app.js'))
    .pipe(uglify().on('error', notify.onError()))
    .pipe(sourcemaps.write())
    .pipe(dest('dist'))
    .pipe(browserSync.stream())
}

const watchFiles = () => {
    browserSync.init({
        server: {
            baseDir: 'dist'
        }
    })

}

watch('src/**/*.html', htmlMinify)
watch('src/css/**/*.scss', styles)
watch('src/img/svg/**/*.svg', svgSprites)
watch('src/js/**/*.js', scripts)
watch('src/resources/**', resources)

exports.styles = styles
exports.scripts = scripts
exports.htmlMinify = htmlMinify
exports.default = series(clean, resources, fonts, htmlMinify, scripts, styles, svgSprites, images, toWebp, watchFiles)