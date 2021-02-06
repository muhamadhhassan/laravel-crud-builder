<?php

namespace CrudBuilder\Services;

use CrudBuilder\CRUDBuilder;
use CrudBuilder\Traits\FilesHandler;
use CrudBuilder\Traits\PasswordsHandler;
use CrudBuilder\Traits\SyncedRelation;

class CreateRecordService
{
    use FilesHandler, PasswordsHandler, SyncedRelation;

    /**
     * Undocumented variable
     *
     * @var \CrudBuilder\CRUDBUilder
     */
    protected $builder;

    /**
     * class constructor
     *
     * @param \CrudBuilder\CRUDBuilder $crudBuilder
     */
    public function __construct(CRUDBuilder $crudBuilder)
    {
        $this->builder = $crudBuilder;
    }

    /**
     * save new record of the builder resource
     *
     * @return \Illuminate\Http\Response
     */
    public function save()
    {
        $request = $this->builder->request;
        $validator = $this->builder->validator($request);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $syncedRelation = $this->getSyncedRelationsNames($this->builder->syncedEntities);
        $filesNames = $this->getFilesNames($this->builder->createInputs);
        $input = $this->hashPasswords($this->builder->createInputs, $request->except($syncedRelation + $filesNames));
        $resource = $this->builder->resourceClass::create($input);
        
        $this->attach($resource, $request->only($syncedRelation), $this->builder->syncedEntities);
        $this->saveFiles($filesNames, $this->builder->resourceNamePlural, $resource, $request);

        return redirect($this->builder->route)->with('success', $this->builder->resourceName.' was created successfully');
    }
}