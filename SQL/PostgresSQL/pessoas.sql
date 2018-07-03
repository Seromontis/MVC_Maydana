-- Table: pessoas

-- DROP TABLE pessoas;

CREATE TABLE pessoas
(
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
  id serial NOT NULL,
  CONSTRAINT pessoas_pkey PRIMARY KEY (id),
  CONSTRAINT pessoas_id_conta_fkey FOREIGN KEY (id_conta)
      REFERENCES conta (id_conta) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE pessoas
  OWNER TO matheus;
COMMENT ON COLUMN pessoas.nome IS 'nome completo do cidadão';
COMMENT ON COLUMN pessoas.sexo IS '1 = masculino
2 = feminino
3 = outro';
COMMENT ON COLUMN pessoas.cid_codigo IS 'codigo da cidade';
COMMENT ON COLUMN pessoas.est_codigo IS 'codigo do estado';
COMMENT ON COLUMN pessoas.bai_codigo IS 'codigo do bairro';

