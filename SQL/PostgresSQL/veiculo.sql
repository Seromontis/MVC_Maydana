-- Table: public.veiculo

-- DROP TABLE public.veiculo;

CREATE TABLE public.veiculo
(
  id_veiculo serial,
  modelo smallint,
  nome character varying(150),
  ano numeric,
  tipo smallint NOT NULL DEFAULT 2, -- 1 = novo...
  cor smallint,
  marca smallint,
  portas smallint NOT NULL DEFAULT 1, -- 1 = 2 portas...
  quilometragem numeric,
  opcionais json,
  publicado smallint NOT NULL DEFAULT 1, -- 1 = SIM...
  descricao text,
  id_conta integer,
  CONSTRAINT veiculo_pkey PRIMARY KEY (id_veiculo),
  CONSTRAINT veiculo_id_conta_fkey FOREIGN KEY (id_conta)
      REFERENCES public.conta (id_conta) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.veiculo
  OWNER TO maydana;
COMMENT ON COLUMN public.veiculo.tipo IS '1 = novo
2 = usado
3 = seminovo
';
COMMENT ON COLUMN public.veiculo.portas IS '1 = 2 portas
2 = 4 portas';
COMMENT ON COLUMN public.veiculo.publicado IS '1 = SIM
2 = NÃO';

