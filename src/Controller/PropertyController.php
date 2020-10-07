<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/biens", name="property.index")
     * @return Response
     */
    public function index(): Response
    // On peut directement faire l'injection de dépendance (autowiring) ici
    // public function index(PropertyRepository $repository): Response
    {
        // $property = new Property;
        // $property->setTitle('Mon premier bien')
        //     ->setPrice(200000)
        //     ->setRooms(4)
        //     ->setBedrooms(3)
        //     ->setDescription('Une petite description')
        //     ->setSurface(60)
        //     ->setFloor(4)
        //     ->setHeat(1)
        //     ->setCity('Montpellier')
        //     ->setAddress('15 Boulevard Gambetta')
        //     ->setPostalCode('34000');
        // $em = $this->getDoctrine()->getManager();
        // $em->persist($property);
        // $em->flush();
        // return new Response('Les biens');


        // Sans injection de dépendance
        // $repository = $this->getDoctrine()->getRepository(Property::class);
        // dump($repository);

        // Avec injection de dépendance (constructeur)
        // $property = $this->repository->find(1);
        // $property = $this->repository->findAll();
        // $property = $this->repository->findOneBy(['floor' => 4]);
        // $property = $this->repository->findAllVisible();
        // dump($property);
        // $property[0]->setSold(true);
        // $this->em->flush();

        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param $slug
     * @param $id
     * @param Property $property
     * @return Response
     */
    // public function show($slug, $id): Response
    public function show(Property $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug(),
            ], 301);
        }
        // $property = $this->repository->find($id);
        return $this->render('property/show.html.twig', [
            'current_menu' => 'properties',
            'property' => $property
        ]);
    }
}
