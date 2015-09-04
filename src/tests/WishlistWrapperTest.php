<?php

namespace WishlistWrapperTests;

use WishlistWrapper\Wishlist;

class WishlistWrapperTest extends \PHPUnit_Framework_TestCase
{

	public function setUp()
	{
		$this->wishlistUrl = getenv('WISHLIST_GENERIC_POST_URL');
		$this->wishlistKey = getenv('WISHLIST_KEY');
		$this->wishlist = new Wishlist($this->wishlistUrl, $this->wishlistKey);

	}

	public function testCreateMember()
	{

		$userData = [
			'transaction_id' =>"ITG0090",
			'lastname' => 'Dantes',
			'firstname' => 'Edmond',
			'email' => 'count@montecris.to',
			'level' => '1431454459',
			
		];

		$response = $this->wishlist->createMember($userData);
		
		$this->assertContains(urlencode($userData['email']),$response->getBody()->getContents());

	}
	public function tearDown()
	{

	}
}