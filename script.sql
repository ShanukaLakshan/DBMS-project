SET FOREIGN_KEY_CHECKS = 0;
drop table if exists employee;
drop table if exists supervisor;
drop table if exists address;
drop table if exists bank_details;
drop table if exists employment;
drop table if exists leave_detail;
drop table if exists personal_leave;
drop table if exists salary;
drop table if exists payroll;
drop table if exists user;
SET FOREIGN_KEY_CHECKS = 1; 
create table employee
	(name	varchar(20),
     id	varchar(6),
     gender	varchar(6),
     phone_number	varchar(10),
     email	varchar(30),
     birth_date    date,
     martial_status varchar(10),
     primary key (id)
     );
create table supervisor
	(supervisor_id	varchar(6),
	 id	varchar(6),
     primary key (supervisor_id,id),
     foreign key (id) references employee(id) on delete cascade
     );

create table user
	(user_name	varchar(20),
	 id	varchar(6),
     primary key(user_name),
     foreign key (id) references employee(id) on delete cascade
     );
create table salary
	(job_title	varchar(10),
     pay_grade	char(1),
     amount	numeric(7,0) check (amount>0),
     primary key (job_title,pay_grade)
     );     
create table employment 
	(id	varchar(6),
	 job_title	varchar(10),
     pay_grade	char(1),
     employement_status	varchar(10),
     department	varchar(10),
     primary key (id),
     foreign key (id) references employee(id) ,
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
	(id	varchar(6),
	 type	varchar(10),
     date	date,
     primary key(id,date),
     foreign key(id) references employee(id) on delete cascade
     );

create table address
	(id	varchar(6),
     address_line_1	varchar(20),
	 address_line_2	varchar(20),
     province	varchar(10),
     city	varchar(15),
     postal_code	varchar(5),
     primary key (id),
     foreign key (id) references employee(id) on delete cascade
     );

create table bank_details
	(
    id varchar(6),
    bank_name varchar(20),
    branch_name varchar(20),
    account_no varchar(20),
    primary key (id),
    foreign key (id) references employee(id) on delete cascade
    );
create table payroll
	(
    id	varchar(6),
    payed_date date,
    primary key(id,payed_date),
    foreign key(id) references employee(id) on delete cascade
    );
    
