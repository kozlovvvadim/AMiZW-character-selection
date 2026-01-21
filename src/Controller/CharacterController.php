<?php

namespace App\Controller;

use App\Entity\Character;
use App\Form\CharacterType;
use App\Service\CharacterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/characters')]
class CharacterController extends AbstractController
{
    public function __construct(private readonly CharacterService $characterService)
    {
    }

    #[Route('/', name: 'character_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('character/index.html.twig', [
            'characters' => $this->characterService->getAllCharacters(),
        ]);
    }

    #[Route('/new', name: 'character_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $character = new Character();
        $form = $this->createForm(CharacterType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->characterService->createNewCharacter($character);

            $this->addFlash('success', 'Postać została dodana.');

            return $this->redirectToRoute('character_index');
        }

        return $this->render('character/new.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'character_show', methods: ['GET'])]
    public function show(Character $character): Response
    {
        return $this->render('character/show.html.twig', [
           'character' => $character,
        ]);
    }

    #[Route('/{id}/edit', name: 'character_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request): Response
    {
        return $this->render('character/edit.html.twig', [
//            'character' => $character,
//            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'character_delete', methods: ['POST'])]
    public function delete(Request $request): Response
    {
        return $this->redirectToRoute('character_index');
    }
}
