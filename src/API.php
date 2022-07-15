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

use DestyK\EScore\Request;
use DestyK\EScore\Signature;

/**
 * Class DestyK\EScore\API
 */
class API extends Request
{
    /**
     * Signature Library
     *
     * @var Signature
     */
    private $signature;

    /**
     * EScore API constructor.
     * 
     * @param Signature $signature Object of class \DestyK\EScore\Signature
     */
    public function __construct(Signature $signature)
    {
        parent::__construct();
        $this->signature = $signature;
    }

    /**
     * Returns a list of matches that have already started
     *
     * @param array $body
     * @param array $query
     */
    public function getLives(array $body = [], array $query = [])
    {
        $uriQuery = $this->formatUri('getMatchLives', $query);
        $response = $this->requestBuilder($uriQuery, Request::POST, $this->signature, $body);
        return $response['matches'];
    }

    /**
     * Returns a list of completed matches
     *
     * @param array $body
     * @param array $query
     */
    public function getFinished(array $body = [], array $query = [])
    {
        $uriQuery = $this->formatUri('getMatchListEnd', $query);
        $response = $this->requestBuilder($uriQuery, Request::POST, $this->signature, $body);
        return $response['matches'];
    }

    /**
     * Returns a list of upcoming matches
     *
     * @param array $body
     * @param array $query
     */
    public function getUpcoming(array $body = [], array $query = [])
    {
        $uriQuery = $this->formatUri('getMatchListWait', $query);
        $response = $this->requestBuilder($uriQuery, Request::POST, $this->signature, $body);
        return $response['matches'];
    }

    /**
     * Formatting query data in a string
     *
     * @param string $uri
     * @param array $query
     */
    private function formatUri(string $uri, array $query)
    {
        $separator = (strpos($uri, '?') === false ? '?' : '&');
        return $uri . $separator . http_build_query($query);
    }
}
