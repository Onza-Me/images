<?php

namespace OnzaMe\Images;

use Kraken;

class KrakenIO
{
    private Kraken $kraken;

    public function __construct(string $apiKey, string $apiSecret)
    {
        $this->kraken = new Kraken($apiKey, $apiSecret);
    }

    /**
     * @param string $image URL or file path
     * @param string $saveTo
     * @return bool
     */
    public function optimize(string $image, string $saveTo): bool
    {
        $isUrl = filter_var($image, FILTER_VALIDATE_URL);
        $params = [
            $isUrl ? 'url' : 'file' => $image,
            "wait" => true
        ];

        $data = $this->kraken->{$isUrl ? 'url' : 'upload'}($params);
        if (!$data['success']) {
            return false;
        }
        return $this->saveOptimizedImage($data['kraked_url'], $saveTo);
    }

    private function saveOptimizedImage(string $optimizedUrl, string $saveTo): bool
    {
        try {
            app(FileUploadService::class)->downloadFile($optimizedUrl, $saveTo);
        } catch (\Exception $exception) {
            logs()->error($exception->getMessage());
            return false;
        }

        return true;
    }
}
