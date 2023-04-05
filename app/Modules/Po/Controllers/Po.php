<?php namespace App\Modules\Po\Controllers;

use App\Core\BaseController;
use App\Modules\Po\Models\PoModel;

class Po extends BaseController
{
    private $poModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->poModel = new PoModel();
    }

    public function poagent()
    {
        return parent::_authView();
    }

    public function poclass()
    {
        return parent::_authView();
    }

    public function manarmada()
    {
        return parent::_authView();
    }
}
