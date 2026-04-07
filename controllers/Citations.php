<?php namespace Pensoft\CitationTool\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Citations Backend Controller
 */
class Citations extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
    ];

    /**
     * @var string formConfig file
     */
    public string $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public string $listConfig = 'config_list.yaml';

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Pensoft.CitationTool', 'main-menu-item');
    }
}
