--Rebecca Williams
--Nathan Ortolan
--Guthrie Hayward
--Abdul Shaikh
-- CS 458 - Fall 2016
-- last modified: 2016-10-08

spool project-design-out.txt

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


Drop table Report_entries cascade constraints;

create table Report_entries
(PRN				                    varchar(30) not null,
 surveyor_id                    integer(3),
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
 foreign key (surveyor_id) references Surveyor,
 foreign key (report_id) references Reports
);


drop sequence surveyor_seq;
create sequence surveyor_seq
start with 1;

drop sequence report_seq;
create sequence report_seq
start with 1000;

spool off
