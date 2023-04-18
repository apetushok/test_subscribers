<?php

namespace Tests\Unit;

use App\DTOs\GetSubscribersDto;
use App\Models\User;
use App\Resolvers\SubscribersResolver;
use App\Services\SubscribersService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use MailerLite\Endpoints\Subscriber;
use MailerLite\MailerLite;
use Tests\TestCase;

class SubscribersTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * subscribers page available
     */
    public function test_subscribers_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/subscribers');

        $response->assertStatus(200);
    }

    /**
     * list of subscribers
     */
    public function test_subscribers_list(): void
    {
        $email = 'test_emil@mai.com';
        $name = 'test_name';
        $last_name = 'test_last_name';
        $country = 'test_country';
        $date = '2021-01-01 10:12:00';
        $id = 1;
        $total = 7;

        $subscriberStub = $this->createStub(Subscriber::class);
        $subscriberStub->method('get')->willReturn(['body' =>
            [
                'data' => [
                    [
                        'email' => $email,
                        'fields' => [
                            'name' => $name,
                            'last_name' => $last_name,
                            'country' => $country,
                        ],
                        'subscribed_at' => $date,
                        'id' => $id,
                    ]
                ],
                'total' => $total
            ]
        ]);

        $mailerLiteMock = $this->createMock(MailerLite::class);
        $mailerLiteMock->subscribers = $subscriberStub;

        $subscribersService = new SubscribersService($mailerLiteMock);

        $dto = new GetSubscribersDto([]);
        $subscribers = $subscribersService->getAllSubscribers($dto);
        $subscribersTotal = $subscribersService->getSubscribersTotal();

        $subscribersResolver = new SubscribersResolver();
        $data = $subscribersResolver->resolveAPIData($subscribers, $dto, $subscribersTotal);

        $this->assertEquals($email, $data['data'][0][0]);
        $this->assertEquals($name . ' ' . $last_name, $data['data'][0][1]);
        $this->assertEquals($country, $data['data'][0][2]);
        $this->assertEquals($id, $data['data'][0][5]);
        $this->assertEquals($total, $data['recordsTotal']);
        $this->assertEquals(1, $data['recordsFiltered']);
    }
}
