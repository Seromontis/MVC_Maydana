-- Table: public.imagens

-- DROP TABLE public.imagens;

CREATE TABLE public.imagens
(
  id_imagem serial,
  id_veiculo integer,
  nome character varying(200),
  CONSTRAINT imagens_pkey PRIMARY KEY (id_imagem),
  CONSTRAINT imagens_id_veiculo_fkey FOREIGN KEY (id_veiculo)
      REFERENCES public.veiculo (id_veiculo) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.imagens
  OWNER TO maydana;