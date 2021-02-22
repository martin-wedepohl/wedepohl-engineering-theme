const { src, dest, watch, series, parallel } = require("gulp");
const autoprefixer = require("gulp-autoprefixer");
const browserSync = require("browser-sync").create();
const csso = require("gulp-csso");
const del = require("del");
const mode = require("gulp-mode")();
const rename = require("gulp-rename");
const sass = require("gulp-dart-sass");
const sourcemaps = require("gulp-sourcemaps");
const browserify = require("browserify");
const babelify = require("babelify");
const source = require("vinyl-source-stream");
const buffer = require("vinyl-buffer");
const terser = require("gulp-terser");
const imagemin = require("gulp-imagemin");

/**
 * Directories and files
 */
const srcBase = "./src";
const srcStylePath = srcBase + "/scss";
const srcScriptPath = srcBase + "/js";
const srcImgPath = srcBase + "/img";

const distBase = "../../wp-content/themes/wedepohl-engineering";
const distStylePath = distBase + "/dist/css";
const distScriptPath = "js/";
const distImgPath = distBase + "/dist/img";

const styleFiles = srcStylePath + "/**/*.scss";
const scriptFiles = srcScriptPath + "/**/*.js";
const imgFiles = srcImgPath + "/**/*";
const styleCss = srcBase + "/style.css";
const rootFiles = srcBase + "/**/*.php";
const licenseFile = "./license.txt";
const vendor = srcBase + "/vendor";

const indexJsFile = "/script.js";
const customizerJsFile = "/customizer.js";
const jsFiles = [indexJsFile, customizerJsFile];

// clean tasks
const clean = () => del([distBase], {force: true});

// copy tasks
const copyRoot = () => {
    src(rootFiles)
		.pipe(dest(distBase));
	src(styleCss)
		.pipe(dest(distBase));
	src(vendor)
		.pipe(dest(distBase));
	return src(licenseFile)
		.pipe(dest(distBase));
}

const copyIndex = () => {
    return src("./index.php")
        .pipe(dest(distBase + "/dist"))
        .pipe(dest(distBase + "/dist/css"))
        .pipe(dest(distBase + "/dist/js"))
        .pipe(dest(distBase + "/dist/img"))
}

// css task
const css = () => {
    return src(styleFiles)
        .pipe(mode.development(sourcemaps.init({loadMaps: true})))
        .pipe(sass().on("error", sass.logError))
        .pipe(autoprefixer())
        .pipe(
            rename(({ dirname, basename, extname }) => {
                return {
                    dirname,
                    basename: `${basename}.min`,
                    extname
                }
            })
        )
        .pipe(mode.production(csso()))
        .pipe(mode.development(sourcemaps.write('.')))
        .pipe(dest(distStylePath))
        .pipe(browserSync.reload({
            stream: true
        }));
}

// js task
const js = (done) => {
    jsFiles.map( entry => {
        return browserify({
            entries: [srcScriptPath + entry]
        })
        .transform(
			babelify, {
				"presets": [
					'@babel/preset-env',
					'@babel/preset-react'
				]
			}
		)
        .bundle()
        .pipe( source( entry ) )
        .pipe(
            rename(({ basename, extname }) => {
                return {
                    dirname: distScriptPath,
                    basename: `${basename}.min`,
                    extname
                }
            })
        )
        .pipe( buffer() )
        .pipe( mode.development( sourcemaps.init( {loadMaps: true} ) ) )
        .pipe( mode.production( terser() ) )
        .pipe(mode.development( sourcemaps.write('.', {includeContent: false, sourceRoot: '.' } ) ) )
        .pipe(dest(distBase + "/dist"));
    });
    done();
}

const minifyImgs = () => {
	return src(imgFiles)
		.pipe(imagemin())
		.pipe(dest(distImgPath));
}

// watch task
const watchForChanges = () => {

    browserSync.init({
        proxy: {
            target: "http://spyglass-hitek.local"
        }
    });

    watch(styleFiles, css);
    watch(scriptFiles, js).on("change", browserSync.reload);
	watch(imgFiles, minifyImgs).on("change", browserSync.reload);
    watch(rootFiles, copyRoot).on("change", browserSync.reload);

    return console.log("Gulp is watching ....");
}

// public tasks
exports.clean = clean
exports.copyRoot = copyRoot;
exports.copyIndex = copyIndex;
exports.minifyImgs = minifyImgs;
exports.css = css
exports.js = js
exports.build = series(clean, copyRoot, copyIndex, minifyImgs, parallel(css, js));
exports.default = series(clean, copyRoot, copyIndex, minifyImgs, parallel(css, js), watchForChanges);