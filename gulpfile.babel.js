import gulp from 'gulp';
import gulpif from 'gulp-if';
import webpack from 'webpack';
import del from 'delete';
import through from 'through2';
import path from 'path';
import program from 'commander';
import pkg from './package.json';
import fs from 'fs';

program
  .version(pkg.version)
  .option('-o, --output [path]', 'Output folder', '')
  .parse(process.argv);

const config = mode => ({
  mode,
  entry: path.resolve(__dirname, 'src/lazyload.js'),
  output: {
    path: path.resolve(__dirname, 'dist/trunk'),
    filename: 'lazyload.[hash:8].min.js',
  },
  module: {
    rules: [
      {
          test: /\.js$/,
          exclude: /node_modules/,
          loader: 'babel-loader',
      },
    ],
  },
});

const addWPVersion = (options) => through.obj((file, enc, next) => {
  const content = file.contents.toString('utf-8').replace(/Version:\s+\S+/, `Version: ${pkg.version}`);
  file.contents = Buffer.from(content);
  next(null, file);
});

const isFile = filename => file => file.relative === filename;

const clean = () => new Promise(resolve => del(['dist/trunk'], (err, deleted) => {
  if (err) throw err;
  resolve();
}));

const bundle = mode => () => new Promise(resolve => webpack(config(mode), (err, stats) => {
  if (err) throw err;
  resolve();
}));

const copy = () => gulp.src(['src/**/*.txt', 'src/**/*.php'])
  .pipe(gulpif(isFile('wp-accelerate.php'), addWPVersion()))
  .pipe(gulp.dest('dist/trunk'));

const copyToFolder = () => new Promise(resolve => {
  if (!!program.output) {
    del.sync(program.output, { force: true });
    fs.mkdirSync(program.output, { recursive: true });
    resolve(gulp.src('dist/trunk/**/*.*').pipe(gulp.dest(program.output)));
  } else {
    resolve();
  };
})

const watchJs = () => gulp.watch('src/**\/*.js', gulp.series(
  clean,
  bundle('development'),
  copy,
  copyToFolder,
));

const watchPhp = () => gulp.watch('src/**\/*.php', gulp.series(
  copy,
  copyToFolder,
));

export const start = gulp.series(
  clean,
  bundle('development'),
  copy,
  copyToFolder,
  gulp.parallel(
    watchJs,
    watchPhp,
  ),
);

export const build = gulp.series(
  clean,
  bundle('production'),
  copy,
  copyToFolder,
);
