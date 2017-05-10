<?php

namespace League\OAuth1\Client\Server;

class SpiritualityHealthResourceOwner implements ResourceOwnerInterface
{
    /**
     * Response data.
     *
     * @var array
     */
    protected $response;

    /**
     * Creates new resource owner instance.
     *
     * @param array  $response
     */
    public function __construct(array $response = array())
    {
        $this->response = $response;
    }

    /**
     * Returns the identifier of the authorised resource owner.
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->response['id'] ?: null;
    }

    /**
     * Returns all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }
}
