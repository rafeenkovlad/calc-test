<?php

namespace App\Controller;

use App\Entity\Country;
use App\Form\CalcType;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CalcController extends AbstractController
{
    private CountryRepository $cRep;

    public function __construct(CountryRepository $cRep) {
        $this->cRep = $cRep;
    }

    /**
     * @Route("/calc", name="app_calc")
     */
    public function index(Request $request)
    {
        $form = $this->createForm(CalcType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->get('Products')->getData();
            $taxNumber = $form->get('taxNumber')->getData();
            $price = $product->getCost();
            $countryCode = preg_replace('/(\w{2})\d{9}/si','$1',  $taxNumber);
            $qb = $this->cRep->createQueryBuilder('c');
            $qb->where($qb->expr()->eq('c.code', ':code'))
                ->setParameter('code', $countryCode);
            $country = $qb->getQuery()->getOneOrNullResult();

            $result = new \stdClass();
            $result->price = $price;
            $result->country = 'Страна покупателя не найдена.';

            if($country instanceof Country) {
                $result->price = $price * (1+$country->getTax()/100);
                $result->country = $country->getName();
            }

            return $this->render('calculator.html.twig', [
                'form' => $form->createView(),
                'country' => $country,
                'price' => $price,
                'result' =>$result
            ]);

        }

        return $this->render('calculator.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
