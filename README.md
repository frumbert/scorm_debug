Scorm Test Environment
----------------------

Say you have a bunch of SCORM packages which are zip files and you regularly need to test them but don't want to have to put them into your LMS. You might need to try them using a Scorm 1.2 or a Scorm 2004 runtime, or both.

This utilty scans the current folder for zip files and extracts them. It looks inside each folder for an imsmanifest.xml file. It looks inside that file to find the course homepage and gives you links to this file using a scorm runtime wrapper link for both 1.2 and 2004.

The scorm 1.2 harness is based on Moodle 2.6(ish, with hax) and has buttons to simulate unloading and loading.

The scorm 2004 harness is Claude Ostyn's handy all-in-one debugger (© 2007 Ostyn Consulting, www.ostyn.com/standards/scorm/samples/scorm2004testwrap.htm) 

##Setup

Put this in a folder that your web server can write to (as it extracts files).

If you're running PHP7.0 you might need to

    sudo apt-get install php7.0-xml
    sudo apt-get install php7.0-zip

You can run a PHP web server like this

	cd (the-folder)
	php -S localhost:8080

... and now hit up http://localhost:8080 and you can see the files

##License(s)

GPL2 for moodle hacked wrapper
CC Attribution-ShareAlike2.5 License for scorm2004 wrapper
MIT for index.php
