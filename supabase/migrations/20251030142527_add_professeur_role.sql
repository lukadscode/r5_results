/*
  # Ajout du rôle PROFESSEUR
  
  1. Modifications
    - Ajoute la valeur PROFESSEUR à l'enum user_role
    
  Note: PROFESSEUR est différent de COACH car il enseigne dans un collège, 
  tandis que COACH travaille dans un club d'aviron
*/

ALTER TYPE user_role ADD VALUE IF NOT EXISTS 'PROFESSEUR';
