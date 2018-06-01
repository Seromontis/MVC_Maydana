-- VERSÃO: 1.2
-- DATA: 30/05/2018
-- CRIADOR: MAYDANA


-- DROP TRIGGER IF EXISTS conta_trigger ON conta;
-- DROP FUNCTION IF EXISTS public.conta_trigger_procedure();

CREATE OR REPLACE FUNCTION conta_trigger_procedure() RETURNS TRIGGER AS
$conta_trigger$
	BEGIN

		IF (TG_OP = 'INSERT') THEN
			INSERT INTO pessoas (id_conta) VALUES (NEW.id_conta);
			INSERT INTO site_contato (id_conta) VALUES (NEW.id_conta);
		END IF;
		RETURN NULL;
	END;
$conta_trigger$ LANGUAGE plpgsql;

CREATE TRIGGER conta_trigger AFTER INSERT ON conta FOR EACH ROW EXECUTE PROCEDURE conta_trigger_procedure();