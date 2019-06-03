<?php

namespace TPG\ImageActions\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TPG\ImageActions\ImageRenderer;

class ImageController
{
    public function __invoke(Request $request, string $filename)
    {
        $path = $this->getFilePath($filename);

        if (!$this->fileExists($path)) {
            $this->sendMissingFileResponse($request, $filename);
        }

        return (new ImageRenderer())->render($path, $request->all());
    }

    protected function getFilePath(string $filename): string
    {
        $path = config('renderer.storage.path');
        if (!Str::endsWith($path, '/')) {
            $path .= '/';
        }

        return $path . $filename;
    }

    protected function fileExists(string $path)
    {
        return Storage::disk(config('renderer.storage.disk'))
            ->exists($path);
    }

    protected function sendMissingFileResponse(Request $request, string $filename)
    {
        $message = 'File ' . $filename . ' was not found.';

        throw new NotFoundHttpException($message);
    }
}
