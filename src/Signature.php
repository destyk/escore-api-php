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

/**
 * Class for DestyK\EScore\Signature
 */
class Signature
{

    /**
     * The hash algorithm
     *
     * @var string
     */
    private $encryptAlgorithm;

    /**
     * The secret key
     *
     * @var string
     */
    private $secretKey;

    /**
     * Current timestamp in milliseconds
     *
     * @var int
     */
    private $timestamp;

    /**
     * Signature constructor
     * 
     * @param string $encryptAlgorithm 
     * @param string $secretKey
     */
    public function __construct(string $encryptAlgorithm = null, string $secretKey = null)
    {
        date_default_timezone_set('UTC');

        $this->encryptAlgorithm = $encryptAlgorithm ?: 'sha256';
        $this->secretKey        = $secretKey ?: 'KHVheWluZ18zZWNyZXRfYXBB';
        $this->setTimestamp(microtime(true));
    }

    /**
     * Return time in milliseconds
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set time in milliseconds
     * 
     * @param int $timestamp
     */
    public function setTimestamp(int $timestamp)
    {
        $this->timestamp = round(
            $timestamp * 1000
        );
    }

    /**
     * Return signature time based
     */
    public function getSignature()
    {
        $hash = hash(
            $this->encryptAlgorithm,
            'timestamp=' . $this->getTimestamp() . '&secret=' . $this->secretKey,
            true
        );
        $sign = base64_encode($hash);

        return urlencode(
            urlencode($sign)
        );
    }
}
