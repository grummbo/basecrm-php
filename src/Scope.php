<?php
namespace BaseCrm;

/**
 * BaseCrm\Scope
 *
 * The scope is used for making specific calls to an endpoint
 *
 * @package    BaseCrm
 * @author     Marcin Bunsch <marcin.bunsch@gmail.com>
 */
class Scope
{
  /**
   * @var BaseCrm\Client Client object
   * @ignore
   */
  protected $client;

  /**
   * @var string Endpoint
   * @ignore
   */
  protected $endpoint;

  /**
   * @var string Namespace used as meta data
   * @ignore
   */
  protected $namespace;

  /**
   * Clients accept an array of constructor parameters.
   *
   * @param BaseCrm\Client $client Base client object
   * @param string $endpoint Endpoint
   * @param array $config Scope configuration settings
   *   - namespace: Namespace used for data packing/unpacking
   */
  public function __construct($client, $endpoint, $options = array())
  {
    $this->client = $client;
    $this->endpoint = $endpoint;
    if (array_key_exists('namespace', $options))
        $this->namespace = $options['namespace'];
  }

  /**
   * Fetch a collection of resources.
   *
   * @param array $params Params passed to the API
   * @param int $page Page to return, 1-based index (default 1)
   * @param int $per_page Number of results to return per page (default 25)
   * @return BaseCrm\Response
   */
  public function all($params = array(), $page = 1, $per_page = 25, $sort_by="") {
    $url = "{$this->endpoint}?page={$page}&per_page={$per_page}";
    if (!empty($sort_by))
        $url .= "&sort_by={$sort_by}";
    $response = $this->client->getRequest($url, $params);
    return $response;
  }

  /**
   * Fetch a single resource
   *
   * @param num $id Id of the resource
   * @return BaseCrm\Response
   */
  public function get($id) {
    $url = "{$this->endpoint}/$id";
    $response = $this->client->getRequest($url);
    return $response;
  }

  /**
   * Destroy a single resource
   *
   * @param num $id Id of the resource
   * @return BaseCrm\Response
   */
  public function destroy($id) {
    $url = "{$this->endpoint}/$id";
    return $this->client->deleteRequest($url);
  }

  /**
   * Create a resource
   *
   * @param array $params Params passed to the API
   * @return BaseCrm\Response
   */
  public function create($params) {
    $url = "{$this->endpoint}";
    $payload = $this->buildPayload($params);
    $response = $this->client->postRequest($url, $payload);
    return $response;
  }

  /**
   * Update a resource
   *
   * @param num $id If of the resource
   * @param array $params Params passed to the API
   * @return BaseCrm\Response
   */
  public function update($id, $params) {
    $url = "{$this->endpoint}/$id";
    $payload = $this->buildPayload($params);
    $response = $this->client->putRequest($url, $payload);
    return $response;
  }

  /**
    * @ignore
    */
  protected function buildPayload($params) {
    $data = array();
    $data['data'] = $params;
    return $data;
  }

}
