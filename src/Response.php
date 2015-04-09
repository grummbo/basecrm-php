<?php
namespace BaseCrm;

/**
 * BaseCrm\Response
 *
 * The HTTP Response object, holds the code and parsed data
 *
 * @package    BaseCrm
 * @author     Marcin Bunsch <marcin.bunsch@gmail.com>
 */
class Response
{

  /**
   * @var string Response code
   */
  public $code;

  /**
   * @var string Parsed response body
   */
  public $body;

  /**
   * Clients accept an array of constructor parameters.
   *
   * @param string $code Response code
   * @param mixed $body Response data
   */
  public function __construct($code, $body)
  {
    $this->code = $code;
    $this->body = $body;
  }

}
