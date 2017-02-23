if [ $# -eq 0 ]
  then
    echo "-s means setup -e means export -a means setup and export"
fi

if [ $1 -eq "-s" ]||[ $1 -eq "-a" ];
  then 
	npm install -g bower
	npm install archiver
	npm install
	bower install
	grunt buildwp
fi

if [ $1 -eq "-a" ] || [ $1 -eq "-e" ];
  then 
	node pluginArchiver.js -a
fi
