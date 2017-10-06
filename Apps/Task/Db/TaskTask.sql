CREATE TABLE IF NOT EXISTS `TaskTask` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`GroupId` INT  NULL ,
`ParentId` INT  NULL ,
`UserId` INT  NULL ,
`StateId` INT  NULL ,
`Title` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
`DateStart` DATE  NULL ,
`DateEnd` DATE  NULL ,
PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 