<?php

namespace App\Http\Controllers;

use BaconQrCode\Encoder\QrCode;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExcelToORController extends Controller
{

    public function __construct()
    {
        set_time_limit(0);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = [];
        $path = $request->file('fileUpload')->store('fileUpload');
        //判断文件是否是excel文件
        if (substr ($path, -4)=== '.xls' || substr ($path, -5)=== '.xlsx') {
            $message['code'] = 0;
            $message['message'] = '请上传xls或xlsx后缀的文件';
        } else {
            Excel::selectSheetsByIndex(0)->load(storage_path('app/' . $path), function ($reader) {
                $res = $reader->all()->toArray();
                foreach ($res as $k => $v) {
                    \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(1000)->color(0, 0, 0)->generate($v['url'], storage_path('app/QRcode/' . $k . '.png'));
                    $img = \Intervention\Image\Facades\Image::make(storage_path('app/QRcode/' . $k . '.png'));
//                    dd($v);
//                    $img->text('房间名字：' . $v['asset'], 100, 30, function ($font) {
//                        $font->file(public_path('msyh.ttf'));
//                        $font->size(40);
//                        $font->color('#000000');
//                        $font->align('left');
//                        $font->valign('top');
//                        $font->angle(0);
//                    });
                    $img->text("具体位置： " . $v['area'], 100, 930, function ($font) {
                        $font->file(public_path('msyh.ttf'));
                        $font->size(40);
                        $font->color('#000000');
                        $font->align('left');
                        $font->valign('top');
                        $font->angle(0);
                    });
                    $img->save(storage_path('app/QRcode1/' . str_replace("/","_",$v['area']) . '.png'));

                }
            }
            );
            return "输出完成";
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
