--Rebecca Williams
--Nathan Ortolan
--Guthrie Hayward
--Abdul Shaikh
-- CS 458 - Fall 2016
--modified: 2016-10-09 by rjw125
--modified: 2016-10-09 by ndo28
--modified: 2016-10-10 by ats234
--modified: 2016-10-12 by gmh234
--modified: 2016-10-12 by ndo28
--modified: 2016-10-12 by ats234
--modified: 2016-10-14 by ndo28 and rjw125(pair programming)
--modified: 2016-11-25 by rjw125

spool project-tables-out.txt

drop sequence report_id_seq;
commit;

/*
  Table name: beach
  Table contents: names and abbreviations of
  beaches covered by MMERP.
*/
drop table Beaches cascade constraints;
create table Beaches
(
    beach_abbr                  char(2) not null, --Beach abbreviation
    beach_name                  varchar2(45) not null, -- Beach name or description (Based on the data sheet document)
    primary key (beach_abbr)
);

/*
  Table name: species
  Table contents: names and abbreviations of
  species covered by MMERP.
*/
drop table Species cascade constraints;
create table Species
(
    spec_abbr                  char(4) not null, --Species abbreviation
    spec_name                  varchar2(30) not null, -- Species name or description (Based on the data sheet document)
    primary key (spec_abbr)
);



--============================================================
-- Users Table
-- Determined by a user name (admin or surveyor)
-- user_name : admin if Administrator login, surveyor if Surveyor login

drop table Users cascade constraints;

create table Users
(
	hsu_username			                varchar2(7) not null,
  user_initials                     char(2) not null,
  user_lname                        varchar2(30) not null,
  user_fname                        varchar2(20) not null,
  user_email                        varchar2(45) not null,
	password                          varchar2(30) not null,
  is_admin                          char(1) check(is_admin in('Y', 'N')) not null,
  is_surveyor                       char(1) check(is_surveyor in('Y', 'N')) not null,
	primary key (hsu_username)
);

--============================================================
--Reports table => purpose: to track important information about
--     beach walks.
--     Special domain notes:  'time' default format  hh:mm[:ss]

drop table Reports cascade constraints;

create table Reports
(report_id                      number(5,0) not null,
 start_time                     char(5) not null,
 end_time                       char(5),
 report_date                    date,
 beach_abbr                     char(2),
 survey_summary                 long,
 primary key (report_id),
 foreign key (beach_abbr) references Beaches
 );


--============================================================
--Report_entries table => purpose: to track important information about
--     each animal contact.
--     Special domain notes: post_survey_tag, existing_tags, photos
--                      are Y/N fields


Drop table Report_entries cascade constraints;

create table Report_entries
(PRN				                    varchar2(30) not null,
 hsu_username                   varchar2(7) not null,
 report_id                      number(5,0) not null,
 species_abbr			              char(4) not null,
 LATITUDE                       decimal(9,6), --Need to look at Maps API return format
 LONGITUDE                      decimal(9,6), --Need to look at Maps API return format
 post_survey_tag                char(1) check(post_survey_tag in('y', 'n')) not null,
 existing_tags                  char(1) check(existing_tags in('y', 'n')) not null,
 photos                         char(1) check(photos in('y', 'n')) not null,
 comments                       long,
 photos_uploaded                varchar2(256), -- should this be a link to a photo album?
 no_of_animals                  number(2,0) not null,
 primary key (PRN),
 foreign key (species_abbr) references Species,
 foreign key (hsu_username) references Users,
 foreign key (report_id) references Reports
);


--============================================================
-- Surveyors
-- Users act as Surveyors while completing reports
-- Determined by a 3-digit surveyor id and a 5-digit report_id
-- surveyor email and phone will be selected from the Surveyor table by reference

drop table Surveyors cascade constraints;

create table Surveyors
(
  hsu_username                  varchar2(7) not null,
  report_id                     number(5,0) not null,
	primary key (hsu_username, report_id),
  foreign key (hsu_username) references Users,
  foreign key (report_id) references Reports
);


create sequence report_id_seq
start with 10010
nocache;

spool off
