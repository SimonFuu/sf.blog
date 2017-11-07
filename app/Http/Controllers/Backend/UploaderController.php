<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 07/11/2017
 * Time: 3:18 PM
 * https://www.fushupeng.com
 * contact@fushupeng.com
 */

namespace App\Http\Controllers\Backend;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use JellyBool\Flysystem\Upyun\UpyunAdapter;

class UploaderController extends BackendController
{
    public function store(Request $request)
    {
        $res = '';
        if ($request -> has('type')) {
            if ($request -> type === 'thumb') {
                $res = $this -> storeThumb($request);
            }
        } else {
            $res = ['error' => 'Params are invalid'];
        }
        return $res;
    }

    private function storeThumb(Request $request)
    {
        $rules = ['file' => 'required'];
        $messages = [];
        try {
            $this -> validate($request, $rules, $messages);
        } catch (\Exception $e) {
            return ($e -> getMessage());
        }
        $relativePath = str_replace(base_path(), '',storage_path('images')) . '/' . date('Ymd');
        $fileRelativePath = Storage::disk('upyun') -> put($relativePath, $request -> file);
        return [
            'url' => $fileRelativePath,
            'initialPreview' => [
                ['<img src="' . env('APP_STORAGE_HOST') . '/' . $fileRelativePath . '" class="file-preview-image" alt="" title="">']
            ],
            'initialPreviewConfig' => [
                [
                    'url' => route('adminDeleteUploadFile'),
                    'extra' => [
                        '_token' => csrf_token(),
                        'fileName' => encrypt($fileRelativePath)
                    ]
                ]
            ]
        ];
    }

    private function storeImage()
    {
        
    }

    public function delete(Request $request)
    {
        $res = Storage::disk('upyun') -> delete(decrypt($request -> fileName));

        return [$res];
    }
}