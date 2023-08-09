<?php

namespace App\Controller;

use App\Repository\CalendarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CalendarRepository $calendarRepository): Response
    {
        $calendars=$calendarRepository->findAll();
        foreach ($calendars as $calendar){
            $data=[
                'id'=>$calendar->getId(),
                'start'=>$calendar->getStart()->format('Y-m-d H:i'),
                'end'=>$calendar->getEndReversed()->format('Y-m-d H:i'),
                'title'=>$calendar->getTitle(),
                'statue'=>$calendar->getStatut(),

            ];
            $datas[] = $data;
        }
        $json=json_encode($datas);
        return $this->render('home/index.html.twig',[
            'json'=>$json
        ]);
    }
}
