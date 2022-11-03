start transaction;
	delete from leave_request where id=2000 and date=2022-08-09;
	insert into leave_approved values (id,type,date);
commit;