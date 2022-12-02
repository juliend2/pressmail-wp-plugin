DEST=/home/julien/Workbench/pressmail/wp-site/wp-content/pressmail-wp-plugin/

# default:
# 	sudo chown -R www-data:www-data ./trunk

svn:
	cp -r ./trunk/* $(DEST)trunk/
	cp -r ./assets/* $(DEST)assets/
