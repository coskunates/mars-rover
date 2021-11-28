<?php

namespace Controllers;

use App\System\Config;
use App\System\Response\HTTPStatusCodes;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Controllers\PlateauController
 * Class PlateauControllerTest
 */
class PlateauControllerTest extends TestCase
{
    const API_URL = 'http://172.28.1.1';

    /**
     * @covers \App\Repositories\PlateauRepository::findOne
     * @throws GuzzleException
     */
    public function testGetSuccess()
    {
        try {
            $client = new Client();
            $response = $client->request('GET', self::API_URL . '/plateaus/1');
        } catch (RequestException $exception) {
            $response = $exception->getResponse();
        }

        $responseArray = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(HTTPStatusCodes::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(false, $responseArray['error']);
        $this->assertArrayHasKey('id', $responseArray['data']);
        $this->assertArrayHasKey('upper_bound_x', $responseArray['data']);
        $this->assertArrayHasKey('upper_bound_y', $responseArray['data']);
    }

    /**
     * @covers \App\Repositories\PlateauRepository::findOne
     * @throws GuzzleException
     */
    public function testGetFail()
    {
        try {
            Config::loadConfigs();
            $client = new Client();
            $response = $client->request('GET', self::API_URL . '/plateaus/' . rand(10000000000, 99999999999));
        } catch (RequestException $exception) {
            $response = $exception->getResponse();
        }

        $responseArray = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(HTTPStatusCodes::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertEquals(true, $responseArray['error']);
        $this->assertEquals(1, $responseArray['code']);
    }

    /**
     * @covers \App\Repositories\PlateauRepository::save
     * @covers \App\Repositories\PlateauRepository::validate
     * @throws GuzzleException
     */
    public function testStoreSuccess()
    {
        try {
            Config::loadConfigs();
            $client = new Client();
            $response = $client->request('POST', self::API_URL . '/plateaus', [
                'form_params' => [
                    'upper_bound_x' => 15,
                    'upper_bound_y' => 15
                ]
            ]);
        } catch (RequestException $exception) {
            $response = $exception->getResponse();
        }

        $responseArray = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(HTTPStatusCodes::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals(false, $responseArray['error']);
        $this->assertArrayHasKey('id', $responseArray['data']);
        $this->assertArrayHasKey('upper_bound_x', $responseArray['data']);
        $this->assertArrayHasKey('upper_bound_y', $responseArray['data']);
    }

    /**
     * @covers \App\Repositories\PlateauRepository::validate
     * @throws GuzzleException
     */
    public function testStoreValidationFail()
    {
        try {
            Config::loadConfigs();
            $client = new Client();
            $response = $client->request('POST', self::API_URL . '/plateaus', [
                'form_params' => [
                    'upper_bound_x' => -1,
                    'upper_bound_y' => 15
                ]
            ]);
        } catch (RequestException $exception) {
            $response = $exception->getResponse();
        }

        $responseArray = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(HTTPStatusCodes::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertEquals(true, $responseArray['error']);
        $this->assertEquals(3, $responseArray['code']);
    }
}