<?php
namespace BaseCrm;

class SubScope
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
   * @var string Appended to the URL after the id
   * @ignore
   */
  protected $suffix;

  /**
   * Clients accept an array of constructor parameters.
   *
   * @param BaseCrm\Client $client Base client object
   * @param string $endpoint Endpoint
   * @param array $config Scope configuration settings
   *   - namespace: Namespace used for data packing/unpacking
   */
  public function __construct($client, $endpoint, $suffix, $options = array())
  {
    $this->client = $client;
    $this->endpoint = $endpoint;
    $this->suffix = $suffix;
    if (array_key_exists('namespace', $options))
        $this->namespace = $options['namespace'];
  }

  /**
   * Fetch a collection of resources.
   *
   * @param int $subid of the base resource to access
   * @param array $params Params passed to the API
   * @param int $page Page to return, 1-based index (default 1)
   * @param int $per_page Number of results to return per page (default 25)
   * @return BaseCrm\Response
   */
  public function all($subid, $params = array(), $page = 1, $per_page = 25, $sort_by="") {
    $url = "{$this->endpoint}/{$subid}/{$this->suffix}?page={$page}&per_page={$per_page}";
    if (!empty($sort_by))
        $url .= "&sort_by={$sort_by}";
    $response = $this->client->getRequest($url, $params);
    return $response;
  }

  /**
   * Fetch a single resource
   *
   * @param num $subid Id of the base resource
   * @param num $id Id of the resource
   * @return BaseCrm\Response
   */
  public function get($subid, $id) {
    $url = "{$this->endpoint}/{$subid}/{$this->suffix}/{$id}";
    $response = $this->client->getRequest($url);
    return $response;
  }

  /**
   * Destroy a single resource
   *
   * @param num $subid Id of the base resource
   * @param num $id Id of the resource
   * @return BaseCrm\Response
   */
  public function destroy($subid, $id) {
    $url = "{$this->endpoint}/{$subid}/{$this->suffix}/{$id}";
    return $this->client->deleteRequest($url);
  }

  /**
   * Create a resource
   *
   * @param num $subid Id of the base resource
   * @param array $params Params passed to the API
   * @return BaseCrm\Response
   */
  public function create($subid, $params) {
    $url = "{$this->endpoint}/{$subid}/{$this->suffix}";
    $payload = $this->buildPayload($params);
    $response = $this->client->postRequest($url, $payload);
    return $response;
  }

  /**
   * Update a resource
   *
   * @param num $subid Id of the base resource
   * @param num $id If of the resource
   * @param array $params Params passed to the API
   * @return BaseCrm\Response
   */
  public function update($subid, $id, $params) {
    $url = "{$this->endpoint}/{$subid}/{$this->suffix}/$id";
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
