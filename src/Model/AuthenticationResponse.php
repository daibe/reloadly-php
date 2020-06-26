<?php
namespace ReloadlyPHP\Model;


class AuthenticationResponse
{

    /** @var String $access_token */
    private $access_token;

    /** @var String $scope */
    private $scope;

    /** @var int $expires_in */
    private $expires_in;

    /** @var String $token_type */
    private $token_type;

    /**
     * AuthenticationResponse constructor.
     * @param String $access_token
     * @param String $scope
     * @param int $expires_in
     * @param String $token_type
     */
    public function __construct(String $access_token = null, String $scope = null, int $expires_in = 0, String $token_type = null)
    {
        $this->access_token = $access_token;
        $this->scope        = $scope;
        $this->expires_in   = $expires_in;
        $this->token_type   = $token_type;
    }

    /**
     * @return String
     */
    public function getAccessToken(): String
    {
        return $this->access_token;
    }

    /**
     * @param String $access_token
     * @return AuthenticationResponse
     */
    public function setAccessToken(String $access_token): self
    {
        $this->access_token = $access_token;
        return $this;
    }

    /**
     * @return String
     */
    public function getScope(): String
    {
        return $this->scope;
    }

    /**
     * @param String $scope
     * @return AuthenticationResponse
     */
    public function setScope(String $scope): self
    {
        $this->scope = $scope;
        return $this;
    }

    /**
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->expires_in;
    }

    /**
     * @param int $expires_in
     * @return AuthenticationResponse
     */
    public function setExpiresIn(int $expires_in): self
    {
        $this->expires_in = $expires_in;
        return $this;
    }

    /**
     * @return String
     */
    public function getTokenType(): String
    {
        return $this->token_type;
    }

    /**
     * @param String $token_type
     * @return AuthenticationResponse
     */
    public function setTokenType(String $token_type): self
    {
        $this->token_type = $token_type;
        return $this;
    }

}