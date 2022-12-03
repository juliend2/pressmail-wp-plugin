# development of the plugin

## for each version to release on wordpress.org/plugins/pressmail:

1. Bump the version in pressmail.php PRESSMAIL_VERSION constant
1. Bump the version in pressmail.php header' `Version` comment
1. Bump the version in README.txt `Stable tag:` part
1. `make svn`, this will put the files in the svn local repo
1. cd into that (`DEST`) directory
1. add a new tag for the version:
    1. modify the `trunk/readme.txt` accordingly
    1. create the new `tag/<version>` folder
1. do the commands for commiting to svn (go there for help https://developer.wordpress.org/plugins/wordpress-org/how-to-use-subversion/ )
