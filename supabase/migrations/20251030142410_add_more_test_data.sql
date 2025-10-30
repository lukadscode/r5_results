/*
  # Ajout de données de test supplémentaires
  
  1. Ajout de ligues supplémentaires
  2. Ajout de clubs d'aviron
  3. Ajout de collèges supplémentaires
*/

-- Ajout de ligues
INSERT INTO ligues (id, name, code, region) VALUES
  ('00000000-0000-0000-0000-000000000002', 'Ligue Bretagne', 'BRE', 'Bretagne'),
  ('00000000-0000-0000-0000-000000000003', 'Ligue Normandie', 'NOR', 'Normandie'),
  ('00000000-0000-0000-0000-000000000004', 'Ligue Provence-Alpes-Côte d''Azur', 'PACA', 'Provence-Alpes-Côte d''Azur')
ON CONFLICT (id) DO NOTHING;

-- Ajout de clubs d'aviron
INSERT INTO etablissements (id, name, type, ligue_id, city, postal_code) VALUES
  ('00000000-0000-0000-0000-000000000003', 'Aviron Club Paris', 'CLUB', '00000000-0000-0000-0000-000000000001', 'Paris', '75016'),
  ('00000000-0000-0000-0000-000000000004', 'Société Nautique de la Marne', 'CLUB', '00000000-0000-0000-0000-000000000001', 'Nogent-sur-Marne', '94130'),
  ('00000000-0000-0000-0000-000000000005', 'Rowing Club de France', 'CLUB', '00000000-0000-0000-0000-000000000001', 'Neuilly-sur-Seine', '92200'),
  ('00000000-0000-0000-0000-000000000006', 'Aviron Rennais', 'CLUB', '00000000-0000-0000-0000-000000000002', 'Rennes', '35000'),
  ('00000000-0000-0000-0000-000000000007', 'Cercle de l''Aviron de Brest', 'CLUB', '00000000-0000-0000-0000-000000000002', 'Brest', '29200'),
  ('00000000-0000-0000-0000-000000000008', 'Aviron Normand', 'CLUB', '00000000-0000-0000-0000-000000000003', 'Rouen', '76000')
ON CONFLICT (id) DO NOTHING;

-- Ajout de collèges
INSERT INTO etablissements (id, name, type, ligue_id, city, postal_code) VALUES
  ('00000000-0000-0000-0000-000000000009', 'Collège Jean Moulin', 'COLLEGE', '00000000-0000-0000-0000-000000000001', 'Paris', '75014'),
  ('00000000-0000-0000-0000-000000000010', 'Collège Victor Hugo', 'COLLEGE', '00000000-0000-0000-0000-000000000001', 'Vincennes', '94300'),
  ('00000000-0000-0000-0000-000000000011', 'Collège Sainte-Marie', 'COLLEGE', '00000000-0000-0000-0000-000000000001', 'Neuilly-sur-Seine', '92200'),
  ('00000000-0000-0000-0000-000000000012', 'Collège François Truffaut', 'COLLEGE', '00000000-0000-0000-0000-000000000002', 'Rennes', '35000'),
  ('00000000-0000-0000-0000-000000000013', 'Collège Jacques Prévert', 'COLLEGE', '00000000-0000-0000-0000-000000000002', 'Brest', '29200'),
  ('00000000-0000-0000-0000-000000000014', 'Collège Gustave Flaubert', 'COLLEGE', '00000000-0000-0000-0000-000000000003', 'Rouen', '76000'),
  ('00000000-0000-0000-0000-000000000015', 'Collège Paul Éluard', 'COLLEGE', '00000000-0000-0000-0000-000000000004', 'Marseille', '13001')
ON CONFLICT (id) DO NOTHING;
