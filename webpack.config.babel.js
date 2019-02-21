import path from 'path';
import CleanWebpackPlugin from 'clean-webpack-plugin';

export default {
  entry: './lazyload.js',
  output: {
    path: path.resolve(__dirname, 'build'),
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
  plugins: [
    new CleanWebpackPlugin('build'),
  ],
}
