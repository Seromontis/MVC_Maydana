-- Table: pessoas

-- DROP TABLE pessoas;

CREATE TABLE pessoas
(
  id serial NOT NULL,
  id_conta integer,
  tipo smallint DEFAULT 1, -- 1 = usuario...
  nome character varying(150), -- nome completo do cidadão
  cid_codigo integer, -- codigo da cidade
  est_codigo integer, -- codigo do estado
  bai_codigo integer, -- codigo do bairro
  sexo smallint, -- 1 = masculino...
  nascimento character varying(30),
  cpf integer,
  rg integer,
  whatsapp character varying(30),
  telefone character varying(30),
  celular character varying(30),
  descricao character varying(250),
  CONSTRAINT pessoas_pkey PRIMARY KEY (id),
  CONSTRAINT pessoas_id_conta_fkey FOREIGN KEY (id_conta)
      REFERENCES conta (id_conta) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE pessoas
  OWNER TO maydana;
COMMENT ON COLUMN pessoas.nome IS 'nome completo do cidadão';
COMMENT ON COLUMN pessoas.sexo IS '1 = masculino
2 = feminino
3 = outro';
COMMENT ON COLUMN pessoas.cid_codigo IS 'codigo da cidade';
COMMENT ON COLUMN pessoas.est_codigo IS 'codigo do estado';
COMMENT ON COLUMN pessoas.bai_codigo IS 'codigo do bairro';
COMMENT ON COLUMN pessoas.tipo IS '1 = usuario
2 = cliente
3 = funcionario
4 = gerente
5 = GOD';

