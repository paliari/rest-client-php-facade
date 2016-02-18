<?php
namespace Paliari\RestClientFacade;

use Httpful\Request;

class ClientFacade
{
    /**
     * @var string
     */
    protected $base_uri;

    /**
     * @var array
     */
    protected $config = array();

    /**
     * @param array $config
     */
    public function __construct($config = array())
    {
        $this->config   = array_merge(
            array(
                'base_uri' => null,
                'username' => null,
                'password' => null,
                'mime'     => null,
            ), (array)$config
        );
        $this->base_uri = $this->config['base_uri'];
        $template       = Request::init()->mime($this->config['mime']);
        if ($this->config['username']) {
            $template->authenticateWith($this->config['username'], $this->config['password']);
        }
        Request::ini($template);
    }

    /**
     * @param string $mime
     *
     * @return string
     */
    public function mime($mime = '')
    {
        if ('' !== $mime) {
            $this->config['mime'] = $mime;
        }

        return $this->config['mime'];
    }

    /**
     * HTTP Method Get
     *
     * @param string $url optional uri to use
     * @param string $mime
     *
     * @return Request
     */
    public function get($url, $mime = '')
    {
        $url = $this->prepareUrl($url);

        return Request::get($url, $mime ?: $this->mime());
    }

    /**
     * HTTP Method Post
     *
     * @param string $url optional uri to use
     * @param string $payload data to send in body of request
     * @param string $mime
     *
     * @return Request
     */
    public function post($url, $payload = null, $mime = '')
    {
        $url = $this->prepareUrl($url);

        return Request::post($url, $payload, $mime ?: $this->mime());
    }

    /**
     * HTTP Method Put
     *
     * @param string $url optional uri to use
     * @param string $payload data to send in body of request
     * @param string $mime
     *
     * @return Request
     */
    public function put($url, $payload = null, $mime = '')
    {
        $url = $this->prepareUrl($url);

        return Request::put($url, $payload, $mime ?: $this->mime());
    }

    /**
     * HTTP Method Patch
     *
     * @param string $url optional uri to use
     * @param string $payload data to send in body of request
     * @param string $mime
     *
     * @return Request
     */
    public function patch($url, $payload = null, $mime = '')
    {
        $url = $this->prepareUrl($url);

        return Request::patch($url, $payload, $mime ?: $this->mime());
    }

    /**
     * HTTP Method Delete
     *
     * @param string $url optional uri to use
     * @param string $mime
     *
     * @return Request
     */
    public function delete($url, $mime = '')
    {
        $url = $this->prepareUrl($url);

        return Request::delete($url, $mime ?: $this->mime());
    }

    public function prepareUrl($url)
    {
        $url = rtrim($this->base_uri, '/') . '/' . ltrim($url, '/');

        return $url;
    }

}
