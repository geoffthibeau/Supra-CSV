=== Supra CSV Importer ===
Contributors: zmijevik
Author URI: http://profiles.wordpress.org/zmijevik
Donate link:
Tags: Csv Importer , Csv Parser , Csv Injector , Custom Post
Requires at least: 3.2.1
Tested up to: 3.2.1
Stable tag: 2.5.7

The purpose of this plugin is to parse uploaded csv files into any type of
post.

== Description ==

The purpose of this plugin is to parse uploaded csv files into any type of
post.Some themes or plugin store data in post with custom post_type, thus this
plugin provides the functionality to upload data from the csv file to the records
that the theme or plugin creates. Manage existing csv files and promote ease of use
by creating presets for both postmeta and ingestion mapping. For more infomation
on how to obtain the necessary info watch the detailed tutorial. 

[youtube http://www.youtube.com/watch?v=0xKpNw1cT-Q]

== Installation ==


== Frequently Asked Questions ==

This plugin comes with a video tutorial which will answer all your questions.

== Screenshots ==

== Changelog ==

= 2.2 =
Added the post meta suggestions and post type picker functioanlity
= 2.3 = 
updated the youtube video
= 2.3.1 = 
updated mime type validation per user request
= 2.3.2 =
fixed a javscript bug of missing key
= 2.3.3 =
added the categories and tags import functionality per user request
= 2.3.4 =
added the ability to provide multiple tags and categories for each post
= 2.3.5 =  
revised uploadcsv fopen to use file access instead to prevent chaning php.ini
= 2.3.6 =
added the ability to provide category ids instead of names per user request
= 2.3.9 =
storing uploads outside of plugin direcotry to prevent file deletion during updates
= 2.4 =
created the term taxonomy import functionality per user request
= 2.4.1 =
overhauled xmlrpc script to allow ingestion of hidden and protected postmeta
= 2.4.3 =
trigger the change event after mappring preset modification and creation
= 2.4.5 = 
subcategory import functionality and absent postmeta mapping bug fix
= 2.4.7 = 
created the ingestion debugger and fixed the complex category ingestion bug
= 2.4.8 =
validating taxonomy based on selected posttype
= 2.5.1 = 
added paypal donate button and more info about the plugin
= 2.5.6 =
added delimiter,enclosure, escape settings for parsing the csv
