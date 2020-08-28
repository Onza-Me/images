<?php
/**
 * Created by PhpStorm.
 * User: acrossoffwest
 * Date: 9/6/18
 * Time: 11:29 AM
 */

namespace OnzaMe\Images;

use Faker\Generator;
use Illuminate\Http\UploadedFile;

class FileUploadService
{
    /**
     * @param string $url
     * @param string|null $filepath
     * @return false|string
     * @throws \Exception
     */
    public function downloadFile(string $url, string $filepath = null)
    {
        $filepath = $this->prepareFilepath($filepath);
        try {
            $file = fopen($url, 'rb');

            if ($file) {
                $newFile = fopen($filepath, 'wb');
                if ($newFile) {
                    while (!feof($file)) {
                        fwrite($newFile, fread($file, 1024 * 8), 1024 * 8);
                    }
                }
                !$newFile ?: fclose($newFile);
            }
            !$file ?: fclose($file);
        } catch (\Exception $ex) {
            throw $ex;
        }

        return $filepath;
    }

    /**
     * @param string $url
     * @return UploadedFile
     * @throws \Exception
     */
    public function getUploadedFileByExternalUrl(string $url) : UploadedFile
    {
        $uploadedFilepath = $this->downloadFile($url);
        $faker = new Generator();
        /** @var Generator $faker */
        return new UploadedFile(
            $uploadedFilepath,
            $faker->slug.'.jpg',
            null,
            null,
            true
        );
    }

    /**
     * @param string|null $filepath
     * @return false|string
     */
    private function prepareFilepath(string $filepath = null)
    {
        return $filepath ?? tempnam(sys_get_temp_dir(), 'file-upload-service-');
    }

    /**
     * @param string $url
     * @return bool|string
     */
    public function getFinalUrl(string $url)
    {
        $repeat = true;
        do {
            $context = stream_context_create(
                [
                    "http" => [
                        "follow_location" => false,
                    ]
                ]
            );

            $result = file_get_contents($url, false, $context);

            $pattern = "/^Location:\s*(.*)$/i";
            $location_headers = preg_grep($pattern, $http_response_header);

            if (!empty($location_headers) &&
                preg_match($pattern, array_values($location_headers)[0], $matches)) {
                $url = $matches[1];
                continue;
            }
            $repeat = false;
        } while ($repeat);

        return $result;
    }
}
