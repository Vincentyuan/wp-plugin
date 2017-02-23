var fs = require('fs');
var archiver = require('archiver');

var output = fs.createWriteStream('misysnews.zip');
var archive = archiver('zip');

output.on('close', function () {
    console.log(archive.pointer() + ' total bytes');
    console.log('plugin has been exported');
});

archive.on('error', function(err){
    throw err;
});

archive.pipe(output);

archive.directory("plugins/misysnews/","");
archive.finalize();
