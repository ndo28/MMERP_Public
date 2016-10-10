/*
 Abdul Shaikh
 reports table
 Last Modified 10-9-2016
*/

drop table reports cascade constraints;
drop table report_entries cascade constraints;

create or replace table reports
( report_id number(5),
  date date,
  reports_total_survey_time number(3),
  start_time time,
  end_time time,
  beach_name varchar2(50),
  survey_summary varchar2(300),
  PRIMARY KEY (report_id)
);

create or replace table report_entries
  (
    prn varchar2(36),
    species_name varchar2(5),
    coordinates-lat (10,7),
    coordinates-long (10,7).
    post_survey_tag char(1),
    exsisting_survey_tag char(1),
    photos char(1),
    comments varchar2(300),
    album_url varchar2(100),
    PRIMARY KEY (prn)
  )
