-- Table: public.disciplina

-- DROP TABLE public.disciplina;

CREATE TABLE public.disciplina
(
  id integer NOT NULL DEFAULT nextval('disciplina_id_seq'::regclass),
  nome character varying(30), -- nome da disciplina
  ensino smallint NOT NULL DEFAULT 1, -- 1 = ensino médio...
  prof_id interval, -- id da pessoa (professor) responsável pela disciplina
  vagas integer NOT NULL DEFAULT 0, -- Número de vagas da disciplina
  status smallint -- 1 = ativo...
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.disciplina
  OWNER TO maydana;
COMMENT ON COLUMN public.disciplina.nome IS 'nome da disciplina';
COMMENT ON COLUMN public.disciplina.ensino IS '1 = ensino médio
2 = ensino fundamental';
COMMENT ON COLUMN public.disciplina.prof_id IS 'id da pessoa (professor) responsável pela disciplina';
COMMENT ON COLUMN public.disciplina.vagas IS 'Número de vagas da disciplina';
COMMENT ON COLUMN public.disciplina.status IS '1 = ativo
2 = inativo';
