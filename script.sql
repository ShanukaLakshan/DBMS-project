SET FOREIGN_KEY_CHECKS = 0;
drop table if exists employee;
drop table if exists supervisor;
drop table if exists address;
drop table if exists bank_details;
drop table if exists employment;
drop table if exists leave_detail;
drop table if exists leave_approved;
drop table if exists salary;
drop table if exists payroll;
drop table if exists leave_request;
drop table if exists user;
SET FOREIGN_KEY_CHECKS = 1; 
create table employee
	(name	varchar(20) not null,
     id	int not null auto_increment,
     gender	varchar(6) not null,
     phone_number	varchar(10),
     email	varchar(30),
     birth_date    date not null,
     marital_status varchar(10),
     primary key (id)
     );
alter table employee auto_increment=20000;
create table supervisor
	(supervisor_id	int not null,
	 id	int not null,
     primary key (supervisor_id,id),
     foreign key (id) references employee(id) on delete cascade
     );

create table user
	(user_name	varchar(20) not null,
	 id	int not null,
     password varchar(40) not null,
     primary key(user_name),
     foreign key (id) references employee(id) on delete cascade
     );
create table salary
	(job_title	varchar(20) check (job_title in('HR Manager',
'Accountant', 'Software Engineer', 'QA Engineer')) not null,
     pay_grade	tinyint check(pay_grade>0 and pay_grade<=3) not null,
     amount	numeric(7,0) check (amount>0) not null,
     primary key (job_title,pay_grade)
     );     
create table employment 
	(id	int not null,
	 job_title	varchar(20) not null,
     pay_grade	tinyint not null,
     employement_status	varchar(10 ) not null,
     department	varchar(10) not null,
     primary key (id),
     foreign key (id) references employee(id) ,
     foreign key (job_title,pay_grade) references salary(job_title,pay_grade) 
     );     
create table leave_detail
	(pay_grade	tinyint not null,
     job_title varchar(20) not null,
     annual	varchar(2),
     casual varchar(2),
     maternity	varchar(2),
     no_pay	varchar(2) not null,
     primary key (pay_grade,job_title),
     foreign key (job_title,pay_grade) references salary(job_title,pay_grade) 
     );
create table leave_approved
	(id	int not null,
	 type	varchar(10) not null,
     date	date not null,
     primary key(id,date),
     foreign key(id) references employee(id) on delete cascade
     );

create table address
	(id	int not null,
     address_line_1	varchar(20) not null,
	 address_line_2	varchar(20),
     province	varchar(10) not null,
     city	varchar(15) not null,
     postal_code	varchar(5) not null,
     primary key (id),
     foreign key (id) references employee(id) on delete cascade
     );

create table bank_details
	(
    id int not null,
    bank_name varchar(20) not null,
    branch_name varchar(20) not null,
    account_no varchar(20) not null,
    primary key (id),
    foreign key (id) references employee(id) on delete cascade
    );
create table payroll
	(
    id	int not null,
    payed_date date not null,
    primary key(id,payed_date),
    foreign key(id) references employee(id) on delete cascade
    );
    
create table leave_request
	(id int not null,
     type	varchar(10) not null,
     date	date not null,
     primary key(id,date),
     foreign key(id) references employee(id) on delete cascade
     );