<?php

namespace App\Controller;

/*
 * @name \App\Controller\AdminController
 */

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdminController extends AbstractController {
    /**
     * Require ROLE ADMIN for only this controller method.
     *
     * @IsGranted("ROLE_ADMIN")
     */
    public function adminDashboard(){
        echo ('Your admin');
    }
}