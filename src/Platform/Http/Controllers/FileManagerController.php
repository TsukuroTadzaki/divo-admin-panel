<?php

namespace Orchid\Platform\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FileManagerController extends Controller
{
    public const DISK = 'public';

    public function upload(Request $request)
    {
        $uploadPath = $this->decode($request->input('target'));
        $disk = config('platform.filemanager.disk', self::DISK);
        foreach ($request->file('upload') as $file) {
            $newFileName = strtolower(config('app.name') . '-' . Carbon::now()->timestamp) . '.webp';
            if (substr($file->getMimeType(), 0, 5) == 'image' && !str_contains($file->getMimeType(), 'image/svg')) {
                $name = pathinfo($file->getClientOriginalName())['filename'] . '.webp';
                $basePath = Storage::disk($disk)->path($uploadPath);
                $path = $basePath . '/' . $newFileName;
                $image = Image::make($file)
                    ->encode('webp')
                    ->save($path);

                //$watermark_path = app('settings')->find(app('settings')::WATERMARK)?->value;
                if ($request->input('watermarkPath')) {
                    if (!file_exists($basePath . '/' . 'watermark')) {
                        mkdir($basePath . '/' . 'watermark', 0777, true);
                    }
                    $watermark = Image::make($request->input('watermarkPath'));
                    $watermark = $watermark->resize($image->width() * 0.3, $image->height() * 0.2);
                    Image::make($file)
                        ->insert($watermark, 'bottom-right', 10, 10)
                        ->encode('webp')
                        ->save($basePath . '/' . 'watermark/' . $newFileName);
                }
            } else {
                $file->storeAs($uploadPath, $newFileName, $disk);
            }
        }
    }

    protected function decode($hash, $volume_prefix = 'l1_')
    {
        if (strpos($hash, $volume_prefix) === 0) {
            $h = substr($hash, strlen($volume_prefix));
            $path = base64_decode(strtr($h, '-_.', '+/='));

            return $path;
        }

        return '';
    }
}
