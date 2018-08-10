while inotifywatch -e close_write ./;
do 
	php ./tokenize.php > file;
done