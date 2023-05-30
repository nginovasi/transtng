<?php namespace App\Modules\Main\Controllers;

use App\Core\BaseController;
use App\Modules\Main\Models\MainModel;

class Main extends BaseController
{
    private $mainModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->mainModel = new MainModel();
    }

    public function index()
    {
        return view('App\Modules\Main\Views\layout');
    }

    public function test()
    {
        return view('App\Modules\Main\Views\test');
    }
}
