<?php

namespace FroshGrafana\Models\StateSnapshots;

use FroshGrafana\Models\AbstractEntity;

/**
 * Entity for table s_plugin_frosh_grafana_state_snapshots
 */
class StateSnapshots extends AbstractEntity
{
    /** @var int $id */
    protected $id;

    /** @var string $system_load */
    protected $system_load;

    /** @var string $ram_usage */
    protected $ram_usage;

    /** @var int $visitors */
    protected $visitors;

    /** @var int $orders_count */
    protected $orders_count;

    /** @var string $orders_turnover */
    protected $orders_turnover;

    /** @var \DateTime $created */
    protected $created;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @param int $id
     *
     * @return self
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }


    /**
     * @return string
     */
    public function getSystemLoad(): string
    {
        return $this->system_load;
    }


    /**
     * @param string $system_load
     *
     * @return self
     */
    public function setSystemLoad(string $system_load): self
    {
        $this->system_load = $system_load;

        return $this;
    }


    /**
     * @return string
     */
    public function getRamUsage(): string
    {
        return $this->ram_usage;
    }


    /**
     * @param string $ram_usage
     *
     * @return self
     */
    public function setRamUsage(string $ram_usage): self
    {
        $this->ram_usage = $ram_usage;

        return $this;
    }


    /**
     * @return int
     */
    public function getVisitors(): int
    {
        return $this->visitors;
    }


    /**
     * @param int $visitors
     *
     * @return self
     */
    public function setVisitors(int $visitors): self
    {
        $this->visitors = $visitors;

        return $this;
    }


    /**
     * @return int
     */
    public function getOrdersCount(): int
    {
        return $this->orders_count;
    }


    /**
     * @param int $orders_count
     *
     * @return self
     */
    public function setOrdersCount(int $orders_count): self
    {
        $this->orders_count = $orders_count;

        return $this;
    }


    /**
     * @return string
     */
    public function getOrdersTurnover(): string
    {
        return $this->orders_turnover;
    }


    /**
     * @param string $orders_turnover
     *
     * @return self
     */
    public function setOrdersTurnover(string $orders_turnover): self
    {
        $this->orders_turnover = $orders_turnover;

        return $this;
    }


    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }


    /**
     * @param \DateTime $created
     *
     * @return self
     */
    public function setCreated(\DateTime $created): self
    {
        $this->created = $created;

        return $this;
    }
}
