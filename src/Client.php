<?php
namespace ReloadlyPHP;


use DateTimeInterface;
use Exception;
use \GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use ReloadlyPHP\Exception\AuthException;
use ReloadlyPHP\Exception\ReloadlyException;
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

    const API_RELOADLY_AUDIENCE     = 'client_credentials';
    const API_BASE_URI_PRODUCTION   = 'https://topups.reloadly.com';
    const API_BASE_URI_SANDBOX      = 'https://topups-sandbox.reloadly.com';
    const API_ENDPOINT_AUTHENTICATE = 'https://auth.reloadly.com/oauth/token';

    const API_ENDPOINT_TOPUP = '/topups';

    const ENV_CLIENT_ID     = 'RELOADLY_CLIENT_ID';
    const ENV_CLIENT_SECRET = 'RELOADLY_CLIENT_SECRET';
    const ENV_AUDIENCE      = 'RELOADLY_AUDIENCE';
    const ENV_GRANT_TYPE    = 'RELOADLY_GRANT_TYPE';
    const ENV_MODE          = 'APP_ENV';

    protected $clientId;
    protected $clientSecret;
    protected $grantType;
    protected $audience;

    protected $httpClient;
    protected $environment;

    protected $accessToken;

    /**
     * Initializes the Reloadly Client
     *
     * @param   string|null   $clientId
     * @param   string|null   $clientSecret
     * @param   bool          $debug
     * @param   mixed[]       $environment Environment to look for auth details, defaults to $_ENV
     * @throws  Exception    If valid authentication is not present
     */
    public function __construct(
        string      $clientId       = null,
        string      $clientSecret   = null,
        bool        $debug          = true,
        array       $environment    = null
    ) {
        $this->environment  = $environment ? $environment : getenv();
        $audience           = ($debug)
            ? self::API_BASE_URI_SANDBOX
            : self::API_BASE_URI_PRODUCTION;

        $this->clientId     = $this->getArg($clientId, self::ENV_CLIENT_ID);
        $this->clientSecret = $this->getArg($clientSecret, self::ENV_CLIENT_SECRET);
        $this->grantType    = $this->getArg(self::API_RELOADLY_AUDIENCE, self::ENV_GRANT_TYPE, true);
        $this->audience     = $this->getArg($audience, self::ENV_AUDIENCE, true);

        if (!$this->clientId || !$this->clientSecret) {
            throw new ReloadlyException('Credentials are required to create a client.');
        }

        $this->httpClient = new HttpClient(['base_uri' => $this->getBaseUri()]);

        if (!$this->accessToken) {
            $this->authenticate($clientId, $clientSecret);
        }
    }

    /**
     * Determines argument value accounting for environment variables.
     *
     * @param string $arg The constructor argument
     * @param string $envVar The environment variable name
     * @param bool $prioritizeEnv
     * @return  string|null Argument value
     */
    public function getArg(?string $arg, string $envVar, bool $prioritizeEnv = false): ?string {
        $value = (!$arg) ? : $arg;

        if (array_key_exists($envVar, $this->environment) && !$prioritizeEnv) {
            $value = $this->environment[$envVar];
        }

        return $value;
    }

    /**
     * @param string|null $clientId
     * @param string|null $clientSecret
     * @throws AuthException
     */
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

        $headers['Content-Type'] = 'application/json';

        try {

            $res = $this->httpClient->request('POST', Client::API_ENDPOINT_AUTHENTICATE, $params);

            $response = new Response($res->getStatusCode(), $res->getBody()->getContents(), $res->getHeaders());

            if ($response != null && $response->getContent()->access_token != null)
                $this->accessToken = $response->getContent()->access_token;

        } catch (GuzzleException $exception) {
            throw new AuthException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * Makes a request to the Reloadly API using the configured http client
     * Authentication information is automatically added if none is provided
     *
     * @param string $method HTTP Method
     * @param string $uri Fully qualified url
     * @param string[] $params Query string parameters
     * @param string[] $data POST body data
     * @param string[] $headers HTTP Headers
     * @param string|null $clientId
     * @param string|null $clientSecret
     * @param int $timeout Timeout in seconds
     * @return  Response|null
     * @throws AuthException
     * @throws ReloadlyException
     */
    public function request(
        string  $method,
        string  $uri,
        array   $params         = [],
        array   $data           = [],
        array   $headers        = [],
        string  $clientId       = null,
        string  $clientSecret   = null,
        int     $timeout        = 0
    ) : ?Response
    {
        $options = [];

        $headers['User-Agent']  = 'reloadly-php/'.VersionInfo::string().'(PHP '.PHP_VERSION.')';
        $headers['Accept']      = 'application/com.reloadly.topups-v1+json';

        if ($method === 'POST')
            $options[RequestOptions::JSON] = $data;

        if (!empty($params))
            $options['query'] = $params;

        try {

            if ($this->accessToken)
                $headers['Authorization'] = 'Bearer '.$this->accessToken;
            else
                $this->authenticate($clientId, $clientSecret);

            $options['headers'] = $headers;
            if ($timeout > 0) $options['timeout'] = $timeout;

            $response = $this->getHttpClient()->request($method, $uri, $options);

            return new Response($response->getStatusCode(), $response->getBody()->getContents(), $response->getHeaders());

        } catch (ClientException | RequestException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                $this->authenticate($clientId, $clientSecret);
            }
            else
                throw new ReloadlyException($e->getMessage(), $e->getCode());
        }
        catch (GuzzleException $e) {
            throw new ReloadlyException($e->getMessage(), $e->getCode());
        }
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

    public function getBaseUri()
    {
        $envMode = $this->getArg(null, self::ENV_MODE);
        return (in_array(strtolower($envMode), ["prod", "production"]))
            ? Client::API_BASE_URI_PRODUCTION
            : Client::API_BASE_URI_SANDBOX;
    }

    /**
     * Returns account available balance
     */
    public function getBalance()
    {
        $response = $this->request("GET", "/accounts/balance");
        return Balance::fromResponse($response);
    }


    /**
     * @param   int $operator_id
     * @param   int $amount
     * @return  FxRate|null
     */
    public function getFxRate(int $operator_id, int $amount): ?FxRate
    {
        $data = [
            "operatorId" => $operator_id,
            "amount"     => $amount
        ];

        $response = $this->request("POST", "/operators/fx-rate", [], $data);
        return FxRate::fromResponse($response);
    }

    /**
     * Retrieves list of every country supported by Reloadly
     * @return Country[]
     */
    public function getCountries() : array
    {
        $countries  = [];
        $response   = $this->request("GET", "/countries");

        if ($response != null && $response->getContent() != null) {
            foreach ($response->getContent() as $countryJson) {
                $countries[] = Country::fromResponseData($countryJson);
            }
        }
        return $countries;
    }

    /**
     * Retrieves country details by querying Reloadly using the country's ISO 3166-1 code.
     *
     * e.g: getCountryByIso("CD");
     * Where `CD` is the ISO 3166-1 code for the Democratic Republic of Congo.
     *
     * @param   string $isoName
     * @return  Country
     */
    public function getCountryByIso(string $isoName) : ?Country
    {
        $response = $this->request("GET", "/countries/".strtoupper($isoName));
        return Country::fromResponse($response);
    }

    /**
     * @param int $page
     * @param int $size
     * @param bool $suggestedAmounts
     * @param bool $suggestedAmountsMap
     * @param bool $includeBundles
     * @return Operator[]
     */
    public function getOperators(
        int $page = 1,
        int $size = 25,
        bool $suggestedAmounts = true,
        bool $suggestedAmountsMap = true,
        bool $includeBundles = true
    ) : ?array
    {
        $params = [
            "page" => $page,
            "size" => $size,
            "suggestedAmounts"      => $suggestedAmounts,
            "suggestedAmountsMap"   => $suggestedAmountsMap,
            "includeBundles"        => $includeBundles
        ];

        $operators  = [];
        $response   = $this->request("GET", "/operators", $params);

        if ($response != null && $response->getContent() != null) {
            foreach ($response->getContent() as $operatorsResponse) {
                if (!is_array($operatorsResponse)) continue;

                foreach ($operatorsResponse as $data) {
                    $operators[] = Operator::fromResponseData($data);
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
    public function getOperatorById(
        int $operator_id,
        bool $suggestedAmounts = true,
        bool $suggestedAmountsMap = true,
        bool $includeBundles = true
    ) : ?Operator
    {
        $params = [
            "suggestedAmounts"      => $suggestedAmounts,
            "suggestedAmountsMap"   => $suggestedAmountsMap,
            "includeBundles"        => $includeBundles
        ];

        $response = $this->request("GET", "/operators/".$operator_id, $params);
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
    public function getOperatorByPhoneNumber(string $phoneNumber, string $countryIso, bool $suggestedAmounts = true, bool $suggestedAmountsMap = true, bool $includeBundles = true) : ?Operator
    {

        $params = [
            "suggestedAmounts" => $suggestedAmounts,
            "suggestedAmountsMap" => $suggestedAmountsMap,
            "includeBundles" => $includeBundles
        ];

        $response = $this->request("GET", "/operators/auto-detect/phone/{$phoneNumber}/countries/".strtoupper($countryIso), $params);

        return Operator::fromResponse($response);
    }



    /**
     * @param string $countryIso
     * @param bool $suggestedAmounts
     * @param bool $suggestedAmountsMap
     * @param bool $includeBundles
     * @return array
     */
    public function getOperatorsByCountryIso(
        string $countryIso,
        bool $suggestedAmounts = false,
        bool $suggestedAmountsMap = false,
        bool $includeBundles = false
    ) : ?array {

        $params = [
            "suggestedAmounts" => $suggestedAmounts,
            "suggestedAmountsMap" => $suggestedAmountsMap,
            "includeBundles" => $includeBundles
        ];

        $response = $this->request("GET", "/operators/countries/{$countryIso}", $params);

        $operators = [];

        if ($response != null && $response->getContent() != null) {

            foreach ($response->getContent() as $operatorsResponse) {
                if (!($operatorsResponse instanceof  \stdClass)) continue;

                $operators[] = Operator::fromResponseData($operatorsResponse);
            }
        }

        return $operators;
    }


    /**
     * @param int $page
     * @param int $size
     * @return Promotion[]
     */
    public function getPromotions(int $page = 1, int $size = 50) : ?array {

        $params = [
            "page" => $page,
            "size" => $size
        ];

        $response = $this->request("GET", "/promotions", $params);

        $promotions = [];

        if ($response != null && $response->getContent() != null) {
            foreach ($response->getContent() as $promotionsResponse) {

                if (!is_array($promotionsResponse)) continue;

                foreach ($promotionsResponse as $data) {
                    $promotions[] = Promotion::fromResponseData($data);
                }
            }
        }

        return $promotions;
    }


    /**
     * @param string $country_iso
     * @return Promotion[]
     */
    public function getPromotionsByCountryIso(string $country_iso) : ?array {

        $response = $this->request("GET", "/promotions/country-codes/".$country_iso);

        $promotions = [];

        if ($response != null && $response->getContent() != null) {
            foreach ($response->getContent() as $promotionsResponse) {
                if (!is_array($promotionsResponse)) continue;

                foreach ($promotionsResponse as $data) {
                    $promotions[] = Promotion::fromResponseData($data);
                }
            }
        }

        return $promotions;
    }


    /**
     * @param int $operator_id
     * @return Promotion[]
     */
    public function getPromotionsByOperator(int $operator_id) : ?array {

        $response = $this->request("GET", "/promotions/operators/".$operator_id);

        $promotions = [];

        if ($response != null && $response->getContent() != null) {
            foreach ($response->getContent() as $promotionsResponse) {
                if (!is_array($promotionsResponse)) continue;

                foreach ($promotionsResponse as $data) {
                    $promotions[] = Promotion::fromResponseData($data);
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

        $response = $this->request("GET", "/promotions/".$promotion_id);

        return Promotion::fromResponse($response);
    }


    /**
     * @param DateTimeInterface $start_date_time
     * @param DateTimeInterface $end_date_time
     * @param int $page
     * @param int $size
     * @return Transaction[]
     */
    public function getTransactions(DateTimeInterface $start_date_time, DateTimeInterface $end_date_time, int $page = 1, int $size = 50) : ?array {

        $params = [
            "page" => $page,
            "size" => $size,
            "startTime" => $start_date_time->format("Y-m-d H:i:s"),
            "endTime" => $end_date_time->format("Y-m-d H:i:s"),
        ];

        $response = $this->request("GET", "/topups/reports/transactions", $params);

        $transactions = [];

        if ($response != null && $response->getContent() != null) {
            foreach ($response->getContent() as $transactionsResponse) {
                if (!is_array($transactionsResponse)) continue;

                foreach ($transactionsResponse as $data) {
                    $transactions[] = Transaction::fromResponseData($data);
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

        $response = $this->request("GET", "/topups/reports/transactions/".$transaction_id);

        return Transaction::fromResponse($response);
    }

    /**
     * @param int $operator_id
     * @param float $amount
     * @param Phone $recipient_phone
     * @param Phone $sender_phone
     * @param string|null $custom_identifier
     * @param bool $use_local_amount
     * @return TopUpResponse|null
     */
    public function topup(
        int $operator_id,
        float $amount,
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

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string {
        return '[Client ' . $this->getClientId() . ']';
    }
}
