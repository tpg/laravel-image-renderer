<?php

namespace TPG\ImageRenderer\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TPG\ImageRenderer\Facades\ImageRenderer;

/**
 * Class ImageController.
 */
class ImageController
{
    /**
     * Image response.
     *
     * @param Request $request
     * @param string $filename
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, string $filename)
    {
        $path = $this->getFileUri($filename);

        if (! $this->fileExists($path)) {
            $this->sendMissingFileResponse($request, $filename);
        }

        $make = ImageRenderer::render($path, $request->input());

        $response = Response::make($make);
        $response->headers->add($this->responseHeaders($path));

        return $response;
    }

    /**
     * Get the headers to attach to the response.
     *
     * @param string $path
     * @return array
     */
    protected function responseHeaders(string $path)
    {
        return [
            'Content-Type' => $this->storageDisk()->mimeType($path),
            'Cache-Control' => 'private,max-age='.(config('renderer.cache.duration') * 100),
            'ETag' => $this->getETag($path),
        ];
    }

    /**
     * Get the E-Tag from the last modified date of the file.
     *
     * @param string $path
     * @return string
     */
    protected function getETag(string $path)
    {
        return md5($this->storageDisk()->lastModified($path));
    }

    /**
     * Get the file URI.
     *
     * @param string $filename
     * @return string
     */
    protected function getFileUri(string $filename): string
    {
        $path = config('renderer.storage.path');
        if (! Str::endsWith($path, '/')) {
            $path .= '/';
        }

        return $path.$filename;
    }

    /**
     * Check if a file exists.
     *
     * @param string $path
     * @return bool
     */
    protected function fileExists(string $path)
    {
        return $this->storageDisk()->exists($path);
    }

    /**
     * Response for missing files.
     *
     * @param Request $request
     * @param string $filename
     */
    protected function sendMissingFileResponse(Request $request, string $filename)
    {
        $message = 'File '.$filename.' was not found.';

        throw new NotFoundHttpException($message);
    }

    /**
     * Get the storage disk.
     *
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected function storageDisk()
    {
        return Storage::disk(config('renderer.storage.disk'));
    }
}
