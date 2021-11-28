<?php

namespace Controllers;

use App\Repositories\RoverRepository;
use App\System\Response\HTTPStatusCodes;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Controllers\RoverController
 * Class RoverControllerTest
 */
class RoverControllerTest extends TestCase
{
    const API_URL = 'http://172.28.1.1';

    /**
     * @covers \App\Controllers\RoverController::get
     * @covers \App\Repositories\RoverRepository::findOne
     * @throws GuzzleException
     */
    public function testGetSuccess()
    {
        try {
            $client = new Client();
            $response = $client->request('GET', self::API_URL . '/rovers/1');
        } catch (RequestException $exception) {
            $response = $exception->getResponse();
        }

        $responseArray = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(HTTPStatusCodes::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(false, $responseArray['error']);
        $this->assertArrayHasKey('id', $responseArray['data']);
        $this->assertArrayHasKey('plateau_id', $responseArray['data']);
        $this->assertArrayHasKey('x', $responseArray['data']);
        $this->assertArrayHasKey('y', $responseArray['data']);
        $this->assertArrayHasKey('direction', $responseArray['data']);
    }

    /**
     * @covers \App\Controllers\RoverController::get
     * @covers \App\Repositories\RoverRepository::findOne
     * @throws GuzzleException
     */
    public function testGetFail()
    {
        try {
            $client = new Client();
            $response = $client->request('GET', self::API_URL . '/rovers/' . rand(10000000000, 99999999999));
        } catch (RequestException $exception) {
            $response = $exception->getResponse();
        }

        $responseArray = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(HTTPStatusCodes::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertEquals(true, $responseArray['error']);
        $this->assertEquals(6, $responseArray['code']);
    }

    /**
     * @covers \App\Controllers\RoverController::store
     * @covers \App\Repositories\RoverRepository::save
     * @covers \App\Repositories\RoverRepository::validate
     * @throws GuzzleException
     */
    public function testStoreSuccess()
    {
        try {
            $client = new Client();
            $response = $client->request('POST', self::API_URL . '/rovers', [
                'form_params' => [
                    'plateau_id' => 1,
                    'x' => 1,
                    'y' => 1,
                    'direction' => 'N'
                ]
            ]);
        } catch (RequestException $exception) {
            $response = $exception->getResponse();
        }

        $responseArray = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(HTTPStatusCodes::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals(false, $responseArray['error']);
        $this->assertArrayHasKey('id', $responseArray['data']);
        $this->assertArrayHasKey('plateau_id', $responseArray['data']);
        $this->assertArrayHasKey('x', $responseArray['data']);
        $this->assertArrayHasKey('y', $responseArray['data']);
        $this->assertArrayHasKey('direction', $responseArray['data']);
    }

    /**
     * @covers \App\Controllers\RoverController::store
     * @covers \App\Repositories\RoverRepository::save
     * @covers \App\Repositories\RoverRepository::validate
     * @throws GuzzleException
     */
    public function testStoreRoverPlateauNotExists()
    {
        try {
            $client = new Client();
            $response = $client->request('POST', self::API_URL . '/rovers', [
                'form_params' => [
                    'plateau_id' => rand(10000000000, 99999999999),
                    'x' => 1,
                    'y' => 1,
                    'direction' => 'N'
                ]
            ]);
        } catch (RequestException $exception) {
            $response = $exception->getResponse();
        }

        $responseArray = json_decode($response->getBody()->getContents(), true);
        $this->assertEquals(HTTPStatusCodes::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertEquals(true, $responseArray['error']);
        $this->assertEquals(1, $responseArray['code']);
    }

    /**
     * @covers \App\Controllers\RoverController::store()
     * @covers \App\Repositories\RoverRepository::save
     * @covers \App\Repositories\RoverRepository::validate
     * @throws GuzzleException
     */
    public function testStoreRoverWrongLanded()
    {
        try {
            $client = new Client();
            $response = $client->request('POST', self::API_URL . '/rovers', [
                'form_params' => [
                    'plateau_id' => 1,
                    'x' => 11,
                    'y' => 1,
                    'direction' => 'N'
                ]
            ]);
        } catch (RequestException $exception) {
            $response = $exception->getResponse();
        }

        $responseArray = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(HTTPStatusCodes::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertEquals(true, $responseArray['error']);
        $this->assertEquals(8, $responseArray['code']);
    }

    /**
     * @covers \App\Controllers\RoverController::store()
     * @covers \App\Repositories\RoverRepository::save
     * @covers \App\Repositories\RoverRepository::validate
     * @throws GuzzleException
     */
    public function testStoreInvalidDirection()
    {
        try {
            $client = new Client();
            $response = $client->request('POST', self::API_URL . '/rovers', [
                'form_params' => [
                    'plateau_id' => 1,
                    'x' => 2,
                    'y' => 1,
                    'direction' => 'T'
                ]
            ]);
        } catch (RequestException $exception) {
            $response = $exception->getResponse();
        }

        $responseArray = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(HTTPStatusCodes::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertEquals(true, $responseArray['error']);
        $this->assertEquals(13, $responseArray['code']);
    }

    /**
     * @covers \App\Controllers\RoverController::move()
     * @covers \App\Libraries\MarsRover\MarsRover
     * @throws GuzzleException
     */
    public function testMoveSuccess()
    {
        try {
            try {
                $client = new Client();
                $roverResponse = $client->request('POST', self::API_URL . '/rovers', [
                    'form_params' => [
                        'plateau_id' => 1,
                        'x' => 1,
                        'y' => 1,
                        'direction' => 'N'
                    ]
                ]);
            } catch (RequestException $exception) {
                $roverResponse = $exception->getResponse();
            }

            $roverResponseArray = json_decode($roverResponse->getBody()->getContents(), true);

            $roverId = $roverResponseArray['data']['id'];

            $client = new Client();
            $response = $client->request('PUT', self::API_URL . '/rovers/' . $roverId . '/move', [
                'json' => [
                    'commands' => 'LMLMLMLMM'
                ]
            ]);
        } catch (RequestException $exception) {
            $response = $exception->getResponse();
        }

        $responseArray = json_decode($response->getBody(), true);

        $this->assertEquals(HTTPStatusCodes::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(false, $responseArray['error']);
        $this->assertArrayHasKey('x', $responseArray['data']);
        $this->assertArrayHasKey('y', $responseArray['data']);
        $this->assertArrayHasKey('direction', $responseArray['data']);
    }

    /**
     * @covers \App\Controllers\RoverController::move
     * @covers \App\Libraries\MarsRover\MarsRover
     * @throws GuzzleException
     */
    public function testMoveOutOfBounds()
    {
        try {
            $client = new Client();
            $response = $client->request('PUT', self::API_URL . '/rovers/1/move', [
                'json' => [
                    'commands' => 'MMMMMM'
                ]
            ]);
        } catch (RequestException $exception) {
            $response = $exception->getResponse();
        }

        $responseArray = json_decode($response->getBody(), true);

        $this->assertEquals(HTTPStatusCodes::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(true, $responseArray['error']);
        $this->assertContains($responseArray['code'], [14,15,16,17]);
    }

    /**
     * @covers \App\Controllers\RoverController::state
     * @covers RoverRepository::findOne
     * @throws GuzzleException
     */
    public function testState()
    {
        try {
            $client = new Client();
            $response = $client->request('GET', self::API_URL . '/rovers/1/state');
        } catch (RequestException $exception) {
            $response = $exception->getResponse();
        }

        $responseArray = json_decode($response->getBody(), true);

        $this->assertEquals(HTTPStatusCodes::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(false, $responseArray['error']);
        $this->assertArrayHasKey('id', $responseArray['data']);
        $this->assertArrayHasKey('plateau_id', $responseArray['data']);
        $this->assertArrayHasKey('x', $responseArray['data']);
        $this->assertArrayHasKey('y', $responseArray['data']);
        $this->assertArrayHasKey('direction', $responseArray['data']);
    }
}