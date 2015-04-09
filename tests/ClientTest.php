<?php
namespace BaseCrm\Tests;

use BaseCrm\Client as Client;

/**
 * @covers BaseCrm\Client
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function setup()
    {
    }

    public function testConstruction()
    {
        $token = 'mytoken';
        $client = new Client(array("token" => $token));
        $this->assertEquals($token, $client->getToken());
    }

    public function testRequests()
    {
        $token = $_ENV['BASE_TOKEN'];
        if ($token == null) {
          print("No BASE_TOKEN env variable set, not running live tests");
          return;
        }
        // POST
        $client = new Client(array("token" => $token));
        $response = $client->postRequest("https://api.getbase.com/v2/contacts", array("data" => array(
          "first_name" => "my",
          "last_name" => "test"
        )));
        $this->assertEquals("200", $response->code);

        $id = $response->body->data->id;

        // GET
        $response = $client->getRequest("https://api.getbase.com/v2/contacts/$id");
        $this->assertEquals("200", $response->code);

        // UPDATE
        $response = $client->putRequest("https://api.getbase.com/v2/contacts/$id", array("data" => array(
          "first_name" => "updated",
          "last_name" => "test"
        )));
        $this->assertEquals("200", $response->code);

        // DELETE
        $response = $client->deleteRequest("https://api.getbase.com/v2/contacts/$id");
        $this->assertEquals("204", $response->code);

    }

    public function testScope()
    {
        $client = new Client(array("token" => $this->token));
        $scope = $client->contacts;
    }

}
