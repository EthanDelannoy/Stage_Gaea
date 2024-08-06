const path = require('path');

module.exports = {
  mode: 'development', 
  entry: './public/index.php', 
  output: {
    filename: 'bundle.js',
    path: path.resolve(__dirname, 'dist')
  },
  resolve: {
    extensions: ['.js', '.json', '.php']
  },
  module: {
    rules: [
      {
        test: /\.php$/,
        use: 'raw-loader'
      }
    ]
  }
};