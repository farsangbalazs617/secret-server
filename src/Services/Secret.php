<?php declare(strict_types=1);

namespace SecretServer\Services;

use Ramsey\Uuid\Uuid;

/**
 * Manages the storage and retrieval of secrets in a JSON file.
 * 
 * @author Farsang Balázs <farsang.balazs617@gmail.com>
 */
class Secret
{
    const FILE_PATH = STORAGE_DIR . DIRECTORY_SEPARATOR . 'secrets.json';

    /**
     * Checks if the secrets.json file exists, and creates it with an empty array if it doesn't.
     */
    protected static function checkFile(): void
    {
        if (file_exists(self::FILE_PATH)) {
            return;
        }

        file_put_contents(self::FILE_PATH, json_encode([]));
    }

    /**
     * Reads the data from the secrets.json file and returns it as an array.
     * If the file doesn't exist, it is created with an empty array.
     *
     * @return array The data from the secrets.json file.
     */
    protected static function readData(): array
    {
        self::checkFile();

        $content = file_get_contents(self::FILE_PATH);
        
        return json_decode($content, true) ?: [];
    }

    /**
     * Writes the provided data array to the secrets.json file.
     *
     * @param array $data The data to be written to the file.
     */
    protected static function writeData(array $data): void
    {
        file_put_contents(self::FILE_PATH, json_encode($data, JSON_PRETTY_PRINT));
    }

    /**
     * Creates a new secret with the given parameters.
     *
     * @param string $secretText The text of the secret to be stored.
     * @param int $expireAfterViews The number of views after which the secret will expire.
     * @param int $expireAfter The number of minutes after which the secret will expire.
     * 
     * @return string The hash of the created secret.
     */
    public static function createSecret(string $secretText, int $expireAfterViews, int $expireAfter): string
    {
        $data = self::readData();

        $hash = Uuid::uuid4()->toString();
        $createdAt = date('Y-m-d\TH:i:s\Z');
        $expiresAt = $expireAfter > 0 ? date('Y-m-d\TH:i:s\Z', strtotime("+$expireAfter minutes")) : null;

        $data[] = [
            'hash' => $hash,
            'secretText' => $secretText,
            'createdAt' => $createdAt,
            'expiresAt' => $expiresAt,
            'remainingViews' => $expireAfterViews
        ];

        self::writeData($data);

        return $hash;
    }

    /**
     * Retrieves a secret from the storage based on the provided hash.
     *
     * @param string $hash The hash of the secret to retrieve.
     * 
     * @return array|null The secret data, or null if the secret is not found or has expired.
     */
    public static function getSecret(string $hash): ?array
    {
        $data = self::readData();

        foreach ($data as $key => $secret) {
            if ($secret['hash'] !== $hash) {
                continue;
            }

            if (($secret['expiresAt'] && strtotime($secret['expiresAt']) < time()) || $secret['remainingViews'] <= 0) {
                unset($data[$key]);
                self::writeData(array_values($data));
                return null;
            }

            $data[$key]['remainingViews']--;
            self::writeData($data);

            return $secret;
        }

        return null;
    }
}
