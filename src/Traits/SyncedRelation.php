<?php

namespace CrudBuilder\Traits;

use Exception;
use Illuminate\Database\Eloquent\Model;

trait SyncedRelation
{
    /**
     * Return an array of relations' names.
     *
     * @return array
     */
    public function getSyncedRelationsNames(array $entities)
    {
        return collect($entities)
            ->map(function ($entity) {
                return $entity->relation;
            })->toArray();
    }

    /**
     * Attach the given records to the specified resource
     *
     * @param \Illuminate\Database\Eloquent\Model $resource
     * @param array $attachments
     * 
     * @return void
     */
    public function attach(Model $resource, array $attachments, array $syncedEntities)
    {
        foreach ($attachments as $relation => $attachment) {
            $ids = $this->getIds($relation, $attachment, $syncedEntities);
            $resource->$relation()->attach($ids);
        }
    }

    /**
     * Sync the given records to the specified resource
     *
     * @param \Illuminate\Database\Eloquent\Model $resource
     * @param array $attachments
     * @return void
     */
    public function sync(Model $resource, array $attachments, array $syncedEntities)
    {
        foreach ($attachments as $relation => $attachment) {
            $ids = $this->getIds($relation, $attachment, $syncedEntities);
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
    protected function getIds(string $relation, array $inputIds, array $syncedEntities): array
    {
        $syncedEntity = collect($syncedEntities)->filter(function ($entity) use ($relation) {
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

    /**
     * Get the value of a property on the related entity.
     *
     * @param \Illuminate\Database\Eloquent\Model $entity
     * @param string $relation
     * @param string $property
     * @return void
     */
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
