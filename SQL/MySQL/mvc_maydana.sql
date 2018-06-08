-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Mai 31, 2018 as 08:39 
-- Versão do Servidor: 5.1.41
-- Versão do PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `mvc_maydana`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `conta`
--

CREATE TABLE IF NOT EXISTS `conta` (
  `id_conta` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `senha` varchar(40) NOT NULL,
  `acesso` int(10) NOT NULL,
  `data_criacao` varchar(30) NOT NULL,
  `hora_criacao` varchar(30) NOT NULL,
  `ip_criacao` varchar(30) NOT NULL,
  `hora_ultimo_login` varchar(30) NOT NULL,
  `data_ultimo_login` varchar(30) NOT NULL,
  `ip_ultimo_login` varchar(30) NOT NULL,
  `token` varchar(100) NOT NULL,
  `status` int(10) NOT NULL,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id_conta`),
  KEY `id_conta` (`id_conta`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `conta`
--


--
-- Gatilhos `conta`
--
DROP TRIGGER IF EXISTS `conta_trigger`;
DELIMITER //
CREATE TRIGGER `conta_trigger` AFTER INSERT ON `conta`
 FOR EACH ROW BEGIN
	INSERT INTO pessoas (id_conta) VALUES (NEW.id_conta);
	INSERT INTO acc_config (id_conta) VALUES (NEW.id_conta);
  INSERT INTO site_contato (id_conta) VALUES (NEW.id_conta);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoas`
--

CREATE TABLE IF NOT EXISTS `pessoas` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_conta` int(10) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `sexo` int(10) NOT NULL,
  `nascimento` varchar(30) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `rg` varchar(20) NOT NULL,
  `cid_codigo` int(10) NOT NULL,
  `est_codigo` int(10) NOT NULL,
  `bai_codigo` int(10) NOT NULL,
  `whatsapp` varchar(20) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `celular` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `pessoas`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `site_contato`
--

CREATE TABLE IF NOT EXISTS `site_contato` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) NOT NULL DEFAULT 'Contato',
  `subtitulo` varchar(200) NOT NULL DEFAULT 'entre em contato',
  `mensagem` text NOT NULL,
  `email` varchar(150) NOT NULL DEFAULT 'exemplo@email.com',
  `telefone` varchar(30) NOT NULL DEFAULT '(54) 3342-3342',
  `whatsapp` varchar(30) NOT NULL DEFAULT '(54) 9966-9966',
  `celular` varchar(30) NOT NULL DEFAULT '(54) 9966-9966',
  `instagram` varchar(50) NOT NULL DEFAULT '@instagram123',
  `facebook` varchar(50) NOT NULL DEFAULT '@facebook123',
  `site` varchar(50) NOT NULL DEFAULT 'meusite.com',
  `ip_criacao` varchar(30) NOT NULL,
  `data_criacao` varchar(30) NOT NULL,
  `hora_criacao` varchar(30) NOT NULL,
  `ip_atualizacao` varchar(30) NOT NULL,
  `data_atualizacao` varchar(30) NOT NULL,
  `hora_atualizacao` varchar(30) NOT NULL,
  `usu_codigo_change` int(11) NOT NULL,
  `id_conta` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `site_contato`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
