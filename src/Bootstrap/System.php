<?php


namespace App\Bootstrap;

use App\Components\Routers\AllRouterCompare;
use App\Components\Routers\Dispatcher;
use App\Components\Routers\Printable;
use App\Components\Routers\RouterObject;
use JsonException;
use function Composer\Autoload\includeFile;

/**
 * Class System
 * @package App\Bootstrap
 */
class System
{

    /**
     * @return $this
     */
    public function run(): self
    {
        Application::run();
        return $this;
    }

    /**
     * @return $this
     */
    public function loadRouterWeb(): self
    {
        includeFile('src/Routers/web.php');
        return $this;
    }

    /**
     */
    public function startUp(): void
    {
        $compare = new AllRouterCompare();
        $findRouterObject = $compare->findWillWhichExecute();

        if ($findRouterObject instanceof RouterObject) {
            if ($findRouterObject->getMainRouter()->getView() !== null) {
                echo view($findRouterObject->getMainRouter()->getView());
            } else {
                $this->printable($findRouterObject);
            }
        }
    }


    private function printable(RouterObject $findRouterObject): void
    {
        $routeResponse = (new Dispatcher())->route($findRouterObject);
        $printable = new Printable($routeResponse);
        $printable->output();
    }
}
