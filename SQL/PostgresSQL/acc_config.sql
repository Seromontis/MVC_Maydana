-- Table: public.acc_config

-- DROP TABLE public.acc_config;

CREATE TABLE public.acc_config
(
  id_config serial,
  id_conta integer,
  nome character varying(50),
  licenca character varying(50),
  validade character varying(30),
  tipo integer,
  modulo_id integer NOT NULL DEFAULT 1,
  CONSTRAINT acc_config_pkey PRIMARY KEY (id_config),
  CONSTRAINT acc_config_id_conta_fkey FOREIGN KEY (id_conta)
      REFERENCES public.conta (id_conta) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT acc_config_modulo_id_fkey FOREIGN KEY (modulo_id)
      REFERENCES public.ms_modulos (modulo_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT acc_config_modulo_id_fkey1 FOREIGN KEY (modulo_id)
      REFERENCES public.ms_modulos (modulo_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.acc_config
  OWNER TO maydana;
