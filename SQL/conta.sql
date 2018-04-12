-- Table: public.conta

-- DROP TABLE public.conta;

CREATE TABLE public.conta
(
  id integer NOT NULL DEFAULT nextval('usuario_id_seq'::regclass),
  email character varying(150) NOT NULL,
  senha character varying(40) NOT NULL,
  status smallint NOT NULL DEFAULT 0, -- 0 = inativo...
  acesso smallint NOT NULL DEFAULT 1, -- nível de acesso do usuário...
  data_criacao character varying(50) NOT NULL,
  hora_criacao character varying(30) NOT NULL,
  ip_criacao character varying(50),
  hora_ultimo_login character varying(30),
  data_ultimo_login character varying(30),
  ip_ultimo_login character varying(30),
  CONSTRAINT id_conta PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.conta
  OWNER TO maydana;
COMMENT ON COLUMN public.conta.status IS '0 = inativo
1 = ativo
2 = offline
3 = online';
COMMENT ON COLUMN public.conta.acesso IS 'nível de acesso do usuário

1 = normal
2 = aluno
3 = professor
4 = diretor
5 = DEUS';
