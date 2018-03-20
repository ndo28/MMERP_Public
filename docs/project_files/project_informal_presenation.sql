--Rebecca Williams
--Nathan Ortolan
--Guthrie Hayward
--Abdul Shaikh
-- CS 458 - Fall 2016
--modified: 2016-11-02 by ats234

spool project-informal-presentation-out.txt

delete
from Users
where hsu_username = 'st10';

--This is demo 1--
select *
from users;

insert into Users
  values ('st10','ST','Tuttle','Sharon','st10@humboldt.edu','root','N','Y');


--This is demo 2--
select PRN, beach_name
from report_entries,beaches,reports
where hsu_username = 'gmh234'
      and reports.report_id = report_entries.report_id
      and beaches.beach_abbr = reports.beach_abbr;

--should show sharon has been added--
select *
from users;


spool off
