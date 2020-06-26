<?php


namespace ReloadlyPHP;


use DateTimeInterface;
use Exception;
use \GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException as GuzzleExceptionA;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use ReloadlyPHP\Http\Response;
use ReloadlyPHP\Model\Balance;
use ReloadlyPHP\Model\Country;
use ReloadlyPHP\Model\FxRate;
use ReloadlyPHP\Model\Operator;
use ReloadlyPHP\Model\Phone;
use ReloadlyPHP\Model\Promotion;
use ReloadlyPHP\Model\TopUpResponse;
use ReloadlyPHP\Model\Transaction;

use function array_key_exists;
use function getenv;

/**
 * A client for accessing the Reloadly API.
 *
 */

class Client {

    const API_BASE_URI_PRODUCTION = 'https://topups.reloadly.com';
    const API_ENDPOINT_AUTHENTICATE = 'https://auth.reloadly.com/oauth/token';

    const API_ENDPOINT_TOPUP = '/topups';

    const ENV_CLIENT_ID     = 'RELOADLY_CLIENT_ID';
    const ENV_CLIENT_SECRET = 'RELOADLY_CLIENT_SECRET';
    const ENV_AUDIENCE      = 'RELOADLY_AUDIENCE';
    const ENV_GRANT_TYPE    = 'RELOADLY_GRANT_TYPE';

    protected $clientId;
    protected $clientSecret;
    protected $grantType;
    protected $audience;

    protected $httpClient;
    protected $environment;

    protected $session;

    /**
     * Initializes the Reloadly Client
     *
     * @param   string|null     $clientId
     * @param   string|null     $clientSecret
     * @param   string|null     $grantType
     * @param   string|null     $audience
     * @param   HttpClient      $httpClient HttpClient, defaults to CurlClient
     * @param   mixed[]         $environment Environment to look for auth details, defaults to $_ENV
     * @throws  Exception       If valid authentication is not present
     */
    public function __construct(
        string      $clientId       = null,
        string      $clientSecret   = null,
        string      $grantType      = null,
        string      $audience       = null,
        HttpClient  $httpClient     = null,
        array       $environment    = null
    ) {
        $this->environment  = $environment ?: getenv();

        $this->clientId     = $this->getArg($clientId, self::ENV_CLIENT_ID);
        $this->clientSecret = $this->getArg($clientSecret, self::ENV_CLIENT_SECRET);
        $this->grantType    = $this->getArg($grantType, self::ENV_GRANT_TYPE);
        $this->audience     = $this->getArg($audience, self::ENV_AUDIENCE);

        $this->session      = new Session();

        if (!$this->clientId || !$this->clientSecret) {
            throw new Exception('Credentials are required to create a client.');
        }

        $this->httpClient = ($httpClient) ? $httpClient : new HttpClient(['base_uri' => Client::API_BASE_URI_PRODUCTION]);

        if (!$this->session->exists()) {
            $this->authenticate($clientId, $clientSecret);
        }

    }

    /**
     * Determines argument value accounting for environment variables.
     *
     * @param   string      $arg The constructor argument
     * @param   string      $envVar The environment variable name
     * @return  string|null Argument value
     */
    public function getArg(?string $arg, string $envVar): ?string {
        if ($arg) {
            return $arg;
        }

        if (array_key_exists($envVar, $this->environment)) {
            return $this->environment[$envVar];
        }

        return null;
    }


    private function authenticate(string $clientId = null, string $clientSecret = null)
    {
        $clientId       = $clientId ?: $this->clientId;
        $clientSecret   = $clientSecret ?: $this->clientSecret;

        $params[RequestOptions::JSON] = [
            "client_id"     => $clientId,
            "client_secret" => $clientSecret,
            "grant_type"    => $this->grantType,
            "audience"      => $this->audience
        ];

        $response = $this->request("post", Client::API_ENDPOINT_AUTHENTICATE, $params, [], [], null, null, 2.0, true);

        if ($response == null || $response->getContent()->access_token == null) return;

        $this->session->set($response->getContent()->access_token);
    }

