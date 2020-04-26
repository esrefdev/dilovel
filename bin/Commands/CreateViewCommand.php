<?php


namespace Bin\Commands;


use Bin\Components\ColorConsole;
use Bin\Components\CommandInterface;

class CreateViewCommand implements CommandInterface
{

    protected string $description = 'create view including html ';
    /**
     * @var string
     */
    private string $path = 'src/Views/';

    /**
     * @param array|null $parameters
     */
    public function handle(?array $parameters): void
    {
        $name = $parameters[0];
        $filePath = $this->createFilePath($name);

        echo $this->createView($name, $filePath);

    }

    /**
     * @param $name
     * @param $path
     * @return string
     */
    private function createView($name, $path): string
    {
        if (file_exists($path)) {
            ColorConsole::getInstance()->getColoredString('view already exists', 'red');
        }

        file_put_contents($path, $this->viewTemplate());

        return ColorConsole::getInstance()->getColoredString("$name view created", 'green');

    }

    /**
     * @param $name
     * @return string
     */
    private function createFilePath($name): string
    {
        return sprintf('%s/%s.blade.php', $this->path, $name);
    }

    /**
     * @return false|string
     */
    private function viewTemplate()
    {
        return file_get_contents(__DIR__ . '/../Stubs/View');
    }


}