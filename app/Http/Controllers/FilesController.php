<?php

namespace App\Http\Controllers;

use App\File;
use App\Http\Requests\FileStore;
use App\Http\Transformers\FileTransformer;
use Illuminate\Support\Facades\Storage;

class FilesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = File::paginate(10);

        $array = fractal()
                    ->collection($files)
                    ->transformWith(new FileTransformer())
                    ->toArray();

        return $this->respondWithPagination($files, $array);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileStore $request, File $file)
    {
        // Convert csv parameter into array format
        $csv_array = str_getcsv($request->csv, ',');

        $excelSheet = $file->createSpreadSheet($csv_array);

        $fileID = $file->max('id') + 1;
        $file->filename = $this->validateFilename($request->filename);
        $file->download = url("/api/v1/files/download/" . $fileID);

        if ($file->save()) {
            Storage::disk('local')->put($file->id . '.xls', $excelSheet);
        }

        return $this->respondCreated();
    }

    /**
     * validates filename
     *
     * @param  string $requestFilename
     * @return string
     */
    protected function validateFilename(string $requestFilename)
    {
        $extension = substr($requestFilename, -4);

        if ($extension === '.xls') {
            $filename = $requestFilename;
        } else {
            $filename = $requestFilename . '.xls';
        }

        return $filename;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file = File::find($id);

        if (! $file) {
            return $this->responseNotFound('File does not exist.');
        }

        $array = fractal()
                    ->item($file, new FileTransformer())
                    ->toArray();

        return $this->respond($array);
    }

    /**
     * Download excel file
     *
     * @param  File   $file
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function download(File $file, $id)
    {
        if ($file = $file->find($id)) {
            $filename = "{$file->id}.xls";

            if (Storage::disk('local')->exists($filename)) {
                return response()->download(storage_path('app/'. $filename));
            }
        }

        return $this->responseNotFound('File does not exist.');
    }
}