    /**
     * Makes a request to the Reloadly API using the configured http client
     * Authentication information is automatically added if none is provided
     *
     * @param   string      $method     HTTP Method
     * @param   string      $uri        Fully qualified url
     * @param   string[]    $params     Query string parameters
     * @param   string[]    $data       POST body data
     * @param   string[]    $headers    HTTP Headers
     * @param   string|null $clientId
     * @param   string|null $clientSecret
     * @param   int         $timeout    Timeout in seconds
     * @param   bool        $authenticate should attempt authentication after 401
     * @return  Response|null
     */
    public function request(
        string  $method,
        string  $uri,
        array   $params         = [],
        array   $data           = [],
        array   $headers        = [],
        string  $clientId       = null,
        string  $clientSecret   = null,
        int     $timeout        = null,
        bool    $authenticate   = true
    ) : ?Response
    {
        $options = [];

        $headers['User-Agent'] = 'reloadly-php/'.VersionInfo::string().'(PHP '.PHP_VERSION.')';

        if ($method === 'POST') {
            if (!array_key_exists('Content-Type', $headers)) {
                $headers['Content-Type'] = 'application/x-www-form-urlencoded';
            }

            $options['form_params'] = $data;
        }

        $headers['Accept'] = 'application/com.reloadly.topups-v1+json';


        if (!empty($params)) {
            if ($authenticate) {
                $options['query'] = array_merge_recursive($options, $params);
            }
            else {
                $options['query'] = $params;
            }
        }

        try {

            if ($this->session->exists()) {
                $headers['Authorization'] = 'Bearer '.$this->session->get();
            }
            else {
                if (!$authenticate) {
                    $this->authenticate($clientId, $clientSecret);
                }
            }

            $options['headers'] = $headers;
            $options['timeout'] = ($timeout != null) ? $timeout : 2.0;

            $response = $this->getHttpClient()->request($method, $uri, $options);

            return new Response($response->getStatusCode(), $response->getBody()->getContents(), $response->getHeaders());

        } catch (ClientException | RequestException | GuzzleExceptionA $e) {
            if ($e->hasResponse()) {

                if ($e->getResponse()->getStatusCode() == 401 && !$authenticate) {
                    $this->authenticate($clientId, $clientSecret);
                }
            }
        }

        return null;
    }

    /**
     * Retrieve the Username
     *
     * @return string Current Client Id
     */
    public function getClientId(): string {
        return $this->clientId;
    }

    /**
     * Retrieve the Password
     *
     * @return string Current Client Secret
     */
    public function getClientSecret(): string {
        return $this->clientSecret;
    }

    /**
     * Retrieve the HttpClient
     *
     * @return HttpClient Current HttpClient
     */
    public function getHttpClient(): HttpClient {
        return $this->httpClient;
    }

    /**
     * Set the HttpClient
     *
     * @param HttpClient $httpClient HttpClient to use
     */
    public function setHttpClient(HttpClient $httpClient): void {
        $this->httpClient = $httpClient;
    }

    /**
     * @return Balance|null
     */
    public function getBalance() : ?Balance {

        $response = $this->request("GET", "https://topups.reloadly.com/accounts/balance");

        return Balance::fromResponse($response);
    }


    /**
     * @param int $operator_id
     * @param int $amount
     * @return FxRate|null
     */
    public function getForeignExchangeRates(int $operator_id, int $amount): ?FxRate {

        $data = [
            "operatorId" => $operator_id,
            "amount" => $amount
        ];

        $response = $this->request("POST", "https://topups.reloadly.com/operators/fx-rate", [], $data);

        return FxRate::fromResponse($response);
    }


    /**
     * @return array
     */
    public function getCountries() : array {

        $response = $this->request("GET", "https://topups.reloadly.com/countries");

        $countries = [];

        if ($response != null && $response->getContent() != null) {
            foreach ($response->getContent() as $countryJson) {

                $countries[] = Country::fromJson($countryJson);

            }
        }

        return $countries;
    }


    /**
     * @param string $isoName
     * @return Country
     */
    public function getCountryByIso(string $isoName) : ?Country {

        $response = $this->request("GET", "https://topups.reloadly.com/countries/".strtoupper($isoName));

        return Country::fromResponse($response);
    }


