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
use OnzaMe\Images\Helpers\InputReader;
use OnzaMe\Images\Helpers\ParseInputStream;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

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
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
            $data = curl_exec($ch);
            curl_close($ch);

            file_put_contents($filepath, $data);
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

    /**
     * @param UploadedFile|Request $request
     * @param string $parameterKey
     * @return UploadedFile
     * @throws Exception
     */
    public function getUploadedFile($request, $parameterKey = 'file')
    {
        if (is_a($request, UploadedFile::class)) {
            return $request;
        }

        $uploadedFile = empty($request->get($parameterKey)) ? $request->file($parameterKey) : $request->get($parameterKey);

        if (empty($uploadedFile)) {
            $uploadedFile = $this->getUploadedFileBy($this->uploadBinaryFileFromStream($parameterKey));
        }

        if (empty($uploadedFile)) {
            throw new BadRequestException('', '', [
                $parameterKey => 'Something went wrong'
            ]);
        }

        return $uploadedFile;
    }

    /**
     * @param string $absolutePath
     * @return UploadedFile
     */
    public function getUploadedFileBy(string $absolutePath): UploadedFile
    {
        $explodedPath = explode('/', $absolutePath);
        $fileTmp = new \Symfony\Component\HttpFoundation\File\UploadedFile(
            $absolutePath,
            $explodedPath[count($explodedPath) - 1]
        );

        return UploadedFile::createFromBase($fileTmp);
    }

    /**
     * @param $parameterKey
     * @return string
     * @throws BadRequestException
     */
    public function uploadBinaryFileFromStream($parameterKey): string
    {
        $params = [];
        new ParseInputStream($params);
        $fileBinaryData = InputReader::instance()->readAll();

        if (empty($fileBinaryData)) {
            throw new BadRequestException('', 0, [
                $parameterKey => 'Empty file'
            ]);
        }

        $fileTmpPath = $this->getTmpFilepath();
        file_put_contents($fileTmpPath, $fileBinaryData);

        return $fileTmpPath;
    }
}
