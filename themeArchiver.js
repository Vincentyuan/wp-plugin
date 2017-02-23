var fs = require('fs');
var archiver = require('archiver');

var output = fs.createWriteStream('misysnewstheme.zip');
var archive = archiver('zip');

output.on('close', function () {
    console.log(archive.pointer() + ' total bytes');
    console.log('theme has been exported');
});

archive.on('error', function(err){
    throw err;
});

archive.pipe(output);

archive.directory("themes/misysnews/","");
archive.finalize();
