<?php
namespace Nibiru;
/**
 * Class    errorController
 * @project prod.maschinen-stockert.de
 * @desc    Soft 404 error page handler for unreachable pages
 * @author  Claude Code / Stephan Kasdorf
 * @date    Dec 16 2024
 * @package Nibiru
 */

use Nibiru\Adapter\Controller;
use Nibiru\Module\{
    Assetmanager\Plugins\Assetmanager,
    Cms\Plugins\Cms,
    Errorhandler\Plugins\Errorhandler
};

class errorController extends Controller
{
    private string $requestedUri = '';

    public function __construct()
    {
        // Store the originally requested URI before routing to error
        $this->requestedUri = $_SERVER['REQUEST_URI'] ?? '/';
    }

    public function pageAction()
    {
        // Set HTTP status code to 404 (while still rendering the page - soft 404)
        http_response_code(404);

        // Assign error-specific variables
        View::assign([
            'requestedUri' => htmlspecialchars($this->requestedUri, ENT_QUOTES, 'UTF-8'),
            'errorCode' => '404',
            'errorTitle' => 'Seite nicht gefunden',
            'errorMessage' => 'Die angeforderte Seite konnte leider nicht gefunden werden.',
            'errorSuggestion' => 'Die Seite wurde möglicherweise verschoben, gelöscht oder existiert nicht mehr.',
            'metaRobots' => 'noindex, follow',
            'homeUrl' => '/',
            'contactUrl' => '/kontakt',
            'machinesUrl' => '/maschinen'
        ]);
    }

    public function navigationAction()
    {
        JsonNavigation::getInstance()->loadJsonNavigationArray();
    }
}
