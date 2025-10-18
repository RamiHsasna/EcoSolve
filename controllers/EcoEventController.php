<?php
require_once __DIR__ . "/../models/modelEcoEvent.php";

class EcoEventController
{
    private $model;

    public function __construct()
    {
        $this->model = new ModelEcoEvent();
    }

    public function createEvent(EcoEvent $event)
    {
        return $this->model->createEvent($event);
    }

    public function showEvent(EcoEvent $event)
    {
        echo "<h2>Détails du signalement :</h2>";
        $event->show();
    }
    public function search($ville = null, $categoryId = null)
    {
        return $this->model->searchEvents($ville, $categoryId);
    }
    public function getAllEvents()
    {
        return $this->model->getEvents();
    }
}
