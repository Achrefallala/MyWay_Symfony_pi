<?php

use App\Repository\ContratRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    private $contratRepository;
    private $router;

    public function __construct(ContratRepository $contratRepository, UrlGeneratorInterface $router)
    {
        $this->contratRepository = $contratRepository;
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetDate(CalendarEvent $calendar)
    {
        $startDate = $calendar->getStart();
        $endDate = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // Modify the query to fit to your entity and needs
        // Change booking.beginAt by your start date property
        $contrats = $this->contratRepository
            ->createQueryBuilder('contrat')
            ->where('contrat.date_debut BETWEEN :startDate and :endDate OR contrat.date_fin BETWEEN :startDate and :endDate')
            ->setParameter('startDate', $startDate->format('Y-m-d H:i:s'))
            ->setParameter('endDate', $endDate->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult();

        foreach ($contrats as $contrat) {
            // this create the events with your data (here booking data) to fill calendar
            $contratEvent = new Event(
                $contrat->getPrix(),
                $contrat->getDateDebut(),
                $contrat->getDateFin() // If the end date is null or not defined, a all day event is created.
            );

            $contratEvent->addOption(
                'url',
                $this->router->generate('app_calendar_location_show', [
                    'id' => $contrat->getId(),
                ])
            );

            // finally, add the event to the CalendarEvent to fill the calendar
            $calendar->addEvent($contratEvent);
        }
    }
}
