<?php
namespace BaseCrm\Tests;

use BaseCrm\Client;
use BaseCrm\SubScope;
use BaseCrm\Response;

/**
 * @covers BaseCrm\Scope
 */
class SubScopeTest extends \PHPUnit_Framework_TestCase
{
    private $client;

    public function setup()
    {
        $this->client = $this->getMockBuilder('Client')
                             ->disableOriginalConstructor()
                             ->setMethods(array('getRequest', 'postRequest', 'putRequest', 'deleteRequest'))
                             ->getMock();
    }

    public function testAll()
    {
        $scope = new SubScope($this->client, "http://host.domain/endpoint", "suffix");
        $params = array();
        $subid = 54321;
        $response = $this->getMockBuilder("Response")->getMock();

        $this->client->expects($this->once())
             ->method('getRequest')
             ->with(
               "http://host.domain/endpoint/{$subid}/suffix?page=1&per_page=25",
               $params
             )
             ->willReturn($response);

        $result = $scope->all($subid, $params);
        $this->assertEquals($result, $response);

    }

    public function testAllWithSortBy()
    {
        $scope = new SubScope($this->client, "http://host.domain/endpoint", "suffix");
        $params = array();
        $subid = 54321;
        $response = $this->getMockBuilder("Response")->getMock();

        $this->client->expects($this->once())
             ->method('getRequest')
             ->with(
               "http://host.domain/endpoint/{$subid}/suffix?page=1&per_page=25&sort_by=id:asc",
               $params
             )
             ->willReturn($response);

        $result = $scope->all($subid, $params, 1, 25, "id:asc");
        $this->assertEquals($result, $response);
    }

    public function testAllWithData()
    {
        $scope = new SubScope($this->client, "http://host.domain/endpoint", "suffix");
        $params = array();
        $subid = 54321;
        $response = new Response("200", array("items" =>
          array(
              array("data" => array("name" => "foo"))
          ))
        );

        $this->client->expects($this->once())
             ->method('getRequest')
             ->with(
               "http://host.domain/endpoint/{$subid}/suffix?page=1&per_page=25",
               $params
             )
             ->willReturn($response);

        $result = $scope->all($subid, $params);
        $this->assertEquals($result->body['items'][0], array("data" => array("name" => "foo")));

    }

    public function testGet()
    {
        $scope = new SubScope($this->client, "http://host.domain/endpoint", "suffix");
        $params = array();
        $id = 12345;
        $subid = 54321;
        $response = $this->getMockBuilder("Response")->getMock();

        $this->client->expects($this->once())
             ->method('getRequest')
             ->with("http://host.domain/endpoint/{$subid}/suffix/$id")
             ->willReturn($response);

        $result = $scope->get($subid, $id);
        $this->assertEquals($result, $response);

    }

    public function testGetWithData()
    {
        $scope = new SubScope($this->client, "http://host.domain/endpoint", "suffix");
        $params = array();
        $id = 12345;
        $subid = 54321;

        $response = new Response("200", array("data" => array("name" => "foo")));

        $this->client->expects($this->once())
             ->method('getRequest')
             ->with(
               "http://host.domain/endpoint/{$subid}/suffix/$id"
             )
             ->willReturn($response);

        $result = $scope->get($subid, $id);
        $this->assertEquals($result->body['data'], array("name" => "foo"));

    }

    public function testCreate()
    {
        $scope = new SubScope($this->client, "http://host.domain/endpoint", "suffix");
        $params = array();
        $subid = 54321;
        $result = $this->getMockBuilder("Response")->getMock();

        $this->client->expects($this->once())
             ->method('postRequest')
             ->with(
               "http://host.domain/endpoint/{$subid}/suffix",
               array("data" => $params)
             )
             ->willReturn($response);

        $result = $scope->create($subid, $params);
        $this->assertEquals($result, $response);

    }

    public function testUpdate()
    {
        $scope = new SubScope($this->client, "http://host.domain/endpoint", "suffix");
        $params = array();
        $id = 12345;
        $subid = 54321;

        $result = $this->getMockBuilder("Response")->getMock();

        $this->client->expects($this->once())
             ->method('putRequest')
             ->with(
               "http://host.domain/endpoint/{$subid}/suffix/$id",
               array("data" => $params)
             )
             ->willReturn($response);

        $result = $scope->update($subid, $id, $params);
        $this->assertEquals($result, $response);

    }

    public function testDestroy()
    {
        $scope = new SubScope($this->client, "http://host.domain/endpoint", "suffix");
        $params = array();
        $id = 12345;
        $subid = 54321;

        $response = $this->getMockBuilder("Response")->getMock();

        $this->client->expects($this->once())
             ->method('deleteRequest')
             ->with("http://host.domain/endpoint/{$subid}/suffix/$id")
             ->willReturn($response);

        $result = $scope->destroy($subid, $id);
        $this->assertEquals($result, $response);

    }

    public function testCreateWithData() {
        $scope = new SubScope($this->client, "http://host.domain/endpoint", "suffix");
        $params = array();
        $subid = 54321;
        $response = new Response("200", array(
          "data" => array("name" => "foo")
        ));

        $this->client->expects($this->once())
             ->method('postRequest')
             ->with(
               "http://host.domain/endpoint/{$subid}/suffix",
               array("data" => $params)
             )
             ->willReturn($response);

        $result = $scope->create($subid, $params);
        $this->assertEquals($result->body['data'], array("name" => "foo"));

    }

    public function testUpdateWithData() {
        $scope = new SubScope($this->client, "http://host.domain/endpoint", "suffix");
        $params = array();
        $id = 12345;
        $subid = 54321;

        $response = new Response("200", array(
          "data" => array("name" => "foo")
        ));

        $this->client->expects($this->once())
             ->method('putRequest')
             ->with(
               "http://host.domain/endpoint/{$subid}/suffix/$id",
               array("data" => $params)
             )
             ->willReturn($response);

        $result = $scope->update($subid, $id, $params);
        $this->assertEquals($result->body['data'], array("name" => "foo"));

    }
}
