<?php

namespace AmrShawky;

use AmrShawky\Traits\ParamsOverload;
use GuzzleHttp\Client;

/**
 * @method self date(string $date)
 * @method self source(string $source)
 */

class CurrencyConversion extends API
{
    use ParamsOverload;

    /**
     * @var string
     */
    protected $base_url  = 'http://api.exchangerate.host/convert';

    /**
     * Required base currency
     *
     * @var null
     */
    private $from = null;

    /**
     * Required target currency
     *
     * @var null
     */
    private $to = null;

    /**
     * @var null
     */
    private $places = null;

    /**
     * @var float
     */
    private $amount = 1.00;

    /**
     * @var array
     */
    protected $available_params = [
        'date',
        'source'
    ];

    /**
     * CurrencyConversion constructor.
     *
     * @param Client|null $client
     */
    public function __construct(?Client $client = null)
    {
        parent::__construct($client);

        $this->setQueryParams(function () {
            if (!$this->from) {
                throw new \Exception('Base currency is not specified!');
            }

            if (!$this->to) {
                throw new \Exception('Target currency is not specified!');
            }

            $params = [
                'access_key' => $this->access_key,
                'from'       => $this->from,
                'to'         => $this->to,
                'amount'     => $this->amount
            ];

            if ($this->places) {
                $params['places'] = $this->places;
            }

            return $params;
        });
    }

    /**
     * @param $currency
     *
     * @return $this
     */
    public function from(string $currency)
    {
        $this->from = $currency;
        return $this;
    }

    /**
     * @param $currency
     *
     * @return $this
     */
    public function to(string $currency)
    {
        $this->to = $currency;
        return $this;
    }

    /**
     * @param $places
     *
     * @return $this
     */
    public function round(int $places)
    {
        $this->places = $places;
        return $this;
    }

    /**
     * @param float $amount
     *
     * @return $this
     */
    public function amount(float $amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param $access_key
     *
     * @return $this
     */
    public function access_key(string $access_key)
    {
        $this->access_key = $access_key;
        return $this;
    }

    /**
     * @param object $response
     *
     * @return mixed|null
     */
    protected function getResults(object $response)
    {
        return $response->result ?? null;
    }
}
