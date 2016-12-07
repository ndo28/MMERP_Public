1. Precondition- complete the steps from iteration 1
2. Navigate nrs-projects.humboldt.edu/~mmerp/mmerp.php
3. Log in with the following information:
	Username: st10
	Password: root

File list:

front_end
	mmerp.php - Main PHP to access all other pages

	update_report.php - updates the a users report with the beach

	make_new_report.php - creates a report number

	main_menu.php - contains the main menu for the applications

	get_user_inits.php - generates the current users initials

	get_report_info.php - contains the database query to pull the report information

	get_report_id.php - generates a report id for a new reports

	create_surveyors.php - pulls a list of surveyors from the database

	map.php - contains function to create map

	admin_menu.php - admin console to manage the application

	name-pwd-fieldset.html - contains form to login

	make_report_menu.php - prompts user to continue an existing report or make a new report

	hsu_conn_sess.php - contains connection string to access the database

	custom_login_9.php - form to log in to the web application

	328footer-better.html - footer to validate the web page

	create_report_entry.php - Inserts new entries into database

	create_report_summary.php - Displays a summary of the submitted report to the user.

	display_existing_report_info.php - Displays the information in an existing report.

	display_existing_report_info_beach.php - Displays the information in an existing report sorted by beach.

	display_existing_report_info_species.php - Displays the information in an existing report sorted by species.

	display_existing_report_info.php_user - Displays the information in an existing report sorted by user.

	entry_recap.php - Displays a recap of the entry info, and allows the user to add a comment.

	fix_date.php - Reformats the date from a string into the correct format for PRN

	get_PRN.php - Creates a PRN for a new report

	get_beach_abbr.php - Stores the beach abbreviation from the database into the session array

	get_report_date.php - Stores the report date from the database into the session array.

	get_report_entry_info.php - Allows user to select information about beach.

	get_second_user.php - Stores second user from database into the session array.

	name-pwd-fieldset.html - a fieldset in which the user can enter their username and password.

	report_recap.php - Dispays a recap of report information to the user

	report_summary.php - A page that allows the user to enter an (optional) survey summary.

	user_reports_dropdown.php - Creates a dropdown of current reports for the user to choose from.

	validate_user.php - determines whether the current user is an admin or a surveyor.

	view_reports.php - generates a table of existing reports.

	view_reports_by_beach.php - generates a table of reports that have been made at a given beach

	view_reports_by_user.php - generates a table of reports that have been made by a given user

	create_new_user_entry.php - generates a form for the admin to enter a new HSU username for adding a user.

	edit_existing_user.php - queries the database for user info, and creates a menu
													 with which an admin can change user info.

	edit_existing_user_recap.php - displays a recap of the user info edited in edit_existing_user_info.php

	edit_new_user.php - creates a page from which an admin can edit a new users' information.

	edit_user_create_initials - generates user initials from first and last name.

	is_new_user.php - determines if a new user already exists in the database, and if not,
										inserts the user into the database.

	mmerp_login.php - generates the login screen for the application.

	photo_upload.php - contains the (currently broken/disabled)	code to upload photos to
								     a report.

	select_user_dropdown.php - creates a dropdown from which someone can select a user.

	

project_files
	project_tables.sql - This .sql file will create the database tables

	project_population.sql - This .sql file will populate the database

	project_db_test.sql - This .sql file will run queries on the
	                   databases to demonstrate functionality of database.

	project-tables-out.txt - This will show spooled output from
	                         project-tables.sql.

	project-population-out.txt - This will show spooled output from
	                         project-populations.sql.

	project-db-test.txt - this will show spooled output project_db_test.sql,
                      	along with the expected output.
