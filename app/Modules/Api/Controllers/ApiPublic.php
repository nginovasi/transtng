<?php namespace App\Modules\Api\Controllers;

use App\Core\BaseController;
use App\Modules\Api\Models\ApiModel;

class ApiPublic extends BaseController
{
    private $publikModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->apiModel = new ApiModel();
    }

    public function privacy()
    {
        return view('App\Modules\Api\Views\privacy');
       
    }

    public function terms()
    {
        return view('App\Modules\Api\Views\principles');
    }

    public function about()
    {
        return view('App\Modules\Api\Views\about');
    }

    public function faq()
    {
        return view('App\Modules\Api\Views\faq');
    }

   
}
