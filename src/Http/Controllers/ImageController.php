<?php

namespace TPG\ImageRenderer\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use TPG\ImageRenderer\Facades\ImageRenderer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $path = $this->getFilePath($filename);

        if (! $this->fileExists($path)) {
            $this->sendMissingFileResponse($request, $filename);
        }

        if ($this->notModified($request, $path, $request->input())) {
            return Response::make()->setNotModified();
        }

        return $this->render($path, $request->input());
    }

    protected function notModified(Request $request, string $path, array $options = [])
    {
        return in_array($this->hash($path, $options), $request->getETags());
    }

    /**
     * Get the headers to attach to the response.
     *
     * @param string $path
     * @return array
     */
    protected function responseHeaders(string $path, array $options = [])
    {
        return [
            'Content-Type' => $this->storageDisk()->mimeType($path),
            'Cache-Control' => 'private,max-age='.(config('renderer.cache.duration') * 100),
            'ETag' => $this->getETag($path, $options),
        ];
    }

    /**
     * Get the E-Tag from the last modified date of the file.
     *
     * @param string $path
     * @return string
     */
    protected function getETag(string $path, array $options = [])
    {
        return $this->hash($path, $options);
    }

    protected function hash(string $path, array $options = [])
    {
        $query = http_build_query($options);

        return md5($this->storageDisk()->lastModified($path).'?'.$query);
    }

    /**
     * Get the file URI.
     *
     * @param string $filename
     * @return string
     */
    protected function getFilePath(string $filename): string
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

    protected function render(string $path, array $options = [])
    {
        $make = ImageRenderer::render($path, $options);

        $response = Response::make($make);
        $response->headers->add($this->responseHeaders($path, $options));

        return $response;
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
