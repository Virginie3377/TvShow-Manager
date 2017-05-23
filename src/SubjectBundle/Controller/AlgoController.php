<?php

namespace SubjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AlgoController extends Controller
{
    //////////////////////////////////////
    // Complète la fonction suivante //
    //////////////////////////////////////
    //

    public function dateInterval($series)
    {
        $diffTab = [];
        ksort($series);
        $years = array_keys($series);

        for($i=0; $i<sizeof($years)-1; $i++) {
            //$ecart = $year[$i+1] - $year[$i];
            //array_push($diffTab, $ecart);
            $diffTab[] = $years[$i+1] - $years[$i];
        }
       return max($diffTab);
    }
}