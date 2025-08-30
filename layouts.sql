-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 20-Mar-2020 às 13:04
-- Versão do servidor: 10.4.8-MariaDB
-- PHP Version: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peimagec_peimage`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `layouts`
--

CREATE TABLE IF NOT EXISTS `layouts` (
  `idlayouts` int(15) unsigned NOT NULL,
  `fkempresas` int(15) unsigned DEFAULT NULL,
  `nome` varchar(50) NOT NULL,
  `arquivo` varchar(50) NOT NULL,
  `altura` int(4) unsigned DEFAULT NULL,
  `largura` int(4) unsigned DEFAULT NULL,
  `status_campanha` tinyint(3) unsigned DEFAULT NULL,
  `utilizacao` varchar(15) DEFAULT NULL,
  `font_text` varchar(50) DEFAULT NULL,
  `desativacao` tinyint(3) unsigned DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `layouts`
--

INSERT INTO `layouts` (`idlayouts`, `fkempresas`, `nome`, `arquivo`, `altura`, `largura`, `status_campanha`, `utilizacao`, `font_text`, `desativacao`) VALUES
(1, 1, 'cartaz - padrao', 'actionCreateCartaz', 841, 595, 1, 'sem_restricao', NULL, NULL),
(4, 1, 'post - padrao', 'actionCreatePost', 960, 960, 1, 'sem_restricao', NULL, NULL),
(7, 1, 'cartaz - retrato', 'actionCreateCartazRetrato', NULL, NULL, 0, 'sem_restricao', NULL, NULL),
(8, 1, 'cartaz - paisagem', 'actionCreateCartazPaisagem', 0, 0, 0, 'sem_restricao', NULL, NULL),
(9, 1, 'cartaz - aviso', 'actionCreateCartazAviso', NULL, NULL, 0, 'sem_restricao', NULL, NULL),
(13, 1, 'foto', 'actionCreateFoto', NULL, NULL, 0, 'sem_restricao', NULL, NULL),
(14, 3, 'foto - modelo 1', 'actionCreateFoto1', NULL, NULL, 0, 'sem_restricao', NULL, NULL),
(15, 3, 'foto - modelo 2', 'actionCreateFoto2', NULL, NULL, 0, 'sem_restricao', NULL, NULL),
(27, 1, 'foto - cartaz', 'actionCreateFotoCartaz', 0, 0, 0, 'sem_restricao', NULL, NULL),
(28, 16, 'convite digital', 'actionCreateDigitalInviteCDL', 3509, 2482, 1, 'download', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `layouts`
--
ALTER TABLE `layouts`
  ADD PRIMARY KEY (`idlayouts`),
  ADD UNIQUE KEY `layouts_nome_fkempresas_un` (`nome`,`fkempresas`),
  ADD KEY `layouts_fkemrpesas` (`fkempresas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `layouts`
--
ALTER TABLE `layouts`
  MODIFY `idlayouts` int(15) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `layouts`
--
ALTER TABLE `layouts`
  ADD CONSTRAINT `layouts_ibfk_1` FOREIGN KEY (`fkempresas`) REFERENCES `empresas` (`idempresas`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
