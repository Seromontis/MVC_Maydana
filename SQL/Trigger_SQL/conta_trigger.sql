DELIMITER $$

CREATE TRIGGER conta_trigger 
AFTER INSERT ON conta
FOR EACH ROW BEGIN

	INSERT INTO pessoas ('id_conta') VALUES (NEW.id_conta);

END$$
DELIMITER;