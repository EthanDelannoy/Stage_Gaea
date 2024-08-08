<?php

namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\String\Slugger\SluggerInterface;

class FormListenerFactory{

    public function __construct( private SluggerInterface $slugger) {
        
    }

    public function autoSlug(string $field):callable { //fonctione pour remplir le slug via le titre 
        return function (PreSubmitEvent $event) use ($field){
            $data = $event->getData();
            if(empty($data['slug'])){ //si il n'y a pas de slug alors
                $slugger = new AsciiSlugger();
                $data['slug'] = strtolower($this->slugger->slug($data[$field]));
                $event->setData($data);
            }
        };
    }

    public function timestamps():callable{
        return function (PostSubmitEvent $event) {
            $data = $event->getData();
            $data->setUpdatedAt(new \DateTimeImmutable()); // remplis le champ updateAt par le jour/heure du moment
            if(!$data->getId()){
                $data->setCreatedAt(new \DateTimeImmutable()); // remplis le champ createdAt par le jour/heure du moment
            }
        };
    }

}