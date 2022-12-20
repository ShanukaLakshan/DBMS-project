drop table if exists custom_attribute;
create table custom_attribute
(	name	varchar(15),
	attr_id	int not null auto_increment,
    primary key (attr_id)
    );

alter table employee auto_increment=0;