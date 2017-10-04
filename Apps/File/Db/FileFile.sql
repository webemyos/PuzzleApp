CREATE TABLE IF NOT EXISTS `FileFile` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`FolderId` INT  NULL ,
`Name` VARCHAR(200) NULL ,
`DateCreated` DATE  NULL ,
`DateModified` DATE  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 