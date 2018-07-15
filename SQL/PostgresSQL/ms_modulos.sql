-- Table: ms_modulos

-- DROP TABLE ms_modulos;

CREATE TABLE ms_modulos
(
  modulo_id serial,
  nome character varying(50),
  CONSTRAINT ms_modulos_pkey PRIMARY KEY (modulo_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE ms_modulos
  OWNER TO maydana;
