<?php

namespace CrudBuilder\Traits;

use CrudBuilder\Helpers\SyncedEntity;
use Exception;
use Illuminate\Database\Eloquent\Model;

trait SyncedRelation
{
    /**
     * The many to many relations that will require syncing.
     *
     * @var array
     */
    public $syncedEntities = [];

    /**
     * Add a relation to the synced relation collection.
     *
     * @param string $className
     * @param array $properties
     * @param array $pivotProperties
     * @param string $relation
     * @return \CRUDBuilder
     */
    public function addSyncedEntity(string $className, array $properties, array $pivotProperties, string $relation, bool $taggable = false)
    {
        if (! class_exists($className)) {
            throw new \Exception("The model '{$className}' does not exist.", 500);
        }

        if (! is_subclass_of((new $className()), 'Illuminate\Database\Eloquent\Model')) {
            throw new \Exception("The class '{$className}' must be an instance of 'Illuminate\Database\Eloquent\Model'", 500);
        }

        array_push($this->syncedEntities, new SyncedEntity($className, $properties, $pivotProperties, $relation, $taggable));

        return $this;
    }

    /**
     * Return an array of relations' names.
     *
     * @return array
     */
    public function getSyncedRelations()
    {
        return collect($this->syncedEntities)
            ->map(function ($entity) {
                return $entity->relation;
            })->toArray();
    }

    public function attach(Model $resource, array $attachments)
    {
        foreach ($attachments as $relation => $attachment) {
            $ids = $this->getIds($relation, $attachment);
            $resource->$relation()->attach($ids);
        }
    }

    public function sync(Model $resource, array $attachments)
    {
        foreach ($attachments as $relation => $attachment) {
            $ids = $this->getIds($relation, $attachment);
            $resource->$relation()->sync($ids);
        }
    }

    /**
     * Return the entity ids to be attached or synced to the resource.
     *
     * @param string $relation
     * @param array $inputIds
     * @return array
     */
    protected function getIds(string $relation, array $inputIds): array
    {
        $syncedEntity = collect($this->syncedEntities)->filter(function ($entity) use ($relation) {
            return $entity->relation === $relation;
        })->first();

        $filteredIds = collect($inputIds)->map(function ($id) use ($syncedEntity) {
            if (! $syncedEntity->className::find($id) && $syncedEntity->createNewRecord) {
                return $syncedEntity->className::create(['name' => $id])->id;
            }

            return $id;
        })->toArray();

        return $filteredIds;
    }

    public function getParentProperty(Model $entity, string $relation, $property)
    {
        $parent = collect($this->syncedEntities)
            ->filter(function ($entity) use ($relation) {
                return $entity->relation === $relation;
            })->first();

        if (! $parent) {
            throw new Exception("No parent entities with the relation '$property'", 500);
        }

        return $entity->$relation->$property;
    }
}
