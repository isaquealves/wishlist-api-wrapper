<?php

namespace WishlistWrapper;

use WishlistWrapper\Clients\GuzzleClient;

class Wishlist
{

    const WISHLIST_MEMBER_CREATE_CMD        = 'CREATE';
    const WISHLIST_MEMBER_DEACTIVATE_CMD    = 'DEACTIVATE';
    const WISHLIST_MEMBER_ACTIVATE_CMD      = 'ACTIVATE';

    const OUTPUT_FORMAT_JSON = 'json';
    const OUTPUT_FORMAT_XML = 'xml';
    const OUTPUT_FORMAT_SERIALIZED = 'php';

    protected $wishlistUrl;

    protected $secretKey;

    protected $authenticated;

    protected $format = self::OUTPUT_FORMAT_JSON;

    protected $client;


    protected $fragments = [
        "members" => "/members",
        "levels"  => "/levels",
        "protected" => "/protected"
    ];


    public function __construct($wishlistUrl, $secretKey)
    {
        $this->wishlistUrl = $wishlistUrl;
        $this->secretKey = $secretKey;
        $this->client = new GuzzleClient($wishlistUrl);
    }


    /**
     * Creates a member on Wishlist installation
     * @param  array $memberData An array with the following data
     * lastname: Member's last name
     * firstname: Member's First name
     * email: Member's email
     * level: SKU Membership Level
     * transaction_id : XYZ123456
     * @return [type]             [description]
     */
    public function createMember($memberData)
    {
        $method = self::WISHLIST_MEMBER_CREATE_CMD;
        $postData = $this->buildPostData($memberData,$method);

        return $this->client->post('', $postData, $this->format);
    }

    public function setReturnType($returnType)
    {
        $this->format = $returnType; 
    }

    /**
     * Deactivates a member on Wishlist installation
     * @param  array $memberData An array with the following data
     * lastname         : Member's last name
     * firstname        : Member's First name
     * email            : Member's email
     * level            : SKU Membership Level
     * transaction_id   : XYZ123456
     * @return [type]             [description]
     */
    public function deactivateMember($memberData)
    {
        $method = self::WISHLIST_MEMBER_DEACTIVATE_CMD;
        $postData = $this->buildPostData($memberData, $method);

        return $this->client->post('', $postData, $this->format);
    }


    /**
     * Activates a member on Wishlist installation
     * @param  array $memberData An array with the following data
     * lastname       : Member's last name
     * firstname      : Member's First name
     * email          : Member's email
     * level          : SKU Membership Level
     * transaction_id : XYZ123456
     * @return [type]             [description]
     */
    public function activateMember($memberData)
    {
        $method = self::WISHLIST_MEMBER_DEACTIVATE_CMD;
        $postData = $this->buildPostData($memberData, $method);


        return $this->client->post('', $postData, $this->format );
    }


    private function buildPostData($originalData, $method)
    {
        $postData['cmd']  = $method;
        $postData += $originalData;

        $string = $postData['cmd'] . "__". $this->secretKey . "__" . strtoupper( implode("|",$postData) );
    
        $postData['hash'] = md5( $string );
        return $postData;
    }
};
