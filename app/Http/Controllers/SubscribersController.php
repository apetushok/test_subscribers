<?php

namespace App\Http\Controllers;

use App\Enums\HttpResponseStatus;
use App\Http\Requests\CreateSubscriberRequest;
use App\Http\Requests\SubscribersRequest;
use App\Http\Requests\UpdateSubscriberRequest;
use App\Resolvers\SubscribersResolver;
use App\Services\SubscribersService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class SubscribersController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('pages.subscribers');
    }

    /**
     * @param SubscribersRequest $subscribersRequest
     * @param SubscribersService $subscribersService
     * @return JsonResponse
     */
    public function getSubscribers(
        SubscribersRequest $subscribersRequest,
        SubscribersService $subscribersService,
        SubscribersResolver $subscribersResolver
    ): JsonResponse {
        $dto = $subscribersRequest->getDto();
        $subscribers = $subscribersService->getAllSubscribers($dto);
        $subscribersTotal = $subscribersService->getSubscribersTotal();

        return response()->json(
            $subscribersResolver->resolveAPIData($subscribers, $dto, $subscribersTotal)
        );
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function createForm()
    {
        return view('pages.subscriber_form');
    }

    /**
     * @param CreateSubscriberRequest $createSubscriberRequest
     * @param SubscribersService $subscribersService
     * @return RedirectResponse
     */
    public function store(
        CreateSubscriberRequest $createSubscriberRequest,
        SubscribersService $subscribersService
    ): RedirectResponse {
        $formData = $createSubscriberRequest->getFormData();
        $subscribersService->createOrUpsertSubscriber($formData);

        return redirect()->route('subscribers')->with([
            'message' => 'The subscriber with email (' . $formData['email'] . ') was added'
        ]);
    }

    /**
     * @param string $id
     * @param SubscribersService $subscribersService
     * @return \Illuminate\Contracts\View\View
     */
    public function updateForm(string $id, SubscribersService $subscribersService)
    {
        return view('pages.subscriber_form', [
            'subscriber' => $subscribersService->getSubscriberByEmailOrId($id)['data'] ?? null
        ]);
    }

    /**
     * @param UpdateSubscriberRequest $updateSubscriberRequest
     * @param SubscribersService $subscribersService
     * @return RedirectResponse
     */
    public function edit(
        UpdateSubscriberRequest $updateSubscriberRequest,
        SubscribersService $subscribersService
    ): RedirectResponse {
        $subscribersService->updateSubscriber(
            $updateSubscriberRequest->getId(),
            $updateSubscriberRequest->getFormData(),
        );

        return redirect()->route('subscribers')->with([
            'message' => 'The subscriber\'s data was updated'
        ]);
    }

    /**
     * @param string $id
     * @param SubscribersService $subscribersService
     * @return JsonResponse
     */
    public function delete(string $id, SubscribersService $subscribersService)
    {
        $status = $subscribersService->deleteSubscriber($id);
        if ($status && $status == HttpResponseStatus::NO_CONTENT) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
