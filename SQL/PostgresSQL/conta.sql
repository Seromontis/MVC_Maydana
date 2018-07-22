-- Table: public.conta

-- DROP TABLE public.conta;

CREATE TABLE public.conta
(
  id_conta serial,
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
  token character varying(100),
  nome character(150),
  CONSTRAINT conta_pkey PRIMARY KEY (id_conta)
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


-- Trigger: conta_trigger on public.conta

-- DROP TRIGGER conta_trigger ON public.conta;

CREATE TRIGGER conta_trigger
  AFTER INSERT
  ON public.conta
  FOR EACH ROW
  EXECUTE PROCEDURE public.conta_trigger_procedure();