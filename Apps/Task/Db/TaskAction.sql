CREATE TABLE IF NOT EXISTS `TaskAction` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`TaskId` INT  NULL ,
`Libelle` TEXT  NULL ,
`Realised` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `TaskTask_TaskAction` FOREIGN KEY (`TaskId`) REFERENCES `TaskTask`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 