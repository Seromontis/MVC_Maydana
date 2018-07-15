-- VERSÃO: 1.2
-- DATA: 30/05/2018
-- CRIADOR: MAYDANA

-- Function: conta_trigger_procedure()
-- DROP FUNCTION conta_trigger_procedure();

CREATE OR REPLACE FUNCTION conta_trigger_procedure()
  RETURNS trigger AS
$BODY$
	BEGIN

		IF (TG_OP = 'INSERT') THEN
			INSERT INTO pessoas (id_conta) VALUES (NEW.id_conta);
			INSERT INTO site_contato (id_conta) VALUES (NEW.id_conta);
			INSERT INTO acc_config (id_conta) VALUES (NEW.id_conta);
		END IF;
		RETURN NULL;
	END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION conta_trigger_procedure()
  OWNER TO maydana;
