<?php

namespace App\Controllers;

use App\Models\Classe;
use App\Connection;

class ClasseController
{
    private $classeModel;

    public function __construct()
    {
        $pdo = Connection::getPDO();
        $this->classeModel = new Classe($pdo);
    }

    public function index()
    {
        require dirname(__DIR__, 2) . '/views/classes/index.php';
    }

    public function create()
    {
        require dirname(__DIR__) . '/views/classes/create.php';
    }

    public function store()
    {
        $data = [
            'etablissement_id' => $_POST['etablissement_id'],
            'user_id' => $_POST['user_id'],
            'nom_classe' => $_POST['nom_classe'],
            'representant_nom' => $_POST['representant_nom'],
            'representant_prenom' => $_POST['representant_prenom'],
            'representant_tel' => $_POST['representant_tel'],
            'club_id' => $_POST['club_id'],
        ];
        $this->classeModel->createClass($data);
        header('Location: /classe');
    }

    public function edit()
    {
        require dirname(__DIR__) . '/views/classes/edit.php';
    }

    public function update()
    {
        $id = $_GET['id'];
        $data = [
            'etablissement_id' => $_POST['etablissement_id'],
            'user_id' => $_POST['user_id'],
            'nom_classe' => $_POST['nom_classe'],
            'representant_nom' => $_POST['representant_nom'],
            'representant_prenom' => $_POST['representant_prenom'],
            'representant_tel' => $_POST['representant_tel'],
            'club_id' => $_POST['club_id'],
        ];
        $this->classeModel->updateClass($id, $data);
        header('Location: /classe');
    }

    public function delete()
    {
        $id = $_GET['id'];
        $this->classeModel->deleteClass($id);
        header('Location: /classe');
    }
}
