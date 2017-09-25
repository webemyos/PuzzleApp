CREATE TABLE IF NOT EXISTS `MoocLessonElement` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`LessonId` INT  NULL ,
`TypeId` INT  NULL ,
`Description` TEXT  NULL ,
`Url` TEXT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `MoocLesson_MoocLessonElement` FOREIGN KEY (`LessonId`) REFERENCES `MoocLesson`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 