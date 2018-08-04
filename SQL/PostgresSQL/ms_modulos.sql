-- Table: public.ms_modulos

-- DROP TABLE public.ms_modulos;

CREATE TABLE public.ms_modulos
(
  modulo_id serial,
  nome character varying(50),
  CONSTRAINT ms_modulos_pkey PRIMARY KEY (modulo_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.ms_modulos
  OWNER TO maydana;