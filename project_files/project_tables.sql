--Rebecca Williams
--Nathan Ortolan
--Guthrie Hayward
--Abdul Shaikh
-- CS 458 - Fall 2016
-- last modified: 2016-10-12

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


drop sequence report_seq;
create sequence report_seq
start with 1000;


spool off
