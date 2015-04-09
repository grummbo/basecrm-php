<?php
namespace BaseCrm\Tests;

use BaseCrm\Client;
use BaseCrm\Scope;
use BaseCrm\Response;

/**
 * @covers BaseCrm\Scope
 */
class ScopeTest extends \PHPUnit_Framework_TestCase
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
        $scope = new Scope($this->client, "http://host.domain/endpoint");
        $params = array();
        $response = $this->getMockBuilder("Response")->getMock();

        $this->client->expects($this->once())
             ->method('getRequest')
             ->with(
               "http://host.domain/endpoint?page=1&per_page=25",
               $params
             )
             ->willReturn($response);

        $result = $scope->all($params);
        $this->assertEquals($result, $response);

    }

    public function testAllWithSortBy()
    {
        $scope = new Scope($this->client, "http://host.domain/endpoint");
        $params = array();
        $response = $this->getMockBuilder("Response")->getMock();

        $this->client->expects($this->once())
             ->method('getRequest')
             ->with(
               "http://host.domain/endpoint?page=1&per_page=25&sortby=id:asc",
               $params
             )
             ->willReturn($response);

        $result = $scope->all($params, 1, 25, "id:asc");
        $this->assertEquals($result, $response);
    }

    public function testAllWithData()
    {
        $scope = new Scope($this->client, "http://host.domain/endpoint", array("namespace" => "contact"));
        $params = array();
        $response = new Response("200", array("items" =>
          array(
              array("data" => array("name" => "foo"))
          ))
        );

        $this->client->expects($this->once())
             ->method('getRequest')
             ->with(
               "http://host.domain/endpoint?page=1&per_page=25",
               $params
             )
             ->willReturn($response);

        $result = $scope->all($params);
        $this->assertEquals($result->body['items'][0], array("data" => array("name" => "foo")));

    }

    public function testGet()
    {
        $scope = new Scope($this->client, "http://host.domain/endpoint");
        $params = array();
        $id = 12345;
        $response = $this->getMockBuilder("Response")->getMock();

        $this->client->expects($this->once())
             ->method('getRequest')
             ->with("http://host.domain/endpoint/$id")
             ->willReturn($response);

        $result = $scope->get($id);
        $this->assertEquals($result, $response);

    }

    public function testGetWithData()
    {
        $scope = new Scope($this->client, "http://host.domain/endpoint", array("namespace" => "contact"));
        $params = array();
        $id = 12345;

        $response = new Response("200", array("data" => array("name" => "foo")));

        $this->client->expects($this->once())
             ->method('getRequest')
             ->with(
               "http://host.domain/endpoint/$id"
             )
             ->willReturn($response);

        $result = $scope->get($id);
        $this->assertEquals($result->body['data'], array("name" => "foo"));

    }

    public function testCreate()
    {
        $scope = new Scope($this->client, "http://host.domain/endpoint");
        $params = array();
        $result = $this->getMockBuilder("Response")->getMock();

        $this->client->expects($this->once())
             ->method('postRequest')
             ->with(
               "http://host.domain/endpoint",
               array("data" => $params)
             )
             ->willReturn($response);

        $result = $scope->create($params);
        $this->assertEquals($result, $response);

    }

    public function testUpdate()
    {
        $scope = new Scope($this->client, "http://host.domain/endpoint");
        $params = array();
        $id = 12345;

        $result = $this->getMockBuilder("Response")->getMock();

        $this->client->expects($this->once())
             ->method('putRequest')
             ->with(
               "http://host.domain/endpoint/$id",
               array("data" => $params)
             )
             ->willReturn($response);

        $result = $scope->update($id, $params);
        $this->assertEquals($result, $response);

    }

    public function testDestroy()
    {
        $scope = new Scope($this->client, "http://host.domain/endpoint");
        $params = array();
        $id = 12345;

        $response = $this->getMockBuilder("Response")->getMock();

        $this->client->expects($this->once())
             ->method('deleteRequest')
             ->with("http://host.domain/endpoint/$id")
             ->willReturn($response);

        $result = $scope->destroy($id);
        $this->assertEquals($result, $response);

    }

    public function testCreateWithData() {
        $scope = new Scope($this->client, "http://host.domain/endpoint", array("namespace" => "contact"));
        $params = array();
        $response = new Response("200", array(
          "data" => array("name" => "foo")
        ));

        $this->client->expects($this->once())
             ->method('postRequest')
             ->with(
               "http://host.domain/endpoint",
               array("data" => $params)
             )
             ->willReturn($response);

        $result = $scope->create($params);
        $this->assertEquals($result->body['data'], array("name" => "foo"));

    }

    public function testUpdateWithData() {
        $scope = new Scope($this->client, "http://host.domain/endpoint", array("namespace" => "contact"));
        $params = array();
        $id = 12345;

        $response = new Response("200", array(
          "data" => array("name" => "foo")
        ));

        $this->client->expects($this->once())
             ->method('putRequest')
             ->with(
               "http://host.domain/endpoint/$id",
               array("data" => $params)
             )
             ->willReturn($response);

        $result = $scope->update($id, $params);
        $this->assertEquals($result->body['data'], array("name" => "foo"));

    }
}
