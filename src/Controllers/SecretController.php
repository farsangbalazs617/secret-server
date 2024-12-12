<?php declare(strict_types=1);

namespace SecretServer\Controllers;

use Psr\Http\Message\{
    ResponseInterface as Response,
    ServerRequestInterface as Request
};

use SecretServer\Services\Secret;

/**
 * SecretController class
 * 
 * @author Farsang Balázs <farsang.balazs617@gmail.com>
 */
class SecretController
{
    /**
     * Stores the secret and create the hash
     * 
     * @param Request $request.
     * @param Response $response.
     * 
     * @return Response 
     */
    public function create(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        if (!isset($data['secret']) || !isset($data['expireAfterViews']) || !isset($data['expireAfter'])) {
            $response->getBody()->write(json_encode([
                'error' => [
                    'code'      => 422,
                    'message'   => 'The server was unable to process the request.'
                ]
            ]));
            return $response->withStatus(422)->withHeader('Content-Type', 'application/json');
        }

        $hash = Secret::createSecret(
            $data['secret'],
            (int)$data['expireAfterViews'],
            (int)$data['expireAfter']
        );

        $response->getBody()->write(json_encode(['hash' => $hash]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * Retrive the secret data based on the given hash.
     * 
     * @param Request $request.
     * @param Response $response.
     * 
     * @return Response 
     */
    public function view(Request $request, Response $response, array $args): Response
    {
        $hash = $args['hash'] ?? '';
        $secret = Secret::getSecret($hash);

        if (!$secret) {
            $response->getBody()->write(json_encode([
                'error' => [
                    'code'      => 404,
                    'message'   => 'Hash not found.'
                ]
            ]));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode($secret));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
