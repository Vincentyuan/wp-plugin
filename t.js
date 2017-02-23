
function zipDir(dir,destName){

var fs = require('fs');
var archiver = require('archiver');

var output = fs.createWriteStream(destName);
var archive = archiver('zip');

output.on('close', function () {
    console.log(archive.pointer() + ' total bytes');
    console.log('"'+dir+'" has been exported');
});

archive.on('error', function(err){
    throw err;
});

archive.pipe(output);

archive.directory(dir,"");
archive.finalize();
}

var arglength = process.argv.length;
if(arglength == 3){
	if(process.argv[2] == '-p'){
		zipDir("plugins/misysnews/","misysnewsplugin.zip");
	}	
	if(process.argv[2] == '-t'){
		zipDir("themes/misysnews/","misysnewstheme.zip");
	}
	if(process.argv[2] == '-a'){
		zipDir("plugins/misysnews/","misysnewsplugin.zip");
		zipDir("themes/misysnews/","misysnewstheme.zip");
	}
}else{
	console.log("-a means all -p means plugin -t means themes");
}
