start transaction ;
	insert into employee (name,gender,phone_number,email,birth_date,marital_status) values ('chil','male','01225603','email@gmail.com','2000-12-21','separated');
	insert into address values('20000','no.187/2','holla rd','central','matale','20000');
    insert into employment values("20000","Software engineer","3","Permenant","admin");
    insert into supervisor values("20000",'20001');
    insert into bank_details values ("20000","Bank of ceylon","Matale","1234567890");
	commit;
    