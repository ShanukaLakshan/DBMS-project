SET FOREIGN_KEY_CHECKS = 0;
drop table if exists employee;
drop table if exists supervisor;
drop table if exists address;
drop table if exists bank_details;
drop table if exists employment;
drop table if exists leave_detail;
drop table if exists personal_leave;
drop table if exists salary;
drop table if exists user;
SET FOREIGN_KEY_CHECKS = 1; 
create table employee
	(emp_name	varchar(20),
     emp_id	varchar(6),
     gender	varchar(6),
     phone_number	varchar(10),
     birth_date    date,
     primary key (emp_id)
     );
create table supervisor
	(supervisor_id	varchar(6),
	 emp_id	varchar(6),
     primary key (supervisor_id,emp_id),
     foreign key (emp_id) references employee(emp_id) on delete cascade
     );

create table user
	(user_name	varchar(20),
	 emp_id	varchar(6),
     primary key(user_name),
     foreign key (emp_id) references employee(emp_id) on delete cascade
     );
create table salary
	(job_title	varchar(10),
     pay_grade	char(1),
     amount	numeric(7,0) check (amount>0),
     primary key (job_title,pay_grade)
     );     
create table employment 
	(emp_id	varchar(6),
	 job_title	varchar(10),
     pay_grade	char(1),
     employement_status	varchar(10),
     department	varchar(10),
     primary key (emp_id),
     foreign key (emp_id) references employee(emp_id) ,
     foreign key (job_title,pay_grade) references salary(job_title,pay_grade) 
     );     
create table leave_detail
	(pay_grade	char(1),
     job_title varchar(10),
     annual	varchar(2),
     casual varchar(2),
     maternity	varchar(2),
     no_pay	varchar(2),
     primary key (pay_grade,job_title),
     foreign key (job_title,pay_grade) references salary(job_title,pay_grade) 
     );
create table personal_leave
	(emp_id	varchar(6),
	 leave_type	varchar(10),
     leave_date	date,
     primary key(emp_id,leave_date),
     foreign key(emp_id) references employee(emp_id) on delete cascade
     );

create table address
	(emp_ID	varchar(6),
     address_line_1	varchar(20),
	 address_line_2	varchar(20),
     province	varchar(10),
     city	varchar(15),
     postal_code	varchar(5),
     primary key (emp_id),
     foreign key (emp_id) references employee(emp_id) on delete cascade
     );

create table bank_details
	(
    emp_ID varchar(6),
    bank_name varchar(20),
    branch_name varchar(20),
    account_no varchar(20),
    primary key (emp_ID),
    foreign key (emp_ID) references employee(emp_id) on delete cascade
    );
    
