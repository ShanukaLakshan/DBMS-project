create table employee
	(emp_name	varchar(20),
     employee_id	varchar(6),
     address	varchar(20),
     phone_number	varchar(10),
     birth_date    date,
     primary key (employee_id)
     );
create table supervisor
	(supervisor_id	varchar(6),
	 employee_id	varchar(6),
     primary key (supervisor_id,employee_id),
     foreign key (employee_id) references employee(employee_id)
     );

create table user
	(user_name	varchar(20),
	 employee_id	varchar(6),
     primary key(user_name),
     foreign key (employee_id) references employee(employee_id)
     );
create table salary
	(job_title	varchar(10),
     pay_grade	char(1),
     amount	numeric(7,0) check (amount>0),
     primary key (job_title,pay_grade)
     );     
create table employment 
	(employee_id	varchar(6),
	 job_title	varchar(10),
     pay_grade	char(1),
     employement_status	varchar(10),
     department	varchar(10),
     account_number	varchar(20),
     primary key (employee_id),
     foreign key (employee_id) references employee(employee_id) ,
     foreign key (job_title,pay_grade) references salary(job_title,pay_grade) 
     );     
create table leave_detail
	(pay_grade	char(1),
     job_title varchar(10),
     annual	varchar(2),
     casual varchar(2),
     maternity	varchar(2),
     no_pay	varchar(2),
     primary key (pay_grade,job_title)
     # foreign key (pay_grade,job_title) references salary(pay_grade,job_title) 
     );
create table personal_leave
	(employee_id	varchar(6),
	 leave_type	varchar(10),
     leave_date	date,
     primary key(employee_id,leave_date),
     foreign key(employee_id) references employee(employee_id)
     );
     