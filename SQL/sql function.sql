DELIMITER $$
CREATE FUNCTION auth
(
 uname VARCHAR(20),
 pwd VARCHAR(40)
)
RETURNS BOOL 
DETERMINISTIC
BEGIN
    DECLARE verify INT;
    SELECT COUNT(*) INTO verify
	FROM user
	WHERE user_name = uname AND password = pwd;
    
    RETURN verify; 
END$$
DELIMITER ;