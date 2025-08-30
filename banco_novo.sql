-- Tiago phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22-Out-2019 às 21:26
-- Versão do servidor: 10.4.8-MariaDB
-- versão do PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `peimage`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `arquivos`
--

CREATE TABLE `arquivos` (
  `idarquivos` int(10) UNSIGNED NOT NULL,
  `fkcampanhas` int(15) UNSIGNED NOT NULL,
  `fklayouts` int(15) UNSIGNED NOT NULL,
  `nome_arquivo` varchar(100) DEFAULT NULL,
  `desativacao` tinyint(4) NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `campanhas`
--

CREATE TABLE `campanhas` (
  `idcampanhas` int(15) UNSIGNED NOT NULL,
  `fkempresas` int(15) UNSIGNED NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cor1` varchar(50) DEFAULT NULL,
  `cor2` varchar(50) DEFAULT NULL,
  `cor3` varchar(50) DEFAULT NULL,
  `dt_inicio` date DEFAULT NULL,
  `dt_encerramento` date DEFAULT NULL,
  `desativacao` tinyint(4) NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `campanhas`
--

INSERT INTO `campanhas` (`idcampanhas`, `fkempresas`, `nome`, `cor1`, `cor2`, `cor3`, `dt_inicio`, `dt_encerramento`, `desativacao`) VALUES
(29, 3, 'clip', NULL, NULL, NULL, '2019-10-22', '2050-10-28', 0),
(30, 3, 'oferta relampago', NULL, NULL, NULL, '2019-10-22', '2050-10-28', 0),
(31, 3, 'cliente vip', NULL, NULL, NULL, '2019-10-22', '2050-10-28', 0),
(32, 3, 'super feirao de utilidades', NULL, NULL, NULL, '2019-10-22', '2020-05-28', 0),
(33, 3, 'festival verao', NULL, NULL, NULL, '2019-10-22', '2020-06-28', 0),
(34, 11, 'paper', NULL, NULL, NULL, '2019-10-22', '2050-10-28', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `empresas`
--

CREATE TABLE `empresas` (
  `idempresas` int(15) UNSIGNED NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cnpj` varchar(18) NOT NULL,
  `cor` varchar(7) NOT NULL,
  `plano` varchar(5) NOT NULL,
  `font_text` varchar(50) DEFAULT NULL,
  `cor_texto` varchar(7) DEFAULT NULL,
  `cor1` varchar(7) NOT NULL,
  `cor2` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `empresas`
--

INSERT INTO `empresas` (`idempresas`, `nome`, `cnpj`, `cor`, `plano`, `font_text`, `cor_texto`, `cor1`, `cor2`) VALUES
(1, 'peimage', '06.536.801/0001-', '#373435', '', NULL, '#FFFFFF', '', ''),
(3, 'rede clip', '06.536.801/0001-52', '#D33438', '', NULL, '#FFFFFF', '#FFC939', ''),
(7, 'moda da hora', '00.000.000/0001-', '#000000', '', NULL, '#FFFFFF', '', ''),
(8, 'Peimage Teste', '00.000.000/0001-', '#006064', '', NULL, '#FFFFFF', '', ''),
(11, 'rede paper', '05.698.940/0001-10', '#FFDE21', '', NULL, '#006BB5', '#006BB5', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `estatisticas`
--

CREATE TABLE `estatisticas` (
  `idestatisticas` int(15) UNSIGNED NOT NULL,
  `fkusuarios` int(15) UNSIGNED NOT NULL,
  `fktemas` int(15) UNSIGNED NOT NULL,
  `dataLog` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tipo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `layouts`
--

CREATE TABLE `layouts` (
  `idlayouts` int(15) UNSIGNED NOT NULL,
  `fkempresas` int(15) UNSIGNED DEFAULT NULL,
  `nome` varchar(50) NOT NULL,
  `arquivo` varchar(50) NOT NULL,
  `altura` int(4) UNSIGNED NULL,
  `largura` int(4) UNSIGNED NULL,
  `status_campanha` tinyint(3) UNSIGNED DEFAULT NULL,
  `utilizacao` varchar(15) DEFAULT NULL,
  `font_text` varchar(50) DEFAULT NULL,
  `desativacao` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `layouts`
--

INSERT INTO `layouts` (`idlayouts`, `fkempresas`, `nome`, `arquivo`, `altura`, `largura`, `status_campanha`, `utilizacao`, `font_text`, `desativacao`) VALUES
(1, 1, 'cartaz - padrao', 'actionCreateCartaz', 841, 595, 1, 'download', NULL, NULL),
(4, 1, 'post - padrao', 'actionCreatePost', 960, 960, 1, 'postavel', NULL, NULL),
(7, 1, 'cartaz - retrato', 'actionCreateCartazRetrato', 0, 0, 0, 'download', NULL, NULL),
(8, 1, 'cartaz - paisagem', 'actionCreateCartazPaisagem', 0, 0, 0, 'sem_restricao', NULL, NULL),
(9, 1, 'cartaz - aviso', 'actionCreateCartazAviso', 0, 0, 0, 'download', NULL, NULL),
(13, 1, 'foto', 'actionCreateFoto', 0, 0, 0, 'postavel', NULL, NULL),
(14, 3, 'foto - modelo 1', 'actionCreateFoto1', 0, 0, 0, 'postavel', NULL, NULL),
(15, 3, 'foto - modelo 2', 'actionCreateFoto2', 0, 0, 0, 'postavel', NULL, NULL),
(27, 1, 'foto - cartaz', 'actionCreateFotoCartaz', 0, 0, 0, 'sem_restricao', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `layouts_campanha`
--

CREATE TABLE `layouts_campanha` (
  `idlayouts_campanha` int(10) UNSIGNED NOT NULL,
  `fkcampanhas` int(15) UNSIGNED NOT NULL,
  `fklayouts` int(15) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `layouts_campanha`
--

INSERT INTO `layouts_campanha` (`idlayouts_campanha`, `fkcampanhas`, `fklayouts`) VALUES
(31, 29, 1),
(32, 29, 4),
(33, 30, 1),
(34, 30, 4),
(35, 31, 1),
(36, 31, 4),
(37, 32, 1),
(38, 32, 4),
(39, 33, 1),
(40, 33, 4),
(41, 34, 1),
(42, 34, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `posts`
--

CREATE TABLE `posts` (
  `idposts` int(15) UNSIGNED NOT NULL,
  `fkusuarios` int(15) UNSIGNED NOT NULL,
  `fkarquivos` int(10) UNSIGNED NOT NULL,
  `po01dth_postado` datetime NOT NULL,
  `po01fb_id_pagina` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `temas`
--

CREATE TABLE `temas` (
  `idtemas` int(15) UNSIGNED NOT NULL,
  `fklayouts_campanha` int(10) UNSIGNED NOT NULL,
  `nome_arquivo` varchar(50) DEFAULT NULL,
  `status_teste` tinyint(1) DEFAULT NULL,
  `cor1` varchar(7) DEFAULT NULL,
  `cor2` varchar(7) DEFAULT NULL,
  `cor3` varchar(7) DEFAULT NULL,
  `desativacao` tinyint(4) NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `temas`
--

INSERT INTO `temas` (`idtemas`, `fklayouts_campanha`, `nome_arquivo`, `status_teste`, `cor1`, `cor2`, `cor3`, `desativacao`) VALUES
(50, 31, '11004993785daf50be2f6ed6.90758172.png', 1, NULL, NULL, NULL, 0),
(51, 32, '5393542285daf50c98f0210.99962274.png', 1, NULL, NULL, NULL, 0),
(52, 33, '7262219135daf50eceab617.68536030.png', 1, NULL, NULL, NULL, 0),
(53, 34, '8576542625daf50fccabdc8.20327724.png', 1, NULL, NULL, NULL, 0),
(54, 35, '15953829195daf514f39a8f8.99962371.png', 1, NULL, NULL, NULL, 0),
(55, 36, '13615578155daf5188d6c2f2.31539417.png', 1, NULL, NULL, NULL, 0),
(56, 36, '11939978975daf518917f5c9.55555315.png', 1, NULL, NULL, NULL, 0),
(57, 37, '5119071315daf51c5116f13.24534230.png', 1, NULL, NULL, NULL, 0),
(58, 38, '16825059505daf51d4870e72.37096780.png', 1, NULL, NULL, NULL, 0),
(59, 38, '7355977075daf51d4dc6cb0.94881133.png', 1, NULL, NULL, NULL, 0),
(60, 38, '6164695835daf51d4e76a82.74803183.png', 1, NULL, NULL, NULL, 0),
(61, 38, '17928760725daf51d5037442.79218958.png', 1, NULL, NULL, NULL, 0),
(62, 38, '7271728145daf51d5271b69.57777306.png', 1, NULL, NULL, NULL, 0),
(63, 38, '16061658365daf51d55c45e3.16982175.png', 1, NULL, NULL, NULL, 0),
(64, 39, '11630289555daf52012275a6.73217167.png', 1, NULL, NULL, NULL, 0),
(65, 40, '4242489465daf521e0a5718.82420047.png', 1, NULL, NULL, NULL, 0),
(66, 40, '5042805335daf521e2ce4b9.97966572.png', 1, NULL, NULL, NULL, 0),
(67, 40, '18647026015daf521e410340.29343981.png', 1, NULL, NULL, NULL, 0),
(68, 40, '12518729895daf521e5e81a6.63104711.png', 1, NULL, NULL, NULL, 0),
(69, 40, '19136560625daf521e6f16e2.74767147.png', 1, NULL, NULL, NULL, 0),
(70, 41, '11710251205daf56ab0ef6e6.61037030.png', 1, NULL, NULL, NULL, 0),
(71, 42, '728882965daf56b7c6ee48.49519054.png', 1, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuarios` int(15) UNSIGNED NOT NULL,
  `fkempresas` int(15) UNSIGNED NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `senha` varchar(15) NOT NULL,
  `tipo` varchar(10) NOT NULL,
  `fb_uid_usuario` varchar(20) DEFAULT NULL,
  `fb_token_extendido` varchar(300) DEFAULT NULL,
  `fb_id_album` varchar(20) DEFAULT NULL,
  `fb_nome_album` varchar(200) DEFAULT NULL,
  `fb_id_pagina` varchar(20) DEFAULT NULL,
  `fb_nome_pagina` varchar(20) DEFAULT NULL,
  `fb_cod_exclusao` char(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`idusuarios`, `fkempresas`, `nome`, `email`, `senha`, `tipo`, `fb_uid_usuario`, `fb_token_extendido`, `fb_id_album`, `fb_nome_album`, `fb_id_pagina`, `fb_nome_pagina`, `fb_cod_exclusao`) VALUES
(1, 1, 'peimage', 'peimage@peimage.com.br', 't0183m1234', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 3, 'rede clip', 'redeclip@redeclip.com.br', 'rede9726clip', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 3, 'Dipel Papelaria', 'DipelPapelaria@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 3, 'ALS', 'ALS@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 3, 'Bazar Nair', 'BazarNair@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 3, 'Book Shop', 'BookShop@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 3, 'Brasil Multiloja', 'BrasilMultiloja@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 3, 'Casa', 'Casa@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 3, 'Casa do Fogo', 'CasadoFogo@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 3, 'Cia do Desenho', 'CiadoDesenho@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 3, 'Criativa', 'Criativa@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 3, 'Dienstmann', 'Dienstmann@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 3, 'Escolao', 'Escolao@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 3, 'Graffite', 'Graffite@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 3, 'Independencia', 'Independencia@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 3, 'Karisma', 'Karisma@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 3, 'Livraria Center', 'LivrariaCenter@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 3, 'Livraria Guaporense', 'LivrariaGuaporense@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 3, 'Livraria Ivone', 'LivrariaIvone@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 3, 'Mega', 'Mega@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 3, 'Michelangelo', 'Michelangelo@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 3, 'Na Graca', 'NaGraca@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 3, 'Novo Stylo', 'NovoStylo@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 3, 'Oba Oba', 'ObaOba@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 3, 'Papelaria Brilhante', 'PapelariaBrilhante@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 3, 'Risque Rabisque', 'RisqueRabisque@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 3, 'Santo Antonio', 'SantoAntonio@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 3, 'Tabacaria Encantado', 'TabacariaEncantado@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 3, 'Era do Papel', 'EradoPapel@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 3, 'clip pelotas', 'Clippelotas@redeclip.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 7, 'moda da hora', 'modadahora@modadahora.com.br', 't0183m1234', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 7, 'vera regina', 'vera@modadahora.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 8, 'Peimage Teste', 'teste@peimage.com.br', '12345', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 11, 'rede paper', 'maranatars@hotmail.com', '12345', '', '', NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `arquivos`
--
ALTER TABLE `arquivos`
  ADD PRIMARY KEY (`idarquivos`),
  ADD KEY `arquivos_fklayouts` (`fklayouts`),
  ADD KEY `arquivos_fkcampanhas` (`fkcampanhas`);

--
-- Índices para tabela `campanhas`
--
ALTER TABLE `campanhas`
  ADD PRIMARY KEY (`idcampanhas`),
  ADD KEY `campanhas_fkempresas` (`fkempresas`);

--
-- Índices para tabela `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`idempresas`);

--
-- Índices para tabela `estatisticas`
--
ALTER TABLE `estatisticas`
  ADD PRIMARY KEY (`idestatisticas`),
  ADD KEY `estatisticas_fktemas` (`fktemas`),
  ADD KEY `estatisticas_fkusuarios` (`fkusuarios`);

--
-- Índices para tabela `layouts`
--
ALTER TABLE `layouts`
  ADD PRIMARY KEY (`idlayouts`),
  ADD UNIQUE KEY `layouts_nome_fkempresas_un` (`nome`,`fkempresas`),
  ADD KEY `layouts_fkemrpesas` (`fkempresas`);

--
-- Índices para tabela `layouts_campanha`
--
ALTER TABLE `layouts_campanha`
  ADD PRIMARY KEY (`idlayouts_campanha`),
  ADD UNIQUE KEY `layouts_campanha_fk_campanhas_fk_layouts_un` (`fkcampanhas`,`fklayouts`),
  ADD KEY `layouts_campanha_fklayouts` (`fklayouts`),
  ADD KEY `layouts_campanha_fkcampanhas` (`fkcampanhas`);

--
-- Índices para tabela `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`idposts`),
  ADD KEY `posts_fkusuarios` (`fkarquivos`),
  ADD KEY `posts_fkarquivos` (`fkusuarios`);

--
-- Índices para tabela `temas`
--
ALTER TABLE `temas`
  ADD PRIMARY KEY (`idtemas`),
  ADD KEY `temas_fklayouts_campanha` (`fklayouts_campanha`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuarios`),
  ADD UNIQUE KEY `usuarios_email_un` (`email`),
  ADD KEY `usuarios_fkempresas` (`fkempresas`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `arquivos`
--
ALTER TABLE `arquivos`
  MODIFY `idarquivos` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `campanhas`
--
ALTER TABLE `campanhas`
  MODIFY `idcampanhas` int(15) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `empresas`
--
ALTER TABLE `empresas`
  MODIFY `idempresas` int(15) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `estatisticas`
--
ALTER TABLE `estatisticas`
  MODIFY `idestatisticas` int(15) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de tabela `layouts`
--
ALTER TABLE `layouts`
  MODIFY `idlayouts` int(15) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `layouts_campanha`
--
ALTER TABLE `layouts_campanha`
  MODIFY `idlayouts_campanha` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de tabela `posts`
--
ALTER TABLE `posts`
  MODIFY `idposts` int(15) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `temas`
--
ALTER TABLE `temas`
  MODIFY `idtemas` int(15) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuarios` int(15) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `arquivos`
--
ALTER TABLE `arquivos`
  ADD CONSTRAINT `arquivos_ibfk_1` FOREIGN KEY (`fklayouts`) REFERENCES `layouts` (`idlayouts`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `arquivos_ibfk_2` FOREIGN KEY (`fkcampanhas`) REFERENCES `campanhas` (`idcampanhas`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `campanhas`
--
ALTER TABLE `campanhas`
  ADD CONSTRAINT `campanhas_ibfk_1` FOREIGN KEY (`fkempresas`) REFERENCES `empresas` (`idempresas`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `estatisticas`
--
ALTER TABLE `estatisticas`
  ADD CONSTRAINT `estatisticas_ibfk_1` FOREIGN KEY (`fktemas`) REFERENCES `temas` (`idtemas`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `estatisticas_ibfk_2` FOREIGN KEY (`fkusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `layouts`
--
ALTER TABLE `layouts`
  ADD CONSTRAINT `layouts_ibfk_1` FOREIGN KEY (`fkempresas`) REFERENCES `empresas` (`idempresas`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `layouts_campanha`
--
ALTER TABLE `layouts_campanha`
  ADD CONSTRAINT `layouts_campanha_ibfk_1` FOREIGN KEY (`fklayouts`) REFERENCES `layouts` (`idlayouts`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `layouts_campanha_ibfk_2` FOREIGN KEY (`fkcampanhas`) REFERENCES `campanhas` (`idcampanhas`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`fkarquivos`) REFERENCES `arquivos` (`idarquivos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`fkusuarios`) REFERENCES `usuarios` (`idusuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `temas`
--
ALTER TABLE `temas`
  ADD CONSTRAINT `temas_ibfk_1` FOREIGN KEY (`fklayouts_campanha`) REFERENCES `layouts_campanha` (`idlayouts_campanha`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`fkempresas`) REFERENCES `empresas` (`idempresas`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
