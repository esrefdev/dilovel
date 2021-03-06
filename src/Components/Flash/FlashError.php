<?php


namespace App\Components\Flash;

use App\Components\Http\Session;
use App\Interfaces\ArrayAble;

/**
 * Class FlashError
 * @package App\Components\Flash
 */
class FlashError implements ArrayAble
{

    /**
     * @var Session $session
     */
    private Session $session;

    /**
     * @var string $prefix
     */
    private string $prefix = 'flash_error_';


    /**
     * Flash constructor.
     */
    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @param string $name
     * @param $value
     * @return $this
     */
    public function set(string $name, $value): self
    {
        $this->session->put(
            $this->prefix,
            $this->createSessionName($name),
            $value
        );

        return $this;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        $this->destroyFlash();
        return $this->session->get($this->prefix)[$this->createSessionName($name)] ?? null;
    }

    /**
     * @return mixed|string|null
     */
    public function toArray(): array
    {
        $this->destroyFlash();
        $sessions = $this->session->get($this->prefix) ?? [];
        foreach ($sessions as $key => $value) {
            sscanf($key, "$this->prefix%s", $keyName);
            unset($sessions[$key]);
            $sessions[$keyName] = $value;
        }
        return $sessions;
    }

    /**
     * @return array|mixed|string|null
     */
    public function all()
    {
        return $this->toArray();
    }


    /**
     * @param string $name
     * @return string
     */
    private function createSessionName(string $name): string
    {
        return $this->prefix . $name;
    }

    private function destroyFlash(): void
    {
        register_shutdown_function(fn () => $this->session->delete($this->prefix));
    }
}
