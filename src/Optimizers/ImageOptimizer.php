<?php


namespace OnzaMe\Images\Optimizers;


use OnzaMe\Images\Contracts\ImageOptimizerContract;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class ImageOptimizer extends AbstractImageOptimizer implements ImageOptimizerContract
{
    public function optimize(string $image, string $saveTo): bool
    {
        try {
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize($image, $saveTo);
        } catch (\Throwable $e) {
            return false;
        }
        return true;
    }
}
