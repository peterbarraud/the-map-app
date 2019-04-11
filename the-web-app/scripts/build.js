var fs = require('fs');

// for testing:- restbaseurl: 'http://10.41.123.121:8089/services/rest.api.php/',
// for dev:- restbaseurl: 'http://localhost:8089/services/rest.api.php/',
var setenv = function(env){
    fs.readFile('build/index.js', function(err, buf) {
        const replaceString = require('replace-string');
        const updated_js = replaceString(buf.toString(), 'localhost:8089', '10.41.123.121:8089');
        fs.writeFile('build/index.js', updated_js, function(err) {
            if(err) {
                return console.log(err);
            } else {
                console.log('Done: Building index.js');
            }        
        }); 
    });
}
var buildJS = function(){

    console.log('Building index.js');
    var indexjs = fs.createWriteStream('build/index.js');
    require('browserify')()
        .add('./src/js/main.js')
        .transform("babelify", {presets: ["@babel/preset-env", "@babel/preset-react"], plugins: ["@babel/plugin-proposal-class-properties"]})
        .transform('uglifyify', { global: true  })
        .bundle()
        .on('error', function (error) {
            console.error(error.toString());
        })
        .pipe(indexjs);
        indexjs.on('finish', function(){
            setenv('test');
        })
};

var buildCSS = function(){
    console.log('Building index.css');
    require('browserify')()
    .add('index.js')
    .transform("babelify", {presets: ["@babel/preset-env", "@babel/preset-react"], plugins: ["@babel/plugin-proposal-class-properties"]})
    .transform(require('browserify-css'), {
        global:true,
        "minify": true,
        onFlush: function(options, done) {
            fs.appendFileSync('build/index.css', options.data);
            // Do not embed CSS into a JavaScript bundle
            done(null);
        }
    })
    .bundle();    
    
}

console.log("using rimraf just to first we clean out the entire build dir");
require('rimraf')('build', function(){
    console.log("re-make the build folder from scratch");
    require('mkdirp')('build', function (err) {
        if (err) {
            console.error(err);
        } else {
            console.log("build the index.js");
            buildJS();
            console.log("build the index.css");            
            buildCSS();
        }
    });  
});
