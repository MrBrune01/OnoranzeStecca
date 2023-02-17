-- Adminer 4.8.1 MySQL 5.5.5-10.6.7-MariaDB-1:10.6.7+maria~focal dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`username`),
  CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `admin` (`username`) VALUES
('admin');

DROP TABLE IF EXISTS `cordoglio`;
CREATE TABLE `cordoglio` (
  `username` varchar(255) NOT NULL,
  `message` varchar(500) NOT NULL,
  `dead_id` int(11) NOT NULL,
  PRIMARY KEY (`dead_id`,`username`),
  KEY `cordoglio_ibfk_2` (`username`),
  CONSTRAINT `cordoglio_ibfk_1` FOREIGN KEY (`dead_id`) REFERENCES `dead` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cordoglio_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `cordoglio` (`username`, `message`, `dead_id`) VALUES
('Admin',	'Ti ringraziamo per tutti i bei ricordi che ci hai lasciato.',	1),
('Dante',	'Mi dispiace molto.',	1),
('Giovanni',	'Il mondo è stato reso un posto peggiore dalla tua perdita.',	1),
('user',	'La tua famiglia è nelle nostre preghiere.',	1),
('Admin',	'La tua perdita ci ha colpiti profondamente.',	2),
('Dante',	'Siamo veramente dispiaciuti per la tua perdita.',	2),
('Giovanni',	'Le nostre preghiere sono con te e con la tua famiglia in questo difficile momento.',	2),
('user',	'Mi dispiace molto',	2),
('Admin',	'La tua memoria vivrà attraverso l amore che hai diffuso intorno a te.',	3),
('Dante',	'La tua famiglia è nelle nostre preghiere.',	3),
('Giovanni',	'Il tuo sorriso e la tua presenza ci mancheranno sempre.',	3),
('user',	'Siamo qui per sostenerti in questo difficile momento.',	3),
('Admin',	'Ti ringraziamo per tutti i bei ricordi che ci hai lasciato.',	4),
('Dante',	'Mi dispiace molto.',	4),
('Giovanni',	'Il mondo è stato reso un posto peggiore dalla tua perdita.',	4),
('user',	'La tua famiglia è nelle nostre preghiere.',	5),
('Admin',	'La tua perdita ci ha colpiti profondamente.',	5),
('Dante',	'Siamo veramente dispiaciuti per la tua perdita.',	5),
('Giovanni',	'Le nostre preghiere sono con te e con la tua famiglia in questo difficile momento.',	5),
('Admin',	'La tua memoria vivrà attraverso l amore che hai diffuso intorno a te.',	6),
('Dante',	'La tua famiglia è nelle nostre preghiere.',	6),
('Giovanni',	'Il tuo sorriso e la tua presenza ci mancheranno sempre.',	6),
('user',	'Siamo qui per sostenerti in questo difficile momento.',	6),
('Dante',	'Ti preghiamo di accettare le nostre più sentite condoglianze.',	7),
('Giovanni',	'Mi dispiace molto',	7),
('user',	'La tua anima brillerà per sempre nei nostri cuori.',	7),
('Dante',	'La tua famiglia è nelle nostre preghiere.',	8),
('Giovanni',	'Il tuo sorriso e la tua presenza ci mancheranno sempre.',	8),
('user',	'Siamo qui per sostenerti in questo difficile momento.',	8),
('Admin',	'Ti ringraziamo per tutti i bei ricordi che ci hai lasciato.',	8),
('Giovanni',	'Il mondo è stato reso un posto peggiore dalla tua perdita.',	9),
('user',	'La tua famiglia è nelle nostre preghiere.',	9),
('Admin',	'La tua perdita ci ha colpiti profondamente.',	10),
('Dante',	'Siamo veramente dispiaciuti per la tua perdita.',	10),
('Dante',	'Il tuo amore e il tuo supporto ci mancheranno molto.',	11),
('Giovanni',	'La tua perdita ci ha colpiti profondamente.',	11),
('user',	'La tua anima brillerà per sempre nei nostri cuori.',	11),
('Dante',	'Il tuo amore e il tuo supporto ci mancheranno molto.',	12),
('Giovanni',	'La tua perdita ci ha colpiti profondamente.',	12),
('user',	'La tua anima brillerà per sempre nei nostri cuori.',	12);

DROP TABLE IF EXISTS `dead`;
CREATE TABLE `dead` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `born_date` date NOT NULL,
  `death_date` date NOT NULL,
  `reminder_phrase` varchar(500) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `dead` (`id`, `name`, `surname`, `born_date`, `death_date`, `reminder_phrase`, `img`) VALUES
(1,	'Dante',	'Alighieri',	'1265-04-14',	'1321-09-13',	'Iura Monarchiae, Superos, Phlegetonta lacusque Lustrando cecini, voluerunt fata quousque. Sed quia pars cessit melioribus hospita castris Actoremque suum petiit felicior astris, Hic claudor Dantes, patriis extorris ab oris, Quem genuit parvi Florentia mater amoris.',	'necrologio/1321-09-13DanteAlighieri.webp'),
(2,	'Francesco',	'Petrarca',	'1304-07-20',	'1374-07-19',	'Un buon nome per me, una scelta di vergogna, salva i tempi due scansioni, lo studio era una pagina sacra. Ha descritto a mio figlio che erano a disagio al matrimonio. una vedova raccoglie quel frutto, una vergine raccoglie per se stessa.',	'necrologio/1374-07-19FrancescoPetrarca.webp'),
(3,	'Giovanni',	'Boccaccio',	'1313-06-16',	'1375-12-21',	'Poeta graziosissimo, in un tempo che il fiorente popolo di Firenze portava questa grazia, maravigliandosi della festa del genio e dell abbondanza dell invenzione, per ricordare vivacità dell aria',	'necrologio/1375-12-21GiovanniBoccaccio.webp'),
(4,	'Alessandro',	'Volta',	'1745-02-18',	'1827-03-05',	'Il padre dell\'elettricità, ha rivoluzionato il mondo con la sua invenzione della pila elettrica, che ha permesso di generare corrente elettrica in modo continuo e stabile. Le sue scoperte hanno dato il via a una nuova era di progresso scientifico.',	'necrologio/1827-03-05AlessandroVolta.webp'),
(5,	'Enrico',	'Fermi',	'1901-09-29',	'1954-11-28',	'È stato uno dei più grandi fisici del XX secolo, noto soprattutto per le sue scoperte nel campo della fisica nucleare. Ha sviluppato il primo reattore nucleare controllato e ha lavorato alla prima bomba atomica, ma è anche conosciuto per la sua attività di insegnamento e per i suoi contributi alla teoria dei quanti. La sua intelligenza e il suo lavoro hanno influenzato profondamente la scienza e la tecnologia moderna.',	'necrologio/1954-11-28EnricoFermi.webp'),
(6,	'Nikola',	'Tesla',	'1856-06-10',	'1943-01-07',	'È stato un inventore e scienziato che ha fatto importanti contributi alla tecnologia dell\'elettricità e dei campi elettromagnetici. Le sue invenzioni hanno permesso lo sviluppo di importanti tecnologie, come la radio e i motori a corrente alternata, e sono ancora oggi fondamentali per il funzionamento della nostra società moderna.',	'necrologio/1943-01-07NikolaTesla.webp'),
(7,	'Elena Lucrezia',	'Corner',	'1646-06-05',	'1684-06-26',	'Una donna di grande intelligenza e coraggio, Elena Lucrezia Corner Piscopia ha dimostrato che le donne possono raggiungere grandi traguardi, anche quando la società non è pronta ad accettarlo',	'necrologio/1684-06-26ElenaLucreziaCorner.webp'),
(8,	'Laura',	'Bassi',	'1711-10-29',	'1778-02-20',	'Una donna d\'eccezione, una scienziata di talento: Laura Maria Caterina Bassi Veratti ha saputo dimostrare che l\'intelligenza e la determinazione possono superare ogni barriera.',	'necrologio/1778-02-20LauraBassi.webp'),
(9,	'Galileo',	'Galilei',	'1564-02-15',	'1642-01-08',	'Ha sfidato le convenzioni e ha portato alla luce nuove verità, aprendo la strada a una nuova era di scienza e conoscenza. La sua ricerca senza paura ha ispirato generazioni di scienziati a seguire i loro sogni e a cercare la verità.',	'necrologio/1642-01-08GalileoGalilei.webp'),
(10,	'Guglielmo',	'Marconi',	'1874-04-25',	'1937-07-20',	'un visionario che ha cambiato il mondo con la sua innovazione. Ha portato la tecnologia radio a un livello completamente nuovo, aprendo la strada a una nuova era di comunicazione senza limiti. La sua visione ha ispirato generazioni di innovatori e creatori.',	'necrologio/1937-07-20GuglielmoMarconi.webp'),
(11,	'Vito',	'Volterra',	'1860-05-03',	'1940-10-11',	'Una storia di passione, dedizione e innovazione nella scienza matematica.',	'necrologio/1940-10-11VitoVolterra.webp'),
(12,	'Leonardo',	'Fibonacci',	'1170-07-01',	'1242-12-07',	'Uno dei più grandi matematici della storia,\r\nche ha introdotto i numeri arabi al mondo occidentale.\r\nLa sua famosa sequenza di Fibonacci ha ispirato generazioni di scienziati.\r\nUn uomo che ha cambiato il modo in cui vediamo il mondo.',	'necrologio/1242-12-07LeonardoFibonacci.webp');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `username` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`username`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `user` (`username`, `mail`, `password`) VALUES
('admin',	'admin@gmail.com',	'8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918'),
('dante',	'dante@gmail.com',	'8e35c2cd3bf6641bdb0e2050b76932cbb2e6034a0ddacc1d9bea82a6ba57f7cf'),
('giovanni',	'giovanni@gmail.com',	'4813494d137e1631bba301d5acab6e7bb7aa74ce1185d456565ef51d737677b2'),
('user',	'user@gmail.com',	'04f8996da763b7a969b1028ee3007569eaf3a635486ddab211d512c85b9df8fb');

-- 2023-02-01 18:08:04
