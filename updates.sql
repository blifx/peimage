ALTER TABLE `layouts`
  DROP `utilizacao`,
  DROP `font_text`;

ALTER TABLE `layouts` DROP FOREIGN KEY layouts_ibfk_1;
ALTER TABLE `layouts` DROP INDEX `layouts_nome_fkempresas_un`;
ALTER TABLE `layouts` DROP INDEX `layouts_fkemrpesas`;


CREATE TABLE layouts_empresa (
  idlayouts_empresa INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  fkempresas INTEGER(15) UNSIGNED NOT NULL,
  fklayouts INTEGER(15) UNSIGNED NOT NULL,
  utilizacao TINYINT UNSIGNED NOT NULL,
  PRIMARY KEY(idlayouts_empresa),
  INDEX layouts_empresa_fkempresas_in(fkempresas),
  INDEX layouts_empresa_fklayouts_in(fklayouts)
);

/*----------------------------------------------------------------*/

UPDATE layouts SET arquivo = 'digitalInviteCDL' WHERE arquivo = 'actionCreateDigitalInviteCDL';
UPDATE layouts SET arquivo = 'cartazA4' WHERE arquivo = 'actionCreateCartaz';

/*----------------------------------------------------------------*/

/*Rede clip utiliza os layouts ja existentes*/
INSERT INTO `layouts_empresa` (`idlayouts_empresa`, `fkempresas`, `fklayouts`, `utilizacao`) 
	VALUES 
	(NULL, '3', '1', 1), 
	(NULL, '3', '4', 1), 
	(NULL, '3', '7', 1),
	(NULL, '3', '8', 1),
	(NULL, '3', '9', 1),
	(NULL, '3', '13', 1),
	(NULL, '3', '14', 1),
	(NULL, '3', '15', 1),
	(NULL, '3', '27', 1);

/*----------------------------------------------------------------*/

/*CDL*/
INSERT INTO `layouts_empresa` (`idlayouts_empresa`, `fkempresas`, `fklayouts`, `utilizacao`) 
	VALUES 
	(NULL, '16', '28', 1);


/*----------------------------------------------------------------*/

/*mil coisas*/
INSERT INTO `layouts` (`nome`, `arquivo`, `altura`, `largura`, `status_campanha`, `desativacao`) VALUES ('cartaz - padrao', 'cartazA4', 841, 595, 1, NULL);
INSERT INTO `layouts_empresa` (`fkempresas`, `fklayouts`, `utilizacao`) VALUES ('13', (SELECT MAX(idlayouts) FROM layouts), 1);

INSERT INTO `layouts` (`nome`, `arquivo`, `altura`, `largura`, `status_campanha`, `desativacao`) VALUES ('post - padrao', 'actionCreatePost', 960, 960, 1, NULL);
INSERT INTO `layouts_empresa` (`fkempresas`, `fklayouts`, `utilizacao`) VALUES ('13', (SELECT MAX(idlayouts) FROM layouts), 1);

INSERT INTO `layouts_empresa` (`idlayouts_empresa`, `fkempresas`, `fklayouts`, `utilizacao`) 
	VALUES 
	(NULL, '13', '7', 1),
	(NULL, '13', '8', 1),
	(NULL, '13', '9', 1),
	(NULL, '13', '13', 1)
	(NULL, '13', '27', 1);

/*----------------------------------------------------------------*/

/*paper*/
INSERT INTO `layouts` (`nome`, `arquivo`, `altura`, `largura`, `status_campanha`, `desativacao`) VALUES ('cartaz - padrao', 'cartazA4', 841, 595, 1, NULL);
INSERT INTO `layouts_empresa` (`fkempresas`, `fklayouts`, `utilizacao`) VALUES ('11', (SELECT MAX(idlayouts) FROM layouts), 1);

INSERT INTO `layouts` (`nome`, `arquivo`, `altura`, `largura`, `status_campanha`, `desativacao`) VALUES ('post - padrao', 'actionCreatePost', 960, 960, 1, NULL);
INSERT INTO `layouts_empresa` (`fkempresas`, `fklayouts`, `utilizacao`) VALUES ('11', (SELECT MAX(idlayouts) FROM layouts), 1);

INSERT INTO `layouts_empresa` (`idlayouts_empresa`, `fkempresas`, `fklayouts`, `utilizacao`) 
	VALUES 
	(NULL, '11', '7', 1),
	(NULL, '11', '8', 1),
	(NULL, '11', '9', 1),
	(NULL, '13', '13', 1)
	(NULL, '13', '27', 1);

