UPDATE layouts SET arquivo = 'digitalInviteCDL' WHERE arquivo = 'actionCreateDigitalInviteCDL';
UPDATE layouts SET arquivo = 'cartazA4' WHERE arquivo = 'actionCreateCartaz';

UPDATE layouts SET fkempresas = 3 WHERE fkempresas != 16;

/*mil coisas*/
INSERT INTO `layouts` (`fkempresas`, `nome`, `arquivo`, `altura`, `largura`, `status_campanha`, `utilizacao`, `font_text`, `desativacao`) VALUES
(13, 'cartaz - padrao', 'cartazA4', 841, 595, 1, 'sem_restricao', NULL, NULL),
(13, 'post - padrao', 'actionCreatePost', 960, 960, 1, 'sem_restricao', NULL, NULL),
(13, 'cartaz - retrato', 'actionCreateCartazRetrato', NULL, NULL, 0, 'sem_restricao', NULL, NULL),
(13, 'cartaz - paisagem', 'actionCreateCartazPaisagem', 0, 0, 0, 'sem_restricao', NULL, NULL),
(13, 'cartaz - aviso', 'actionCreateCartazAviso', NULL, NULL, 0, 'sem_restricao', NULL, NULL),
(13, 'foto', 'actionCreateFoto', NULL, NULL, 0, 'sem_restricao', NULL, NULL),
(13, 'foto - cartaz', 'actionCreateFotoCartaz', 0, 0, 0, 'sem_restricao', NULL, NULL);

/*paper*/
INSERT INTO `layouts` (`fkempresas`, `nome`, `arquivo`, `altura`, `largura`, `status_campanha`, `utilizacao`, `font_text`, `desativacao`) VALUES
(11, 'cartaz - padrao', 'cartazA4', 841, 595, 1, 'sem_restricao', NULL, NULL),
(11, 'post - padrao', 'actionCreatePost', 960, 960, 1, 'sem_restricao', NULL, NULL),
(11, 'cartaz - retrato', 'actionCreateCartazRetrato', NULL, NULL, 0, 'sem_restricao', NULL, NULL),
(11, 'cartaz - paisagem', 'actionCreateCartazPaisagem', 0, 0, 0, 'sem_restricao', NULL, NULL),
(11, 'cartaz - aviso', 'actionCreateCartazAviso', NULL, NULL, 0, 'sem_restricao', NULL, NULL),
(11, 'foto', 'actionCreateFoto', NULL, NULL, 0, 'sem_restricao', NULL, NULL),
(11, 'foto - modelo 1', 'actionCreateFoto1', NULL, NULL, 0, 'sem_restricao', NULL, NULL),
(11, 'foto - modelo 2', 'actionCreateFoto2', NULL, NULL, 0, 'sem_restricao', NULL, NULL),
(11, 'foto - cartaz', 'actionCreateFotoCartaz', 0, 0, 0, 'sem_restricao', NULL, NULL);

/*moda da hora*/
INSERT INTO `layouts` (`fkempresas`, `nome`, `arquivo`, `altura`, `largura`, `status_campanha`, `utilizacao`, `font_text`, `desativacao`) VALUES
(7, 'cartaz - padrao', 'cartazA4', 841, 595, 1, 'sem_restricao', NULL, NULL),
(7, 'post - padrao', 'actionCreatePost', 960, 960, 1, 'sem_restricao', NULL, NULL),
(7, 'cartaz - retrato', 'actionCreateCartazRetrato', NULL, NULL, 0, 'sem_restricao', NULL, NULL),
(7, 'cartaz - paisagem', 'actionCreateCartazPaisagem', 0, 0, 0, 'sem_restricao', NULL, NULL),
(7, 'cartaz - aviso', 'actionCreateCartazAviso', NULL, NULL, 0, 'sem_restricao', NULL, NULL),
(7, 'foto', 'actionCreateFoto', NULL, NULL, 0, 'sem_restricao', NULL, NULL),
(7, 'foto - modelo 1', 'actionCreateFoto1', NULL, NULL, 0, 'sem_restricao', NULL, NULL),
(7, 'foto - modelo 2', 'actionCreateFoto2', NULL, NULL, 0, 'sem_restricao', NULL, NULL),
(7, 'foto - cartaz', 'actionCreateFotoCartaz', 0, 0, 0, 'sem_restricao', NULL, NULL);

/*peimage*/
INSERT INTO `layouts` (`fkempresas`, `nome`, `arquivo`, `altura`, `largura`, `status_campanha`, `utilizacao`, `font_text`, `desativacao`) VALUES
(1, 'cartaz - padrao', 'cartazA4', 841, 595, 1, 'sem_restricao', NULL, NULL),
(1, 'post - padrao', 'actionCreatePost', 960, 960, 1, 'sem_restricao', NULL, NULL),
(1, 'cartaz - retrato', 'actionCreateCartazRetrato', NULL, NULL, 0, 'sem_restricao', NULL, NULL),
(1, 'cartaz - paisagem', 'actionCreateCartazPaisagem', 0, 0, 0, 'sem_restricao', NULL, NULL),
(1, 'cartaz - aviso', 'actionCreateCartazAviso', NULL, NULL, 0, 'sem_restricao', NULL, NULL),
(1, 'foto', 'actionCreateFoto', NULL, NULL, 0, 'sem_restricao', NULL, NULL),
(1, 'foto - modelo 1', 'actionCreateFoto1', NULL, NULL, 0, 'sem_restricao', NULL, NULL),
(1, 'foto - modelo 2', 'actionCreateFoto2', NULL, NULL, 0, 'sem_restricao', NULL, NULL),
(1, 'foto - cartaz', 'actionCreateFotoCartaz', 0, 0, 0, 'sem_restricao', NULL, NULL);