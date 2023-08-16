<?php

namespace App\Controller;

use App\Entity\Calendar;
use App\Entity\Chambre;
use App\Form\CalendarType;
use App\Repository\CalendarRepository;
use App\Repository\ChambreRepository;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ChambreRepository $chambreRepository): Response
    {
        return $this->render('home/index.html.twig',[
            "chambres"=>$chambreRepository->findBy([],["id"=>"ASC"])
        ]);
    }
    #[Route('/planning', name: 'app_planning')]
    public function planning(CalendarRepository $calendarRepository): Response
    {

        $calendars=$calendarRepository->findAll();
        foreach ($calendars as $calendar){
            $data=[
                'id'=>$calendar->getId(),
                'start'=>$calendar->getStart()->format('Y-m-d H:i'),
                'end'=>$calendar->getEndReversed()->format('Y-m-d H:i'),
                'title'=>$calendar->getTitle() .' '.$calendar->getChambre()->getName().' montant $ '.$calendar->getPrice(),
                'statue'=>$calendar->getStatut(),
                'color'=>$calendar->getChambre()->getColor()
            ];
            $datas[] = $data;
        }
        if (empty($datas)){
            $datas=[""];
        }

        $json=json_encode($datas);

        return $this->render('home/planning.html.twig',[
            'json'=>$json
        ]);
    }
    #[Route('/reservation/{id}', name: 'app_calendar_new', methods: ['GET', 'POST'])]
    public function new(Request $request,Chambre $chambre, EntityManagerInterface $entityManager): Response
    {
        $calendar = new Calendar();
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $chambresReservation=$chambre->getReservation();
            $dateDebut = Carbon::parse($calendar->getStart());
            $dateFin = Carbon::parse($calendar->getEndReversed());
            $differenceJours = $dateFin->diffInDays($dateDebut);
            foreach ($chambresReservation as  $value){
                $messageErreur = "la chambre ".$chambre->getName()." est deja reserve a cette date";
                if ($calendar->getStart()>=$value->getStart()&&$calendar->getStart()<$value->getEndReversed()){
                    return new Response($messageErreur, Response::HTTP_BAD_REQUEST);
                }
                if ($calendar->getEndReversed()>=$value->getStart()&&$calendar->getEndReversed()<=$value->getEndReversed()){
                    return new Response($messageErreur, Response::HTTP_BAD_REQUEST);
                }
            }

            $calendar->setPrice($chambre->getPrice()*$differenceJours);
            $calendar->setChambre($chambre);
            $entityManager->persist($calendar);
            $entityManager->flush();
            return $this->redirectToRoute('app_planning', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('home/reservation.html.twig', [
            'calendar' => $calendar,
            'form' => $form,
        ]);
    }


}
