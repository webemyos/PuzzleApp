INSERT INTO ProfilCompetenceCategory (Code, Name)
VALUES
('Administration', 'Administration'),
('Animation', 'Animation'),
('Editorial', 'Éditorial'),
('GestionDeProjet', 'Gestion de projet'),
('MarketingEtCommerce', 'Marketing et commerce'),
('Programmation', 'Programmation et d&nbsp;veloppement'),
('Graphisme', 'Graphisme'),
('ExpertComptable', 'Expert Comptable'),
('AccompagnementEntreprise', 'Accompagnement entreprise');


INSERT INTO ProfilCompetence (Code, Name, CategoryId) 
VALUES
('AdministrateurSiteWeb', 'Administration de site Web', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'Administration' )),
('ExpertSecuriteInformatique', 'Expert en securite informatique', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'Administration' )),

('AnimateurSiteWeb', 'Animateur de site Web', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'Animation' )),
('CommunityManager', 'Community manager', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'Animation' )),

('JournalisteEnLigne', 'Journaliste en ligne', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'Editorial' )),
('ProducteurVideo', 'Producteur video', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'Editorial' )),

('ChefDeProjetFonctionnel', 'Chef de projet fonctionnel', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'GestionDeProjet' )),
('ChefDeProjetTecnique', 'Chef de projet technique', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'GestionDeProjet' )),
('ConcepteurWeb', 'Concepteur web', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'GestionDeProjet' )),

('Business developer', 'Business developer', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'MarketingEtCommerce' )),
('Commercial', 'Commercial', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'MarketingEtCommerce' )),
('Webmarketeur', 'Webmarketeur', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'MarketingEtCommerce' )),

('ArchitecteWeb', 'Architecte Web', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'Programmation' )),
('DeveloppeurMobile', 'Développeur mobile', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'Programmation' )),
('DeveloppeurMultimedia', 'Développeur Multimédia', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'Programmation' )),
('DeveloppeurWeb', 'Développeur web', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'Programmation' )),
('IntegrateurHTML', 'Intégrateur HTML', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'Programmation' )),

('DesignerFlash', 'Designer Flash', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'Graphisme' )),
('Illustrateur3D', 'Illustrateur 3D', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'Graphisme' )),
('Webdesigner', 'Webdesigner', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'Graphisme' )),

('ExpertComptable', 'ExpertComptable', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'ExpertComptable' )),
('AideFinancement', 'AideRechercheFinancement', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'ExpertComptable' )),

('ConseilCreation', 'Conseil création', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'AccompagnementEntreprise' )),
('RealisationEtudeDeMarche', 'Realisation étude de Marche', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'AccompagnementEntreprise' )),
('RealisationBusinnesPlan', 'Realisation de businnes Plan', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'AccompagnementEntreprise' )),
('MontageFinancier', 'Montage Financier', (SELECT Id FROM ProfilCompetenceCategory WHERE Code =  'AccompagnementEntreprise' ));