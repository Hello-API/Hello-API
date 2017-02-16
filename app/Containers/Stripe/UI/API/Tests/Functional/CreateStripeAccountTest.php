<?php

namespace App\Containers\Stripe\UI\API\Tests\Functional;

use App\Containers\Stripe\Tests\TestCase;

/**
 * Class CreateStripeAccountTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class CreateStripeAccountTest extends TestCase
{

    protected $endpoint = '/stripes';

    public function testCreateStripeAccount_()
    {
        $userDetails = [
            'name'     => 'Mahmoud Zalt',
            'email'    => 'mahmoud@testttt.test',
            'password' => 'passssssssssss',
        ];
        // get the logged in user (create one if no one is logged in)
        $user = $this->createTestingUser($userDetails);

        $data = [
            'customer_id'      => 'cus_123456789',
            'card_id'          => 'car_123456789',
            'card_funding'     => 'qwerty',
            'card_last_digits' => '1234',
            'card_fingerprint' => 'zxcvbn',
        ];

        // send the HTTP request
        $response = $this->apiCall($this->endpoint, 'post', $data, true);

        // assert response status is correct
        $this->assertEquals('202', $response->getStatusCode());

        // convert JSON response string to Object
        $responseObject = $this->getResponseObject($response);

        $this->assertEquals($responseObject->message, 'Stripe account created successfully.');

    }

}
