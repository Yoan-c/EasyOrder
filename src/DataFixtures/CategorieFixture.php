<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class CategorieFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $tabCategorie = ['T-shirt', "Pantalon", "Manteau", "Jean", "Coton"];
        $nbCategorie = count($tabCategorie);
        for ($i = 0; $i < $nbCategorie; $i++) {
            $categorie = new Categorie();
            $categorie->setNom($tabCategorie[$i]);
            $manager->persist($categorie);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ["group1", 'Categorie'];
    }
}
