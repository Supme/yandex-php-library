<?php
/**
 * Yandex PHP Library
 *
 * @copyright NIX Solutions Ltd.
 * @link https://github.com/nixsolutions/yandex-php-library
 */

/**
 * @namespace
 */
namespace Yandex\Pdd;

use Guzzle\Service\Client;
use Guzzle\Http\Message\Response;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Yandex\Common\AbstractServiceClient;
use Yandex\Pdd\Exception\PddRequestException;

/**
 * Class PddClient
 *
 * @category Yandex
 * @package Pdd
 *
 * @author   Agafonov Alexey <supmea@gmail.com>
 */
class PddClient extends AbstractServiceClient
{
    /**
     * @var string
     */
    protected $serviceDomain = 'pddimp.yandex.ru';

    /**
     * Requested version of API
     * @var string
     */
    private $version = 'api2';

    private $domain = 'example.com';

    /**
     * Get url to service resource with parameters
     *
     * @param string $resource
     * @see https://tech.yandex.ru/pdd/doc/concepts/access-docpage/
     * @return string
     */
    public function getServiceUrl($resource = '')
    {
        return $this->serviceScheme . '://' . $this->serviceDomain . '/'
        . $this->version . '/' . $resource;
    }

    /**
     * @param $path
     * @return string
     */
    public function getRequestUrl($path)
    {
        return parent::getServiceUrl() . $path;
    }

    /**
     * @param string $token access token
     */
    public function __construct($token = '')
    {
        $this->setAccessToken($token);
    }

    /**
     * Sends a request
     *
     * @param RequestInterface $request
     *
     * @throws \Exception|\Guzzle\Http\Exception\ClientErrorResponseException
     * @return Response
     */
    protected function sendRequest(RequestInterface $request)
    {
        try {
            $request = $this->prepareRequest($request);
            $request->addHeader('PddToken', $this->accessToken);
            $response = $request->send();
        } catch (ClientErrorResponseException $ex) {

            $result = $request->getResponse();
            $code = $result->getStatusCode();
            $message = $result->getReasonPhrase();

            throw new PddRequestException(
                'Service responded with error code: "' . $code . '" and message: "' . $message . '"'
            );
        }

        return $response;
    }

    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    protected function sendPost($resource, $request = [])
    {
        $body = array_merge(['domain'    =>  $this->getDomain()], $request);
        $client = new Client();
        $request = $client->post($this->getServiceUrl($resource), [], $body);
        $response = $this->sendRequest($request)->json();
        return $response;
    }

    protected function sendGet($resource, $request = [])
    {
        $params = '';
        foreach($request as $k => $r){
            $params .= '&'.urlencode($k).'='.urlencode($r);
        }
        $resource = $resource.'?domain='.urlencode($this->getDomain()).$params;

        $client = new Client($this->getServiceUrl($resource));
        $request = $client->createRequest('GET');

        $response = $this->sendRequest($request)->json();

        return $response;
    }
}
