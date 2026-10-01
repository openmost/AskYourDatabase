<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\AskYourDatabase\tests\Unit;

use PHPUnit\Framework\TestCase;
use Piwik\Plugins\AskYourDatabase\SessionClient;
use Piwik\Plugins\AskYourDatabase\SystemSettings;

/**
 * @group AskYourDatabase
 * @group Plugins
 */
class SessionClientTest extends TestCase
{
    public function testCreateSessionSendsV2Request(): void
    {
        $sent = [];
        $client = new SessionClient(function (string $url, string $body, array $headers) use (&$sent) {
            $sent = compact('url', 'body', 'headers');
            return ['status' => 200, 'data' => '{"url":"https://www.askyourdatabase.com/api/chatbot/auth/callback?code=abc"}'];
        });

        $url = $client->createSession('my-key', 'bot123', 'Jane', 'jane@example.org');

        $this->assertSame('https://www.askyourdatabase.com/api/chatbot/auth/callback?code=abc', $url);
        $this->assertSame('https://www.askyourdatabase.com/api/chatbot/v2/session', $sent['url']);
        $this->assertSame(['chatbotid' => 'bot123', 'name' => 'Jane', 'email' => 'jane@example.org'], json_decode($sent['body'], true));
        $this->assertContains('Authorization: Bearer my-key', $sent['headers']);
        $this->assertContains('Content-Type: application/json', $sent['headers']);
    }

    public function testParseResponseThrowsTheApiError(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Chatbot not found');

        SessionClient::parseResponse(['status' => 404, 'data' => '{"error":"Chatbot not found"}']);
    }

    public function testParseResponseThrowsWhenCredentialsAreRefused(): void
    {
        $this->expectException(\Exception::class);

        SessionClient::parseResponse(['status' => 401, 'data' => '{"error":"Unauthorized"}']);
    }

    public function testParseResponseRejectsUrlsOutsideAskYourDatabase(): void
    {
        $this->expectException(\Exception::class);

        SessionClient::parseResponse(['status' => 200, 'data' => '{"url":"https://evil.example.org/"}']);
    }

    public function testParseResponseRejectsFailedRequests(): void
    {
        $this->expectException(\Exception::class);

        SessionClient::parseResponse(false);
    }

    /**
     * @dataProvider getChatbotIdValues
     */
    public function testExtractChatbotId(string $value, string $expected): void
    {
        $this->assertSame($expected, SystemSettings::extractChatbotId($value));
    }

    public static function getChatbotIdValues(): array
    {
        return [
            ['5da7b8cf3a372f5e6e6b64af9ae189c7', '5da7b8cf3a372f5e6e6b64af9ae189c7'],
            ['  5da7b8cf3a372f5e6e6b64af9ae189c7 ', '5da7b8cf3a372f5e6e6b64af9ae189c7'],
            ['https://www.askyourdatabase.com/dashboard/chatbot/5da7b8cf3a372f5e6e6b64af9ae189c7', '5da7b8cf3a372f5e6e6b64af9ae189c7'],
            ['https://www.askyourdatabase.com/chatbot/5da7b8cf3a372f5e6e6b64af9ae189c7?tab=1', '5da7b8cf3a372f5e6e6b64af9ae189c7'],
            ['', ''],
        ];
    }
}
