--Rebecca Williams
--Nathan Ortolan
--Guthrie Hayward
--Abdul Shaikh
<<<<<<< HEAD
--CS 458 - Fall 2016
--modified: 2016-10-09 by rjw125
--modified: 2016-10-09 by ndo28
--modified: 2016-10-10 by ats234
--modified: 2016-10-12 by gmh234
--modified: 2016-10-12 by ndo28
--modified: 2016-10-12 by ats234

=======
-- CS 458 - Fall 2016
-- last modified: 2016-10-12
>>>>>>> 7e04f64b283dd2ccec362132df7b8c133760eda0

spool project-design-out.txt

/*
  Table name: beach
  Table contents: names and abbreviations of
  beaches covered by MMERP.
*/
drop table Beaches cascade constraints;
create table Beaches
  (
    beach_abbr varchar(4), --Beach abbreviation
    beach_name varchar(45), -- Beach name or description (Based on the data sheet document)
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
    spec_abbr varchar(4), --Species abbreviation
    spec_name varchar(30), -- Species name or description (Based on the data sheet document)
    primary key (spec_abbr)
  );



--============================================================
-- Users Table
-- Determined by a user name (admin or surveyor)
-- user_name : admin if Administrator login, surveyor if Surveyor login

drop table Users cascade constraints;

create table Users
(
	user_name			                    varchar2 check(user_name in ('admin', 'surveyor')) not null,
	password                          varchar2 not null,
	primary key (menu_id)
);


--============================================================
-- Admins
-- Determined by a 2-digit admin id
-- admin_id : 2-digit id determined by sequence admin_seq
drop table Admins cascade constraints;

create table Admins
(
	admin_id			                   integer(2) not null,
  admin_lname                      varchar2 not null,
  admin_fname                      varchar2 not null,
  admin_email                      varchar2 not null,
  --admin_phone                    --integer(10)???,
  user_name                        varchar2,
	primary key (admin_id),
  foreign key (user_name) references Users
);


--============================================================
-- Surveyors
-- Determined by a 3-digit surveyor id
-- surv_id : 3-digit id determined by sequene surveyor_seq

drop table Surveyors cascade constraints;

create table Surveyors
(
	surv_id			                   integer(3) not null,
  surv_lname                     varchar2 not null,
  surv_fname                     varchar2 not null,
  surv_email                     varchar2 not null,
  --surv_phone                   --integer(10)???,
  user_name                      varchar2,
	primary key (surv_id),
  foreign key (user_name) references Users
);




--============================================================
--Reports table => purpose: to track important information about
--     beach walks.
--     Special domain notes:  'time' default format  hh:mm[:ss]

drop table Reports cascade constraints;

create table Reports
(report_id                      integer(5) not null,
 report_date			              date default sysdate not null,
 start_time                     time not null,
 end_time                       time,
 beach_abbr                     char(4),
 survey_summary                 long varchar2,
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
(PRN				                    varchar(30) not null,
 surveyor_id                    varchar(7),
 report_id                      integer(5),
 species_abbr			              char(4),
 LAT                            decimal(7,2),
 LONG                           decimal(7,2),
 post_survey_tag                char(1),
 existing_tags                  char(1),
 photos                         char(1),
 comments                       long varchar2,
 photos_uploaded                varchar2(256), -- should this be a link to a photo album?
 no_of_animals                  integer(2),
 primary key (PRN),
 foreign key (species_abbr) references Species,
 foreign key (surveyor_id) references Surveyor,
 foreign key (report_id) references Reports
);


--============================================================
-- Reporters
-- Surveyors act as Reporters while completing reports
-- Determined by a 3-digit surveyor id and a 5-digit report_id
-- surveyor email and phone will be selected from the Surveyor table by reference

drop table Reporters cascade constraints;

create table Reporters
(
  surv_id                       integer(3),
  report_id                     integer(5),
	primary key (surv_id, report_id),
  foreign key (surv_id) references Surveyors,
  foreign key (report_id) references Reports
);


drop sequence report_seq;
create sequence report_seq
start with 1000;


spool off
