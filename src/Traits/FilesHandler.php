<?php

namespace CrudBuilder\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait FilesHandler
{
    /**
     * Return the names of the inputs of type file.
     *
     * @return array
     */
    public function getFilesNames(array $inputs)
    {
        return collect($inputs)
            ->filter(fn($input) => $input->type === 'file')
            ->pluck('name')
            ->toArray();
    }

    /**
     * Save the files to the specified resource.
     *
     * @param array $files
     * @param string $directory
     * @param \Illuminate\Database\Eloquent\Model $resource
     * @param \Illuminate\Http\Request $request
     * 
     * @return bool
     */
    public function saveFiles(array $files, string $directory, Model $resource, Request $request)
    {
        foreach($files as $filename) {
            if($request->hasFile($filename)) {
                $resource->$filename = $this->save($request->file($filename), $directory);
            }
        }

        return $resource->save();
    }

    /**
     * Update the files of the specified resource.
     *
     * @param array $files
     * @param string $directory
     * @param \Illuminate\Database\Eloquent\Model $resource
     * @param \Illuminate\Http\Request $request
     * 
     * @return bool
     */
    public function updateFiles(array $files, string $directory, Model $resource, Request $request)
    {
        foreach($files as $filename) {
            if($request->hasFile($filename)) {
                $this->delete($resource, $filename); 
                $resource->$filename = $this->save($request->file($filename), $directory);
            }
        }

        return $resource->save();
    }

    /**
     * Save file to the given directory
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     * 
     * @return string
     */
    protected function save(UploadedFile $file, string $directory)
    {
        return $file->store($directory, $this->getDisk());
    }

    /**
     * Deletes the old version of the file.
     *
     * @param \Illuminate\Database\Eloquent\Model $resource
     * @param string $file
     * 
     * @return bool
     */
    protected function delete(Model $resource, string $file)
    {
        return Storage::disk($this->getDisk())->delete($resource->$file);
    }

    /**
     * Return the filesystem disk.
     *
     * @return string
     */
    protected function getDisk()
    {
        return config('crudbuilder.disk') ?? 'public';
    }
}