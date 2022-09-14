<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class ProduitFixtures extends Fixture /*implements FixtureGroupInterface*/
{
    public function load(ObjectManager $manager): void
    {
        $tabProduit = [
            [
                "label" => "Manteau noir",
                "prix" => 55.75,
                "desc" => "Manteau noir conton 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Cras volutpat eros non lorem hendrerit finibus. Nullam dapibus sem quis risus ornare, 
                 nec commodo enim luctus.",
                "img" => "manteau-631c8c70bdfa6.jpg",
                "qty" => 5,
                "categorie" => ["Manteau"]
            ],
            [
                "label" => "fourrure",
                "prix" => 134.95,
                "desc" => "Fourrure claire ... 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Cras volutpat eros non lorem hendrerit finibus. Nullam dapibus sem quis risus ornare, 
                 nec commodo enim luctus.",
                "img" => "manteau-631c8c70bdfa7.jpg",
                "qty" => 15,
                "categorie" => ["Manteau"]
            ],
            [
                "label" => "Manteau beige",
                "prix" => 75.99,
                "desc" => "Manteau beige ... 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Cras volutpat eros non lorem hendrerit finibus. Nullam dapibus sem quis risus ornare, 
                 nec commodo enim luctus.",
                "img" => "manteau-631c8c70bdfa8.jpg",
                "qty" => 23,
                "categorie" => ["Manteau"]
            ],
            [
                "label" => "Manteau gris",
                "prix" => 39.99,
                "desc" => "Manteau gris ... 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Cras volutpat eros non lorem hendrerit finibus. Nullam dapibus sem quis risus ornare, 
                 nec commodo enim luctus.",
                "img" => "manteau-631c8c70bdfa9.jpg",
                "qty" => 12,
                "categorie" => ["Manteau"]
            ],
            [
                "label" => "Manteau rouge",
                "prix" => 49.99,
                "desc" => "Manteau rouge ... 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Cras volutpat eros non lorem hendrerit finibus. Nullam dapibus sem quis risus ornare, 
                 nec commodo enim luctus.",
                "img" => "manteau-631c8c70bdfa10.jpg",
                "qty" => 102,
                "categorie" => ["Manteau"]
            ],
            [
                "label" => "Manteau",
                "prix" => 499.99,
                "desc" => "Manteau  ... 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Cras volutpat eros non lorem hendrerit finibus. Nullam dapibus sem quis risus ornare, 
                 nec commodo enim luctus.",
                "img" => "manteau-631c8c70bdfa11.jpg",
                "qty" => 7,
                "categorie" => ["Manteau"]
            ],
            [
                "label" => "Manteau à col",
                "prix" => 235.39,
                "desc" => "Manteau  ... 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Cras volutpat eros non lorem hendrerit finibus. Nullam dapibus sem quis risus ornare, 
                 nec commodo enim luctus.",
                "img" => "manteau-631c8c70bdfa14.jpg",
                "qty" => 34,
                "categorie" => ["Manteau"]
            ],
            [
                "label" => "jean effet usé",
                "prix" => 25.39,
                "desc" => "jean  ... 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Cras volutpat eros non lorem hendrerit finibus. Nullam dapibus sem quis risus ornare, 
                 nec commodo enim luctus.",
                "img" => "pantalon-631c8c70bdfa1.jpg",
                "qty" => 7,
                "categorie" => ["Pantalon", "Jean"]
            ],
            [
                "label" => "Pantalon",
                "prix" => 52.59,
                "desc" => "Pantalon  ... 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Cras volutpat eros non lorem hendrerit finibus. Nullam dapibus sem quis risus ornare, 
                 nec commodo enim luctus.",
                "img" => "pantalon-631c8c70bdfa2.jpg",
                "qty" => 7,
                "categorie" => ["Pantalon"]
            ],
            [
                "label" => "Jean taille haute",
                "prix" => 72.69,
                "desc" => "Pantalon  ... 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Cras volutpat eros non lorem hendrerit finibus. Nullam dapibus sem quis risus ornare, 
                 nec commodo enim luctus.",
                "img" => "pantalon-631c8c70bdfa3.jpg",
                "qty" => 7,
                "categorie" => ["Pantalon", "Jean"]
            ],
            [
                "label" => "Jean sobre",
                "prix" => 12.20,
                "desc" => "Pantalon  ... 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Cras volutpat eros non lorem hendrerit finibus. Nullam dapibus sem quis risus ornare, 
                 nec commodo enim luctus.",
                "img" => "pantalon-631c8c70bdfa4.jpg",
                "qty" => 7,
                "categorie" => ["Pantalon", "Jean"]
            ],
            [
                "label" => "Jean Femme",
                "prix" => 32.30,
                "desc" => "Pantalon  ... 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Cras volutpat eros non lorem hendrerit finibus. Nullam dapibus sem quis risus ornare, 
                 nec commodo enim luctus.",
                "img" => "pantalon-631c8c70bdfa5.jpg",
                "qty" => 7,
                "categorie" => ["Pantalon", "Jean"]
            ],
            [
                "label" => "Pantalon Homme",
                "prix" => 64.95,
                "desc" => "Pantalon  ... 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Cras volutpat eros non lorem hendrerit finibus. Nullam dapibus sem quis risus ornare, 
                 nec commodo enim luctus.",
                "img" => "pantalon-631c8c70bdfa6.jpg",
                "qty" => 7,
                "categorie" => ["Pantalon"]
            ],
            [
                "label" => "T-shirt Femme",
                "prix" => 6.95,
                "desc" => "T-shirt  ... 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Cras volutpat eros non lorem hendrerit finibus. Nullam dapibus sem quis risus ornare, 
                 nec commodo enim luctus.",
                "img" => "t-shirt-631c8c70bdfa0.jpg",
                "qty" => 7,
                "categorie" => ["T-shirt", "Coton"]
            ],
            [
                "label" => "T-shirt imprimé",
                "prix" => 26.17,
                "desc" => "T-shirt  ... 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Cras volutpat eros non lorem hendrerit finibus. Nullam dapibus sem quis risus ornare, 
                 nec commodo enim luctus.",
                "img" => "t-shirt-631c8c70bdfa1.jpg",
                "qty" => 7,
                "categorie" => ["T-shirt"]
            ],
            [
                "label" => "T-shirt simple",
                "prix" => 4.00,
                "desc" => "T-shirt  ... 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Cras volutpat eros non lorem hendrerit finibus. Nullam dapibus sem quis risus ornare, 
                 nec commodo enim luctus.",
                "img" => "t-shirt-631c8c70bdfa2.jpg",
                "qty" => 7,
                "categorie" => ["T-shirt", "Coton"]
            ],
            [
                "label" => "T-shirt blanc",
                "prix" => 8.55,
                "desc" => "T-shirt  ... 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Cras volutpat eros non lorem hendrerit finibus. Nullam dapibus sem quis risus ornare, 
                 nec commodo enim luctus.",
                "img" => "t-shirt-631c8c70bdfa3.jpg",
                "qty" => 7,
                "categorie" => ["T-shirt", "Coton"]
            ],
            [
                "label" => "T-shirt motif",
                "prix" => 58.95,
                "desc" => "T-shirt  ... 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Cras volutpat eros non lorem hendrerit finibus. Nullam dapibus sem quis risus ornare, 
                 nec commodo enim luctus.",
                "img" => "t-shirt-631c8c70bdfa4.jpg",
                "qty" => 7,
                "categorie" => ["T-shirt"]
            ],
            [
                "label" => "T-shirt long",
                "prix" => 35.99,
                "desc" => "T-shirt  ... 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Cras volutpat eros non lorem hendrerit finibus. Nullam dapibus sem quis risus ornare, 
                 nec commodo enim luctus.",
                "img" => "t-shirt-631c8c70bdfa5.jpg",
                "qty" => 7,
                "categorie" => ["T-shirt"]
            ],
            [
                "label" => "T-shirt coton",
                "prix" => 25.99,
                "desc" => "T-shirt  ... 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Cras volutpat eros non lorem hendrerit finibus. Nullam dapibus sem quis risus ornare, 
                 nec commodo enim luctus.",
                "img" => "t-shirt-631c8c70bdfa6.jpg",
                "qty" => 7,
                "categorie" => ["T-shirt", "Coton"]
            ],
            [
                "label" => "T-shirt glaman",
                "prix" => 125.85,
                "desc" => "T-shirt  ... 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Cras volutpat eros non lorem hendrerit finibus. Nullam dapibus sem quis risus ornare, 
                 nec commodo enim luctus.",
                "img" => "t-shirt-631c8c70bdfa7.jpg",
                "qty" => 7,
                "categorie" => ["T-shirt"]
            ]

        ];
        $categorieRepo = $manager->getRepository(Categorie::class);
        $categorie = $categorieRepo->find(20);
        // dd($categorie);
        for ($i = 0; $i < count($tabProduit); $i++) {
            $product = new Produit();
            $product->setLabel($tabProduit[$i]["label"]);
            $product->setPrix($tabProduit[$i]["prix"]);
            $product->setDescription($tabProduit[$i]["desc"]);
            $product->setImage($tabProduit[$i]["img"]);
            $product->setQuantity($tabProduit[$i]["qty"]);
            $cat = $tabProduit[$i]["categorie"];
            for ($j = 0; $j < count($cat); $j++) {
                $categorie = $categorieRepo->findBy(['nom' => $cat[$j]]);
                $product->addCategory($categorie[0]);
            }
            $manager->persist($product);
        }
        /*
        $product = new Produit();
        $product->setLabel("testFixture");
        $product->setPrix(20.24);
        $product->setDescription("Lorem Ipsum");
        $product->setImage("/pantalon-631c8c70bdfa3.jpg");
        $product->setQuantity(2);
        $categorie = $categorieRepo->findBy(["nom" => "Manteau"]);
        $product->addCategory($categorie[0]);
        $manager->persist($product);
        */

        $manager->flush();
    }

    /*  public static function getGroups(): array
    {
        return ["group2", "Product"];
    }*/
}
