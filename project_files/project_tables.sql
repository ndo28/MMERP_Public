--Rebecca Williams
--Nathan Ortolan
--Guthrie Hayward
--Abdul Shaikh
-- CS 458 - Fall 2016
-- last modified: 2016-10-08

spool project-design-out.txt


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
 end_time                       time not null,
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


drop table Report_entries cascade constraints;

create table Report_entries
(PRN				                    varchar(30) not null,
 surv_id                        integer(3),
 report_id                      integer(5),
 species_abbr			              char(4),
 LAT                            decimal(7,2),
 LONG                           decimal(7,2),
 post_survey_tag                char(1),
 existing_tags                  char(1),
 photos                         char(1),
 comments                       long varchar2,
 photos_uploaded                varchar2,
 no_of_animals                  integer(2),
 primary key (PRN),
 foreign key (species_abbr) references Species,
 foreign key (surv_id) references Surveyors,
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




--============================================================
-- Sequences

-- admin_seq
-- Sequence for admin ids
drop sequence admin_seq;
create sequence admin_seq
start with 1;

-- surveyor_seq
-- Sequence for surveyor ids
drop sequence surveyor_seq;
create sequence surveyor_seq
start with 1;

-- report_seq
-- Sequence for report ids
drop sequence report_seq;
create sequence report_seq
start with 1000;

spool off
