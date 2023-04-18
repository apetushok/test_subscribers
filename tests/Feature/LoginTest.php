<?php

namespace Tests\Feature;

use App\Components\MailerLite\Endpoints\Account;
use App\Components\MailerLite\MailerLite;
use App\Models\User;
use App\Services\AccountService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * login page available
     */
    public function test_login_page(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * redirect after login
     */
    public function test_login_redirect(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/');

        $response->assertStatus(302);
    }

    /**
     * redirect after logout
     */
    public function test_logout_redirect(): void
    {
        $response = $this->get('/logout');
        $response->assertStatus(302);
    }

    /**
     * authenticate method
     */
    public function test_authenticate(): void
    {
        $testEmail = 'test+1@mail.com';
        $testName = 'test_user';
        $apiKey = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiNDdhNmFkNTNkYzljN2I5YWM3NDM4ZTY3OTdlMzIyM2FmOGUxMDQyNTVjNGZhMTc0MDU3OGYxMjZjMTlkNDBmMjAwMGMxNGNkYTI3ZDZhYWYiLCJpYXQiOjE2ODE0MTA5MjEuNjI2NTYsIm5iZiI6MTY4MTQxMDkyMS42MjY1NjMsImV4cCI6NDgzNzA4NDUyMS42MjEyNTQsInN1YiI6IjQzMDMxNSIsInNjb3BlcyI6W119.bimT9ECNvI_nyTAXGlrt8lNALJhTOj8eqAWVfnXscZnKnrDhq1dlOz_BWP8EPgGVX0o6gl1NkiZJWvZOhW2j0iszXxcfFkp3faf6cWlKXZbNHhoUFYQDeDkkV8CP6wv2vyNRayYkph6PAqBYrlQaP-IxrLt0j_0TsZ-LxvJDFiQVh636g5CSUjcrH7r9El3tMxwEPfgn3lgbhXX9NurS8UwevTxM52DisdFtoPhxXtoQLethD926UXBPfnqqk1FJhxwmT4YLnSSOhOX846LGu1PepBlpk3M2BnCOvtbPpptL4jZUBnwRPn6Lyf82XWHCBeicY4zh-FESBWp4Ufc2O2KMB_iOIpi82mq8koKtigTlr1TJ5sjMTQmfYrb5hvnCnYG9H2Q1D0zlKJ9LHSUH3BmBVz9ScOHNyEnw-5zbgsvik1oRku3guM3bntf94374DtdlRmkWjJhZ9z_FK1SZJ5Kv-PqL6J1f1sF5-0X9faaiyjgqq_MpH_7TBt9OXi_bdOIPXrZiVSCv-9Fw2R5S8PbZjYA3my4CrqdQA6ECPMZK_JKhls-KqCjDfgcShd_hLIj5kOjXyju6p-2IuQjIJcEV4yjzWTFeF10qdPoAGGkTSFhhXwDlpZFmIDNHHyh0pzgHYoq0h5D8p4AezgzcuYOJzuXOEKw6RGucVeRKI44';

        $account = $this->createStub(Account::class);
        $account->method('get')->willReturn(['body' => ['data' => [
            'sender_email' => $testEmail,
            'name' => $testName,
        ]]]);

        $mailerLiteMock = $this->createMock(MailerLite::class);
        $mailerLiteMock->account = $account;

        $accountService = new AccountService();
        $accountService->setMailerLite($mailerLiteMock);
        $owner = $accountService->getOwnerDataByApiKey();
        $user = $accountService->upsertUserWithApiKey($apiKey, $owner);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($testEmail, $user->email);
        $this->assertEquals($testName, $user->name);
    }
}
