SET FOREIGN_KEY_CHECKS = 0;
drop table if exists employee;
drop table if exists supervisor;
drop table if exists address;
drop table if exists bank_details;
drop table if exists employment;
drop table if exists leave_detail;
drop table if exists salary;
drop table if exists payroll;
drop table if exists leave_requests;
drop table if exists department;
drop table if exists job;
drop table if exists leave_type;
drop table if exists emp_status;
drop table if exists pay_level;
drop table if exists user;
drop table if exists custom_attribute;
SET FOREIGN_KEY_CHECKS = 1; 
create table employee
	(first_name	varchar(20) not null,
	 last_name varchar(20) not null,
     id	int not null auto_increment,
     gender	varchar(6) not null,
     phone_number	varchar(10),
     email	varchar(50),
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
create table emp_status
	(stat_id varchar(1),
     title varchar(20),
     primary key(stat_id)
     );
     
create table user
	(user_name	varchar(20) not null,
	 id	int not null,
     password varchar(40) not null,
     user_type varchar(5),
     img_name varchar(20),
     img_data longblob,
     primary key(user_name),
     foreign key (id) references employee(id) on delete cascade
     );
create table job 
	(job_title varchar(30) not null,
	 job_id varchar(3) not null,
     primary key (job_id)
     );
create table pay_level
	(pay_grade tinyint not null,
	 title varchar(10) not null,
     primary key(pay_grade)
     );
     
create table salary
	(job_id	varchar(3)  not null,
     pay_grade	tinyint not null,
     amount	numeric(7,0) check (amount>0) not null,
     primary key (job_id,pay_grade),
     foreign key(pay_grade) references pay_level(pay_grade),
     foreign key(job_id) references job(job_id)
     );  
     
create table department
	(name	varchar(30) not null,
     id	varchar(4)	not null,
     primary key(id)
     );
create table employment 
	(id	int not null,
	 job_id	varchar(3) not null,
     pay_grade	tinyint not null,
     stat_id	varchar(1 ) not null,
     dept_id	varchar(5) not null,
     primary key (id),
     foreign key (id) references employee(id) ,
     foreign key(stat_id) references emp_status(stat_id),
     foreign key (job_id) references job(job_id),
     foreign key (pay_grade) references pay_level(pay_grade),
     foreign key (dept_id) references department(id)
     
     );    
create table leave_type
	(type_id varchar(2) not null,
     name varchar(15) not null,
     primary key(type_id)
     );
create table leave_detail
	(pay_grade	tinyint not null,
	 type_id varchar(2) not null,
     leaves varchar(2) not null,
     primary key (pay_grade,type_id),
     foreign key (pay_grade) references pay_level(pay_grade),
     foreign key (type_id) references leave_type(type_id)
     );
     
create table address
	(id	int not null,
     address_line_1	varchar(20) not null,
	 address_line_2	varchar(20),
     province	varchar(20) not null,
     city	varchar(20) not null,
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
    
create table leave_requests
	(leave_id int not null auto_increment,
     id int not null,
     type_id	varchar(15) not null,
     date_of_leave	date not null,
     date_requested date,
     date_moderated date,
     status varchar(10),
     primary key(leave_id),
     foreign key(type_id) references leave_type(type_id),
     foreign key(id) references employee(id) on delete cascade
     );
alter table leave_requests auto_increment=0;
create table custom_attribute
(	name	varchar(15),
	attr_id	int not null auto_increment,
    primary key (attr_id)
    );
alter table custom_attribute auto_increment=0;

create view employee_detail as select employment.id,user_name,job_title,name as department,emp_status.title as status,address_line_1,address_line_2,province,city,postal_code from employment inner join job using(job_id) inner join department on employment.dept_id=department.id inner join address on address.id=employment.id inner join emp_status using (stat_id) inner join user on user.id=employment.id order by employment.id;