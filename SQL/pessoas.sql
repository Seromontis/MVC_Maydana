-- Table: public.pessoas

-- DROP TABLE public.pessoas;

CREATE TABLE public.pessoas
(
  id integer NOT NULL DEFAULT nextval('pessoas_id_seq'::regclass),
  id_conta integer,
  nome character varying(150), -- nome completo do cidadão
  sexo smallint, -- 1 = masculino...
  nascimento character varying(30),
  cpf integer,
  rg integer,
  cid_codigo integer, -- codigo da cidade
  est_codigo integer, -- codigo do estado
  bai_codigo integer, -- codigo do bairro
  whatsapp character varying(30),
  telefone character varying(30),
  celular character varying(30),
  CONSTRAINT id_pessoa PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.pessoas
  OWNER TO maydana;
COMMENT ON COLUMN public.pessoas.nome IS 'nome completo do cidadão';
COMMENT ON COLUMN public.pessoas.sexo IS '1 = masculino
2 = feminino
3 = outro';
COMMENT ON COLUMN public.pessoas.cid_codigo IS 'codigo da cidade';
COMMENT ON COLUMN public.pessoas.est_codigo IS 'codigo do estado';
COMMENT ON COLUMN public.pessoas.bai_codigo IS 'codigo do bairro';
