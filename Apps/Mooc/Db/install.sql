CREATE TABLE IF NOT EXISTS `MoocCategory` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`Name` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `MoocMooc` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`CategoryId` INT  NULL ,
`Name` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
`DateCreated` DATE  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ee_user_MoocMooc` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`),
CONSTRAINT `MoocCategory_MoocMooc` FOREIGN KEY (`CategoryId`) REFERENCES `MoocCategory`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `MoocLesson` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`MoocId` INT  NULL ,
`Name` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
`Content` TEXT  NULL ,
`Video` TEXT  NULL ,
`Actif` int(1)  NULL
PRIMARY KEY (`Id`),
CONSTRAINT `MoocMooc_MoocLesson` FOREIGN KEY (`MoocId`) REFERENCES `MoocMooc`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `MoocLessonElement` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`LessonId` INT  NULL ,
`TypeId` INT  NULL ,
`Description` TEXT  NULL ,
`Url` TEXT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `MoocLesson_MoocLessonElement` FOREIGN KEY (`LessonId`) REFERENCES `MoocLesson`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `MoocMoocUser` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`MoocId` INT  NULL ,
`UserId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `MoocMooc_MoocMoocUser` FOREIGN KEY (`MoocId`) REFERENCES `MoocMooc`(`Id`),
CONSTRAINT `ee_user_MoocMoocUser` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 