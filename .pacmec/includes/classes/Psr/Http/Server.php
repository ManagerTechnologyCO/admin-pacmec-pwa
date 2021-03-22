<?php
/**
 *
 * @author     FelipheGomez <feliphegomez@gmail.com>
 * @package    FG
 * @category   Api
 * @copyright  2020-2021 Manager Technology CO
 * @license    license.txt
 * @version    Release: @package_version@
 * @link       http://github.com/ManagerTechnologyCO/PACMEC
 * @version    1.0.1
 */
namespace Psr\Http\Server;

/**
* Handles a server request and produces a response.
*
* An HTTP request handler process an HTTP request in order to produce an
* HTTP response.
*/
interface RequestHandlerInterface
{
  /**
   * Handles a request and produces a response.
   *
   * May call other collaborating code to generate the response.
   */
  public function handle(ServerRequestInterface $request): ResponseInterface;
}

use \Psr\Http\Message\ResponseInterface;
use \Psr\Http\Message\ServerRequestInterface;

/**
* Participant in processing a server request and response.
*
* An HTTP middleware component participates in processing an HTTP message:
* by acting on the request, generating the response, or forwarding the
* request to a subsequent middleware and possibly acting on its response.
*/
interface MiddlewareInterface
{
  /**
   * Process an incoming server request.
   *
   * Processes an incoming server request in order to produce a response.
   * If unable to produce the response itself, it may delegate to the provided
   * request handler to do so.
   */
  public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface;
}
