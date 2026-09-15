<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

declare(strict_types=1);

namespace Piwik\Plugins\AskYourDatabase;

use Piwik\Http;
use Piwik\Piwik;

/**
 * Creates authenticated chatbot sessions with the AskYourDatabase v2 API
 *
 * @see https://www.askyourdatabase.com/docs/chatbot-embed
 */
class SessionClient
{
    public const ORIGIN = 'https://www.askyourdatabase.com';
    public const SESSION_ENDPOINT = self::ORIGIN . '/api/chatbot/v2/session';

    private const TIMEOUT = 30;

    /** @var callable(string, string, string[]): mixed */
    private $sendRequest;

    /**
     * @param null|callable(string, string, string[]): mixed $sendRequest url, JSON body and headers, returns the
     *                                                                      extended response of Http::sendHttpRequestBy()
     */
    public function __construct(?callable $sendRequest = null)
    {
        $this->sendRequest = $sendRequest ?? self::sendRequest(...);
    }

    /**
     * Returns the one-time URL that opens the chatbot logged in as the given user
     *
     * @throws \Exception when the session cannot be created
     */
    public function createSession(#[\SensitiveParameter] string $apiKey, string $chatbotId, string $name, string $email): string
    {
        $body = (string) json_encode([
            'chatbotid' => $chatbotId,
            'name' => $name,
            'email' => $email,
        ]);

        $headers = [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json',
            'Accept: application/json',
        ];

        return self::parseResponse(($this->sendRequest)(self::SESSION_ENDPOINT, $body, $headers));
    }

    /**
     * @param mixed $response extended response of Http::sendHttpRequestBy()
     * @throws \Exception
     */
    public static function parseResponse($response): string
    {
        if (!is_array($response)) {
            throw new \Exception(Piwik::translate('AskYourDatabase_RequestFailed'));
        }

        $status = (int) ($response['status'] ?? 0);
        $data = json_decode((string) ($response['data'] ?? ''), true);

        if ($status >= 200 && $status < 300 && is_array($data) && is_string($data['url'] ?? null) && self::isChatbotUrl($data['url'])) {
            return $data['url'];
        }

        $error = is_array($data) && is_string($data['error'] ?? null) ? trim($data['error']) : '';

        if ($status === 401 || $status === 403) {
            throw new \Exception(Piwik::translate('AskYourDatabase_CredentialsRefused', [$error !== '' ? $error : 'HTTP ' . $status]));
        }

        if ($error !== '') {
            throw new \Exception($error);
        }

        throw new \Exception(Piwik::translate('AskYourDatabase_UnexpectedResponse', [(string) $status]));
    }

    /**
     * Only URLs of AskYourDatabase are loaded in the iframe
     */
    public static function isChatbotUrl(string $url): bool
    {
        return str_starts_with($url, self::ORIGIN . '/');
    }

    /**
     * @param string[] $headers
     * @return mixed
     */
    private static function sendRequest(string $url, string $body, array $headers)
    {
        return Http::sendHttpRequestBy(
            Http::getTransportMethod(),
            $url,
            self::TIMEOUT,
            null,
            null,
            null,
            0,
            false,
            false,
            false,
            true,
            'POST',
            null,
            null,
            $body,
            $headers
        );
    }
}
