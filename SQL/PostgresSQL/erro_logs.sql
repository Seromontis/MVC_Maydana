-- Table: public.erro_logs

-- DROP TABLE public.erro_logs;

CREATE TABLE public.erro_logs
(
  id serial,
  descricao text,
  data character varying(30),
  hora character varying(30),
  ip character varying(30),
  usu_codigo integer,
  codigo_postgres character varying(10),
  tipo_postgres integer,
  arrayzao text
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.erro_logs
  OWNER TO maydana;