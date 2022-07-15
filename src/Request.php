<?php

/**
 * EScore unofficail API.
 *
 * @package   DestyK\EScore
 * @author    Nikita Karpov <nikita.karpov.1910@mail.ru>
 * @copyright 2022 (c) DestyK
 * @license   MIT https://raw.githubusercontent.com/destyk/escore-api-php/main/LICENSE
 */

namespace DestyK\EScore;

use DestyK\EScore\RequestException;
use Curl\Curl;

/**
 * Class for working with API requests
 */
class Request
{
    /**
     * GET method
     *
     * @const string
     */
    const GET = 'GET';

    /**
     * POST method
     *
     * @const string
     */
    const POST = 'POST';

    /**
     * Main URL for requests
     *
     * @const string
     */
    const URL = 'https://www.escore.gg/api/common/';

    /**
     * Query Library
     *
     * @var Curl
     */
    private $request;

    /**
     * Curl constructor
     */
    public function __construct()
    {
        $this->request = new Curl(self::URL);
    }

    /**
     * Creating an API request
     *
     * @param string    $url       URL
     * @param string    $method    Request method
     * @param Signature $signature Object of class \DestyK\EScore\Signature
     * @param array     $body      Request body
     *
     * @return bool|array Response
     *
     * @throws RequestException Used to return a request error
     */
    protected function requestBuilder(string $uri, $method, Signature $signature, array $body = [])
    {
        $this->request->reset();

        /**
         * Setting the required headers for the request
         */
        $this->request->setHeader('Content-Type', 'application/json;charset=UTF-8');
        $this->request->setHeader('Accept', 'application/json');
        $this->request->setOpt(CURLOPT_SSL_VERIFYPEER, false);
        $this->request->setOpt(CURLOPT_SSL_VERIFYHOST, false);

        /**
         * Signature and timestamp generation
         */
        $signature->setTimestamp(microtime(true));
        $signatureUri = 'timestamp=' . $signature->getTimestamp() . '&sign=' . $signature->getSignature();
        $uri .= strpos($uri, '?') === false ? '?' : '&' . $signatureUri;

        switch ($method) {
            case self::GET:
                $this->request->get($uri, json_encode($body));
                break;
            case self::POST:
                $this->request->post($uri, json_encode($body));
                break;
            default:
                throw new RequestException(
                    'Not supported method ' . $method
                );
        }

        /**
         * Error?... Throwing an \DestyK\Exceptions\RequestException
         */
        if (true === $this->request->error) {
            throw new RequestException(
                'API responded with an error: ' . $this->request->errorMessage,
                $this->request->errorCode
            );
        }

        if (false === empty($this->request->response)) {
            $json = (array) $this->request->response;

            /**
             * API returned an error? Throwing an \DestyK\Exceptions\RequestException
             */
            if (true === isset($json['message'])) {
                throw new RequestException(
                    'API response body: ' . $json['message']
                );
            }

            return $json;
        }

        return true;
    }
}