    /**
     * @param int $page
     * @param int $size
     * @param bool $suggestedAmounts
     * @param bool $suggestedAmountsMap
     * @param bool $includeBundles
     * @return array
     */
    public function getOperators(int $page = 1, int $size = 50, bool $suggestedAmounts = true, bool $suggestedAmountsMap = true, bool $includeBundles = true) : ?array {

        $params = [
            "page" => $page,
            "size" => $size,
            "suggestedAmounts" => $suggestedAmounts,
            "suggestedAmountsMap" => $suggestedAmountsMap,
            "includeBundles" => $includeBundles
        ];

        $response = $this->request("GET", "https://topups.reloadly.com/operators", $params);

        $operators = [];

        if ($response != null && $response->getContent() != null) {
            foreach ($response->getContent() as $jsonCollection) {

                if (!is_array($jsonCollection)) {

                    $operators[] = Operator::fromJson($jsonCollection);

                }
                else {
                    foreach ($jsonCollection as $json) {
                        $operators[] = Operator::fromJson($json);
                    }
                }
            }
        }

        return $operators;
    }


    /**
     * @param int $operator_id
     * @param bool $suggestedAmounts
     * @param bool $suggestedAmountsMap
     * @param bool $includeBundles
     * @return Operator
     */
    public function getOperatorById(int $operator_id, bool $suggestedAmounts = true, bool $suggestedAmountsMap = true, bool $includeBundles = true) : ?Operator {

        $params = [
            "suggestedAmounts" => $suggestedAmounts,
            "suggestedAmountsMap" => $suggestedAmountsMap,
            "includeBundles" => $includeBundles
        ];

        $response = $this->request("GET", "https://topups.reloadly.com/operators/".$operator_id, $params);

        return Operator::fromResponse($response);
    }


    /**
     * @param string $phoneNumber
     * @param string $countryIso
     * @param bool $suggestedAmounts
     * @param bool $suggestedAmountsMap
     * @param bool $includeBundles
     * @return Operator
     */
    public function getOperatorByPhoneNumber(string $phoneNumber, string $countryIso, bool $suggestedAmounts = true, bool $suggestedAmountsMap = true, bool $includeBundles = true) : ?Operator {

        // https://topups.reloadly.com/operators/auto-detect/phone/+50936377111/countries/HT?&includeBundles=true

        $params = [
            "suggestedAmounts" => $suggestedAmounts,
            "suggestedAmountsMap" => $suggestedAmountsMap,
            "includeBundles" => $includeBundles
        ];

        $response = $this->request("GET", "https://topups.reloadly.com/operators/auto-detect/phone/{$phoneNumber}/countries/".strtoupper($countryIso), $params);

        var_dump($response);

        return Operator::fromResponse($response);
    }



    /**
     * @param string $countryIso
     * @param bool $suggestedAmounts
     * @param bool $suggestedAmountsMap
     * @param bool $includeBundles
     * @return array
     */
    public function getOperatorsByCountryIso(string $countryIso, bool $suggestedAmounts = true, bool $suggestedAmountsMap = true, bool $includeBundles = true) : ?array {

        // https://topups.reloadly.com/operators/countries/HT

        $params = [
            "suggestedAmounts" => $suggestedAmounts,
            "suggestedAmountsMap" => $suggestedAmountsMap,
            "includeBundles" => $includeBundles
        ];

        $response = $this->request("GET", "https://topups.reloadly.com/operators/countries/".strtoupper($countryIso), $params);

        $operators = [];

        if ($response != null && $response->getContent() != null) {
            foreach ($response->getContent() as $jsonCollection) {

                if (!is_array($jsonCollection)) {

                    $operators[] = Operator::fromJson($jsonCollection);

                }
                else {
                    foreach ($jsonCollection as $json) {
                        $operators[] = Operator::fromJson($json);
                    }
                }
            }
        }

        return $operators;
    }


    /**
     * @param int $page
     * @param int $size
     * @return array
     */
    public function getPromotions(int $page = 1, int $size = 50) : ?array {

        // https://topups.reloadly.com/promotions?page=1&size=3

        $params = [
            "page" => $page,
            "size" => $size
        ];

        $response = $this->request("GET", "https://topups.reloadly.com/promotions", $params);

        $promotions = [];

        if ($response != null && $response->getContent() != null) {
            foreach ($response->getContent() as $jsonCollection) {

                if (!is_array($jsonCollection)) {

                    $promotions[] = Promotion::fromJson($jsonCollection);

                }
                else {
                    foreach ($jsonCollection as $json) {
                        $promotions[] = Promotion::fromJson($json);
                    }
                }
            }
        }

        return $promotions;
    }


