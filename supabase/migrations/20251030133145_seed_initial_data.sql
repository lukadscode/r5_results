/*
  # Données initiales pour tests

  ## Contenu
  - Création d'une ligue de test
  - Création d'un établissement de test  
  - Création d'une saison active
  - Données de test pour Padlet
*/

-- Insérer une ligue de test
INSERT INTO ligues (id, name, code, region)
VALUES 
  ('00000000-0000-0000-0000-000000000001', 'Ligue Île-de-France', 'IDF', 'Île-de-France')
ON CONFLICT (id) DO NOTHING;

-- Insérer un établissement de test
INSERT INTO etablissements (id, name, type, ligue_id, city, postal_code)
VALUES 
  ('00000000-0000-0000-0000-000000000002', 'Collège Test', 'COLLEGE', '00000000-0000-0000-0000-000000000001', 'Paris', '75001')
ON CONFLICT (id) DO NOTHING;

-- Insérer une saison active
INSERT INTO saisons (id, name, start_date, end_date, is_active)
VALUES 
  ('00000000-0000-0000-0000-000000000003', '2024-2025', '2024-09-01', '2025-06-30', true)
ON CONFLICT (id) DO NOTHING;

-- Thèmes Padlet de démonstration
INSERT INTO padlet_themes (id, title, description, icon, color, display_order, is_visible)
VALUES 
  ('00000000-0000-0000-0000-000000000010', 'Techniques d''Aviron', 'Apprenez les techniques de base et avancées de l''aviron', '🚣', '#3B82F6', 1, true),
  ('00000000-0000-0000-0000-000000000011', 'Sécurité sur l''Eau', 'Règles et bonnes pratiques pour pratiquer en toute sécurité', '🦺', '#EF4444', 2, true),
  ('00000000-0000-0000-0000-000000000012', 'Matériel', 'Découvrez les bateaux et équipements', '⛵', '#10B981', 3, true)
ON CONFLICT (id) DO NOTHING;

-- Sous-thèmes Padlet
INSERT INTO padlet_subthemes (id, theme_id, title, description, display_order, is_visible)
VALUES 
  ('00000000-0000-0000-0000-000000000020', '00000000-0000-0000-0000-000000000010', 'La Prise de Rame', 'Comment tenir et manier correctement la rame', 1, true),
  ('00000000-0000-0000-0000-000000000021', '00000000-0000-0000-0000-000000000010', 'Le Mouvement de Base', 'Décomposition du geste d''aviron', 2, true),
  ('00000000-0000-0000-0000-000000000022', '00000000-0000-0000-0000-000000000011', 'Équipement de Sécurité', 'Ce qu''il faut toujours avoir avec soi', 1, true)
ON CONFLICT (id) DO NOTHING;

-- Contenus Padlet  
INSERT INTO padlet_content (id, subtheme_id, title, content_type, text_content, is_published, display_order)
VALUES 
  (
    '00000000-0000-0000-0000-000000000030', 
    '00000000-0000-0000-0000-000000000020', 
    'Les Différentes Prises', 
    'TEXT',
    E'Il existe plusieurs façons de tenir une rame en aviron :\n\n1. **La prise classique** : Les mains sont espacées d''environ 30 cm sur le manche de la rame.\n\n2. **La prise serrée** : Utilisée pour plus de contrôle dans les manœuvres délicates.\n\n3. **La prise large** : Pour développer plus de puissance sur les coups longs.\n\nL''important est de garder les poignets droits et les doigts bien enroulés autour du manche.',
    true,
    1
  ),
  (
    '00000000-0000-0000-0000-000000000031', 
    '00000000-0000-0000-0000-000000000022', 
    'Le Gilet de Sauvetage', 
    'TEXT',
    E'Le port du gilet de sauvetage est **OBLIGATOIRE** pour tous les rameurs, quel que soit leur niveau.\n\nCaractéristiques d''un bon gilet :\n- Certifié CE\n- Bien ajusté au corps\n- N''entrave pas les mouvements\n- Coloré pour être visible',
    true,
    1
  )
ON CONFLICT (id) DO NOTHING;
