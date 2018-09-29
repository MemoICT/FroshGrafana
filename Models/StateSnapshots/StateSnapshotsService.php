<?php

namespace FroshGrafana\Models\StateSnapshots;

use FroshGrafana\Models\AbstractService;

/**
 * Service for table s_plugin_frosh_grafana_state_snapshots
 */
class StateSnapshotsService extends AbstractService
{
    /** @var StateSnapshotsRepository */
    private $repository;


    /**
     * StateSnapshotsService constructor.
     *
     * @param StateSnapshotsRepository $repository
     */
    public function __construct(StateSnapshotsRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Fetches all records.
     *
     * @param int|null   $offset
     * @param int|null   $limit
     * @param array|null $where
     * @param array|null $sorters
     *
     * @return StateSnapshots[]
     */
    public function findBy(int $offset = null, int $limit = null, array $where = null, array $sorters = null): array
    {
        return $this->repository->findBy($offset, $limit, $where, $sorters);
    }


    /**
     * @param array $where
     *
     * @return StateSnapshots
     */
    public function findOneBy(array $where): StateSnapshots
    {
        return $this->repository->findOneBy($where);
    }


    /**
     * @param int $id
     *
     * @return StateSnapshots
     */
    public function find(int $id): StateSnapshots
    {
        return $this->repository->find($id);
    }


    /**
     * Creates a record in the database.
     *
     * @param StateSnapshots $entity
     *
     * @return StateSnapshots
     */
    public function create(StateSnapshots $entity): StateSnapshots
    {
        return $this->repository->create($entity);
    }


    /**
     * Update a record in the database.
     *
     * @param StateSnapshots $entity
     *
     * @return StateSnapshots
     */
    public function update(StateSnapshots $entity): StateSnapshots
    {
        return $this->repository->update($entity);
    }


    /**
     * Remove a record in the database.
     *
     * @param StateSnapshots $entity
     *
     * @return StateSnapshots
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function remove(StateSnapshots $entity): StateSnapshots
    {
        return $this->repository->remove($entity);
    }
}
