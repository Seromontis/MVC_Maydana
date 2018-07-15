-- Table: site_contato

-- DROP TABLE site_contato;

CREATE TABLE site_contato
(
  id serial NOT NULL,
  id_conta integer,
  usu_codigo_change integer,
  titulo character varying(200) NOT NULL DEFAULT 'contato'::character varying,
  subtitulo character(200) NOT NULL DEFAULT 'entre_em_contato'::bpchar,
  mensagem character varying(300),
  email character varying(150) NOT NULL DEFAULT 'exemplo@email.com'::character varying,
  telefone character varying(30) NOT NULL DEFAULT '(54) 3342-3342'::character varying,
  whatsapp character varying(30) NOT NULL DEFAULT '(54) 3342-3342'::character varying,
  celular character varying(30) NOT NULL DEFAULT '(54) 3342-3342'::character varying,
  instagram character varying(50) NOT NULL DEFAULT '@instagram'::character varying,
  facebook character varying(50) NOT NULL DEFAULT '@facebook'::character varying,
  site character varying(50) NOT NULL DEFAULT 'meusite.com'::character varying,
  ip_criacao character varying(30),
  data_criacao character varying(30),
  hora_criacao character varying(30),
  ip_atualizacao character varying(30),
  data_atualizacao character varying(30),
  hora_atualizacao character varying(30),
  CONSTRAINT site_contato_id_conta_fkey FOREIGN KEY (id_conta)
      REFERENCES conta (id_conta) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT site_contato_usu_codigo_change_fkey FOREIGN KEY (usu_codigo_change)
      REFERENCES pessoas (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE site_contato
  OWNER TO maydana;