/*----------------------------------------------------------------*/

/*moda da hora*/
INSERT INTO `layouts` (`nome`, `arquivo`, `altura`, `largura`, `status_campanha`, `desativacao`) VALUES ('cartaz - padrao', 'cartazA4', 841, 595, 1, NULL);
INSERT INTO `layouts_empresa` (`fkempresas`, `fklayouts`, `utilizacao`) VALUES ('7', (SELECT MAX(idlayouts) FROM layouts), 1);

INSERT INTO `layouts` (`nome`, `arquivo`, `altura`, `largura`, `status_campanha`, `desativacao`) VALUES ('post - padrao', 'actionCreatePost', 960, 960, 1, NULL);
INSERT INTO `layouts_empresa` (`fkempresas`, `fklayouts`, `utilizacao`) VALUES ('7', (SELECT MAX(idlayouts) FROM layouts), 1);

INSERT INTO `layouts_empresa` (`idlayouts_empresa`, `fkempresas`, `fklayouts`, `utilizacao`) 
	VALUES 
	(NULL, '7', '7', 1),
	(NULL, '7', '8', 1),
	(NULL, '7', '9', 1),
	(NULL, '13', '13', 1)
	(NULL, '13', '27', 1);

/*----------------------------------------------------------------*/

/*peimage*/
INSERT INTO `layouts` (`nome`, `arquivo`, `altura`, `largura`, `status_campanha`, `desativacao`) VALUES ('cartaz - padrao', 'cartazA4', 841, 595, 1, NULL);
INSERT INTO `layouts_empresa` (`fkempresas`, `fklayouts`, `utilizacao`) VALUES ('1', (SELECT MAX(idlayouts) FROM layouts), 1);

INSERT INTO `layouts` (`nome`, `arquivo`, `altura`, `largura`, `status_campanha`, `desativacao`) VALUES ('post - padrao', 'actionCreatePost', 960, 960, 1, NULL);
INSERT INTO `layouts_empresa` (`fkempresas`, `fklayouts`, `utilizacao`) VALUES ('1', (SELECT MAX(idlayouts) FROM layouts), 1);

INSERT INTO `layouts_empresa` (`idlayouts_empresa`, `fkempresas`, `fklayouts`, `utilizacao`) 
	VALUES 
	(NULL, '1', '7', 1),
	(NULL, '1', '8', 1),
	(NULL, '1', '9', 1),
	(NULL, '13', '13', 1)
	(NULL, '13', '27', 1);


/*-----------------------Bug na tabela layouts_campanhas-----------------------------------------*/

ALTER TABLE `peimage`.`layouts_campanha` DROP INDEX `layouts_campanha_fk_campanhas_fk_layouts_un`, ADD INDEX `layouts_campanha_fk_campanhas_fk_layouts_un` (`fkcampanhas`, `fklayouts`) USING BTREE;


/*Mil coisas*/
UPDATE layouts_campanha SET fklayouts = '29' WHERE idlayouts_campanha = '44';
UPDATE layouts_campanha SET fklayouts = '30' WHERE idlayouts_campanha = '45';

/*Paper*/
UPDATE layouts_campanha SET fklayouts = '31' WHERE idlayouts_campanha = '41';
UPDATE layouts_campanha SET fklayouts = '32' WHERE idlayouts_campanha = '42';

/*Peimage*/
UPDATE layouts_campanha SET fklayouts = '35' WHERE idlayouts_campanha = '53';
UPDATE layouts_campanha SET fklayouts = '36' WHERE idlayouts_campanha = '54';

/*CDL*/
UPDATE layouts_campanha SET fklayouts = '28' WHERE idlayouts_campanha = '78';
UPDATE layouts_campanha SET fklayouts = '28' WHERE idlayouts_campanha = '79';
UPDATE layouts_campanha SET fklayouts = '28' WHERE idlayouts_campanha = '80';
UPDATE layouts_campanha SET fklayouts = '28' WHERE idlayouts_campanha = '83';
UPDATE layouts_campanha SET fklayouts = '28' WHERE idlayouts_campanha = '84';


/*-----------------------Correção campanha blackfriday MilCoisas-----------------------------------------*/
UPDATE `campanhas` SET `desativacao` = '1' WHERE `campanhas`.`idcampanhas` = 45;