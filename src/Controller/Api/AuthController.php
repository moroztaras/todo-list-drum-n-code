<?php

namespace App\Controller\Api;

use App\Manager\AuthManager;
use App\Exception\Api\BadRequestJsonHttpException;
use App\Model\LoginModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

#[Route('api/auth')]
class AuthController extends ApiController
{
    public function __construct(private AuthManager $authManager)
    {
    }

    #[Route('/sing-up', name: 'api_auth_sing_up', methods: 'POST')]
    public function signUp(Request $request): JsonResponse
    {
        if (!($content = $request->getContent())) {
            throw new BadRequestJsonHttpException('Bad Request.');
        }

        return $this->json(['user' => $this->authManager->createNewUser($content)], Response::HTTP_OK, [], ['sing-up' => true]);
    }

    #[Route('/sing-in', name: 'api_auth_sing_in', methods: 'POST')]
    /**
     * @OA\RequestBody(
     *     @Model(type=LoginModel::class)
     * )
     */
    public function signIn(Request $request):JsonResponse
    {
        if (!($content = $request->getContent())) {
            throw new BadRequestJsonHttpException('Bad Request.');
        }

        return $this->json(['user' => $this->authManager->userAuthentication($content)], Response::HTTP_OK, [], ['sing-in' => true]);
    }
}
