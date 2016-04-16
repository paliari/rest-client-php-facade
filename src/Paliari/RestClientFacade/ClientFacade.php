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
                'timeout'  => null,
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
     * @param int $timeout
     *
     * @return int
     */
    public function timeout($timeout = null)
    {
        if (null !== $timeout) {
            $this->config['timeout'] = $timeout;
        }

        return $this->config['timeout'];
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
        return $this->call('get', $url, null, $mime);
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
        return $this->call('post', $url, $payload, $mime);
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
        return $this->call('put', $url, $payload, $mime);
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
        return $this->call('patch', $url, $payload, $mime);
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
        return $this->call('delete', $url, null, $mime);
    }

    public function prepareUrl($url)
    {
        $url = rtrim($this->base_uri, '/') . '/' . ltrim($url, '/');

        return $url;
    }

    /**
     * @param string $method
     * @param string $url
     * @param null   $payload
     * @param string $mime
     *
     * @return Request
     */
    protected function call($method, $url, $payload = null, $mime = '')
    {
        $url  = $this->prepareUrl($url);
        $mime = $mime ?: $this->mime();
        if (in_array($method, ['get', 'delete'])) {
            $request = Request::$method($url, $mime);
        } else {
            $request = Request::$method($url, $payload, $mime);
        }
        if ($timeout = $this->timeout()) {
            $request->timeout($timeout);
        }

        return $request;
    }

}