    /**
     * @param string $country_iso
     * @return array
     */
    public function getPromotionsByCountryIso(string $country_iso) : ?array {

        // https://topups.reloadly.com/promotions/country-codes/{countryCode}

        $response = $this->request("GET", "https://topups.reloadly.com/promotions/country-codes/".$country_iso);

        $promotions = [];

        if ($response != null && $response->getContent() != null) {
            foreach ($response->getContent() as $jsonCollection) {

                if (!is_array($jsonCollection)) {

                    $promotions[] = Promotion::fromJson($jsonCollection);

                }
                else {
                    foreach ($jsonCollection as $json) {
                        $promotions[] = Promotion::fromJson($json);
                    }
                }
            }
        }

        return $promotions;
    }


    /**
     * @param int $operator_id
     * @return array
     */
    public function getPromotionsByOperator(int $operator_id) : ?array {

        // https://topups.reloadly.com/promotions/operators/129

        $response = $this->request("GET", "https://topups.reloadly.com/promotions/operators/".$operator_id);

        $promotions = [];

        if ($response != null && $response->getContent() != null) {
            foreach ($response->getContent() as $jsonCollection) {

                if (!is_array($jsonCollection)) {

                    $promotions[] = Promotion::fromJson($jsonCollection);

                }
                else {
                    foreach ($jsonCollection as $json) {
                        $promotions[] = Promotion::fromJson($json);
                    }
                }
            }
        }

        return $promotions;
    }


    /**
     * @param int $promotion_id
     * @return Promotion
     */
    public function getPromotionById(int $promotion_id) : ?Promotion {

        // https://topups.reloadly.com/promotions/5

        $response = $this->request("GET", "https://topups.reloadly.com/promotions/".$promotion_id);

        return Promotion::fromResponse($response);
    }


    /**
     * @param DateTimeInterface $start_date_time
     * @param DateTimeInterface $end_date_time
     * @param int $page
     * @param int $size
     * @return array
     */
    public function getTransactions(DateTimeInterface $start_date_time, DateTimeInterface $end_date_time, int $page = 1, int $size = 50) : ?array {

        // https://topups.reloadly.com/topups/reports/transactions?page=1&size=1&startTime=2018-06-01 00:00:00&endTime=2018-06-26 23:59:59

        $params = [
            "page" => $page,
            "size" => $size,
            "startTime" => $start_date_time->format("Y-m-d H:i:s"),
            "endTime" => $end_date_time->format("Y-m-d H:i:s"),
        ];

        $response = $this->request("GET", "https://topups.reloadly.com/topups/reports/transactions", $params);

        $transactions = [];

        if ($response != null && $response->getContent() != null) {
            foreach ($response->getContent() as $jsonCollection) {

                if (!is_array($jsonCollection)) {

                    $transactions[] = Transaction::fromJson($jsonCollection);

                }
                else {
                    foreach ($jsonCollection as $json) {
                        $transactions[] = Transaction::fromJson($json);
                    }
                }
            }
        }

        return $transactions;
    }


    /**
     * @param int $transaction_id
     * @return Transaction
     */
    public function getTransactionById(int $transaction_id) : ?Transaction {

        // https://topups.reloadly.com/topups/reports/transactions/{transactionId}

        $response = $this->request("GET", "https://topups.reloadly.com/topups/reports/transactions/".$transaction_id);

        return Transaction::fromResponse($response);
    }


    /**
     * @param int $operator_id
     * @param int $amount
     * @param Phone $recipient_phone
     * @param Phone $sender_phone
     * @param string|null $custom_identifier
     * @param bool $use_local_amount
     * @return TopUpResponse|null
     */
    public function topup(
        int $operator_id,
        int $amount,
        Phone $recipient_phone,
        Phone $sender_phone,
        ?string $custom_identifier = null,
        bool $use_local_amount = false
    ): ?TopUpResponse {

        $data = [
            "operatorId"        => $operator_id,
            "amount"            => $amount,
            "useLocalAmount"    => $use_local_amount,
            "customIdentifier"  => $custom_identifier,
            "recipientPhone"    => $recipient_phone->toArray(),
            "senderPhone"       => $sender_phone->toArray()
        ];

        $response = $this->request("POST", Client::API_ENDPOINT_TOPUP, [], $data);

        return TopUpResponse::fromResponse($response);
    }

    /*

    protected function getDiscounts(int $page = 1, int $size = 10, int $operator_id = null): \Twilio\Rest\Api\V2010\Account\CallList {
        return $this->api->v2010->account->calls;
    }

    */

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string {
        return '[Client ' . $this->getClientId() . ']';
    }

}





