<?php

namespace FroshGrafana\Models\StateSnapshots;

use Doctrine\DBAL\Connection;
use FroshGrafana\Models\AbstractRepository;

/**
 * Repository for table s_plugin_frosh_grafana_state_snapshots
 */
class StateSnapshotsRepository extends AbstractRepository
{
    /**
     * Table name
     *
     * @var string
     */
    const TABLE = 's_plugin_frosh_grafana_state_snapshots';

    /** @var Connection */
    private $connection;


    /**
     * StateSnapshotsRepository constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
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
        $qb = $this->connection->createQueryBuilder()
            ->select('*')
            ->from(self::TABLE);

        if ($offset) {
            $qb->setFirstResult($offset);
        }

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        if ($where) {
            foreach ($where as $key => $value) {
                $qb->andWhere(sprintf('%s = %s', $key, $qb->createNamedParameter($value)));
            }
        }

        if ($sorters) {
            foreach ($sorters as $field => $sort) {
                $qb->addOrderBy($field, $sort);
            }
        }

        $result = $qb->execute()->fetchAll();

        $records = [];

        foreach ($result as $item) {
            $records[] = $this->getEntityFromDatabaseArray($item);
        }

        return $records;
    }


    /**
     * @param array $where
     *
     * @return StateSnapshots
     */
    public function findOneBy(array $where): StateSnapshots
    {
        $qb = $this->connection->createQueryBuilder();

        $qb->select('*')
            ->from(self::TABLE);

        foreach ($where as $key => $value) {
            $qb->andWhere(sprintf('%s = %s', $key, $qb->createNamedParameter($value)));
        }

        $result = $qb->execute()->fetch();

        if (empty($result)) {
            return null;
        }

        return $this->getEntityFromDatabaseArray($result);
    }


    /**
     * @param int $id
     *
     * @return StateSnapshots
     */
    public function find(int $id): StateSnapshots
    {
        return $this->findOneBy(['id' => $id]);
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
        $databaseArray = $this->getDatabaseArrayFromEntity($entity);

        $this->connection->insert(
            self::TABLE,
            $databaseArray
        );

        $entity->setId($this->connection->lastInsertId());

        return $entity;
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
        $databaseArray = $this->getDatabaseArrayFromEntity($entity);

        $this->connection->update(
            self::TABLE,
            $databaseArray,
            ['id' => $entity->getId()]
        );

        return $entity;
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
        $this->connection->delete(
            self::TABLE,
            ['id' => $entity->getId()]
        );

        return $entity;
    }


    /**
     * Maps the given entity to the database array.
     *
     * @param StateSnapshots $entity
     *
     * @return array
     */
    public function getDatabaseArrayFromEntity(StateSnapshots $entity): array
    {
        $array = $entity->toArray();

        foreach ($array as &$item) {
            if ($item instanceof \DateTime) {
                $item = $item->format('Y-m-d H:i:s');
            } elseif (is_array($item)) {
                $item = json_encode($item);
            }
        }

        return $array;
    }


    /**
     * Prepares database array from properties.
     *
     * @param array $data
     *
     * @return StateSnapshots
     */
    public function getEntityFromDatabaseArray(array $data): StateSnapshots
    {
        $entity = new StateSnapshots();
        $entity->setId((int)$data['id']);
        $entity->setSystemLoad((string)$data['system_load']);
        $entity->setRamUsage((string)$data['ram_usage']);
        $entity->setVisitors((int)$data['visitors']);
        $entity->setOrdersCount((int)$data['orders_count']);
        $entity->setOrdersTurnover((string)$data['orders_turnover']);
        $entity->setCreated(new \DateTime($data['created']));

        return $entity;
    }
}
