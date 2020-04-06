<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Entity\Comment;
use App\Form\BookingType;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    /**
     * @Route("/ads/{slug}/book", name="booking_create")
     * @IsGranted("ROLE_USER")
     */
    public function book(Ad $ad, Request $request, EntityManagerInterface $manager)
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        
        $form->handlerequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user = $this->getUser();

            $booking->setBooker($user)
                    ->setAd($ad);

            //si les dates ne sont pas disponible : erreur
            if(!$booking->isBookableDates()){
                $this->addFlash(
                    'warning',
                    "Les dates que vous avez choisi ne peuvent être réservées : elles sont déjà prises."
                );
            } else{
                $manager->persist($booking);
                $manager->flush();

                return $this->redirectToRoute('booking_show', [
                    'id' => $booking->getId(),
                    'withAlert' => true
                    ]
                );
            }

        }

        return $this->render('booking/book.html.twig', [
            'ad' => $ad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet d'afficher une réservation
     * 
     * @Route("/booking/{id}", name="booking_show")
     *
     * @param Bookin $booking
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function show(Booking $booking, Request $request, EntityManagerInterface $manager){

        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handlerequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user = $this->getUser();

            $comment->setAd($booking->getAd())
                    ->setAuthor($user);

            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre avis a bien été pris en compte."
            );
            
        }

        return $this->render('booking/show.html.twig', [
            'booking' => $booking,
            'form' => $form->createView()
        ]);
    }
}
