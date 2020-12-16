<?php

namespace OnzaMe\Images\Optimizers;

use Kraken;
use OnzaMe\Images\Contracts\ImageOptimizerContract;

class KrakenIO extends AbstractImageOptimizer implements ImageOptimizerContract
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
}
