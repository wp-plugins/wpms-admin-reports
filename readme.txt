=== WPMS Admin Reports ===
Contributors: Cleanshooter
Tags: multisite, network, reports, wpms reports, admin reports
Requires at least: 3.4.1
Tested up to: 3.7.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WPMS Admin Reports is a reporting tool for Wordpress Multisite administrators.

== Description ==

WPMS Admin Reports is a reporting tool for Wordpress Multisite administrators.  It provides three reports and a dashboard that gives you a quick snapshot view of the health of your WordPress Multisite installation.  All of the tables are client-side sortable using jQuery and tablesorter.  It includes graphical indicators (smiley faces) to help easily identify problem sites, users and plugins.  

**Dashboard** - provides charts that display multiple factors from the other three reports in a graphical way by using radar and pie charts.

**Site Report** - gives you detailed information about each site in your installation.  It can automatically check all of your sites to see if they are displaying errors or functioning correctly.  The table contains the following information; ID, Status (Up/Down), Last Post, Last Update, When Created, Current Template, Number of Users and lists the Primary Administrator.

**User Report** - provides detailed information about each user in your installation.  This plugin also captures when your users login.  The table contains the following information; ID, Username, Name, Email, Last Login, Last IP Address, when Registered, number of Sites and a list of each site as well as the users roll on that corresponding site.  The report is especially handy if you need to audit your users.

**Plugin Report** - lists all installed plugins and provides information about each one.  This plugin will check multiple sources to indicate how trust worthy a plugin is.  The table contains the following information; Name, Upgradeability, Status, Activation Site-wide, Total Number of Blogs that use it and a list of those blogs.  

The plugin has detailed help tabs that throughly explain the details of each report.

**Development**

* Repo: [GitHub](https://github.com/cleanshooter/wpms_admin_reports)
* Issues: [Tracker](https://github.com/cleanshooter/wpms_admin_reports/issues)

**Credits, Thanks and Inspiration**

*Plugin Stats (Original Version)*

* Kevin Graeme
* Deanna Schneider
* Jason Lemahieu

*[IcoMoon](http://icomoon.io/)* - for making great icons.

*[Chart.js](http://www.chartjs.org/)* - for making beautiful charts.

*[tablesorter](http://tablesorter.com/docs/)* - for removing the need to refresh for table pagination.

*[jQuery](http://jquery.com/)* - for being awsome.

*Wordpress Last Login* - showed one way to store "last login" information.

== Installation ==

1. Place the wpms_admin_reports.php file and wpms_admin_reports folder in the wp-content/mu-plugins folder.
1. Login as a network admin and visit the network admin dashboard.

== Screenshots ==

1. Dashboard
2. Site Report
3. User Report
4. Plugin Report
5. Help Tab

== Changelog ==

= 1.0 =
* The Initial Release