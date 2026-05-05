# INF7

## Formulaire DJ et back-office

1. Importer la base `student_party.sql` située dans `SEANCE 10 AVRIL`.
2. Installer les dépendances Twig :
   ```bash
   composer install
   ```
3. Démarrer un serveur local :
   ```bash
   php -S 127.0.0.1:8000 -t "SEANCE 10 AVRIL"
   ```

### Accès
- Formulaire d'inscription : `http://127.0.0.1:8000/formulaire.php`
- Back-office : `http://127.0.0.1:8000/admin_djs.php`
- API CRUD : `http://127.0.0.1:8000/api_djs.php`

### Authentification
Le back-office et l'API utilisent une authentification HTTP Basic.
Variables d'environnement :
- `DJ_ADMIN_USER` (défaut : `admin`)
- `DJ_ADMIN_PASS` (obligatoire)

### Uploads
Les photos sont enregistrées dans `SEANCE 10 AVRIL/uploads` (permissions 0755 par défaut). Adaptez les permissions/ownership selon votre environnement si vous devez restreindre l'accès ou servir les fichiers différemment.
