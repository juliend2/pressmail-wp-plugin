DEST=/var/www/html/wordpress/wp-content/plugins/

default:
	sudo cp -r ./pressmail $(DEST)
	sudo chown -R www-data:www-data $(DEST)