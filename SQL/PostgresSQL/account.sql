-- Table: public.account

-- DROP TABLE public.account;

CREATE TABLE public.account
(
  id_account serial,
  token character varying(50) NOT NULL DEFAULT 0,
  senha character varying(100),
  data_cadastro character varying(30) NOT NULL, -- Dia que criou a conta
  hora_cadastro character varying(30) NOT NULL,
  palavra_secreta character varying(50),
  email character varying(150) NOT NULL,
  status smallint NOT NULL DEFAULT 4, -- 1 = off...
  ip_cadastro character varying(30) NOT NULL,
  ultimo_login character varying(30)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.account
  OWNER TO maydana;
GRANT ALL ON TABLE public.account TO maydana;
GRANT ALL ON TABLE public.account TO public;
COMMENT ON TABLE public.account
  IS 'Tabela responsável por armazenar todas as contas dos usuários.';
COMMENT ON COLUMN public.account.data_cadastro IS 'Dia que criou a conta';
COMMENT ON COLUMN public.account.status IS '1 = off
2 = on
3 = bloqueado
4 = inativo
5 = ativo';

