Web Project
=================

This project was created as sample code by Radek Chalupa.


Installation
------------

To install this project on your local machine / web server, you need to follow few simple steps.

<b>Step 1.</b> Vendor - Composer install

Run command in your command line to generate vendor with all required files

	composer install


<b>Step 2.</b> Create directories `temp/` and `log/` with correct CHMOD 775.

<b>Step 3.</b> Import `db-structure.sql` in root to your MySQL

<b>Step 4.</b> Setup your MySQL credentials in `app\config\common.neon` file


Features - improvements
----------------
<b>UserPanel</b>

UserPanel currently have only 3 features so I created one file with (Create Article, Change Password, Login).
If there was more features, first improvement would be definitelly to separate each function to different 
component.

<b>Registration</b>

Currently, theres only simple input to create registration in my system (Login, Password).
In complex web-project should be improved registration form on separate page with several features:

Registration e-mail: To validate user, you could for example setup some mail client which sends validation
e-mail to user with link to click. This link would contain unique generated token (username + salt for example).

Honeypot (or other anti-bot system like Google verification): To block bot registrations

<b>Like system</b>

Each Article could have like/dislike system. This could be achieved with extra table in our database
that tracks likes/dislikes from users - so we can monitor, if user already gave like/dislike to certain article.

<b>Permissions system / Role system</b>

To separate users which can create articles for example or simply guests, who can only like/dislike articles.
 For this change, we need extra table `roles` for example where we would track all user roles (could be
 given only by administrator in userManager).
 
<b>UserManager</b>
 
Helps to maintain user roles/permissions. This would be extra component (as described above in UserPanel).

<b>FilterManager</b>

Feature could help filter articles by date/subject/likes or dislikes. All Article queries would have addional
`$where` condition - if there's no filter selected, then `$where` would be empty array. After selection of filter
condition `$where` would be filled with condition for example `ORDER BY system_created ASC` and applicated for all queries
in `newsRepository`.