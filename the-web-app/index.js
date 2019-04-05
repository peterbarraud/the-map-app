require('./src/styles/main.css');

// CSS Libs that are included with a simple require statement:
require("mini.css");
// require("dead-simple-grid-npm");
// require("flexboxgrid");
// require("normalize.css");
// require("pui-css-buttons");
// require("purecss");
// NOTE: These libs are not included in the package dependencies, so you're going to have to npm install them
// IMPORTANT:
// if you use external libs, you're going to have to set the browserify-css flag to -g in the start scriplt

require('./src/js/main');
