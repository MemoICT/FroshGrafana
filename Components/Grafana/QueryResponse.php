<?php

namespace FroshGrafana\Components\Grafana;

class QueryResponse
{
    /** @var array $targets */
    private $targets;

    /**
     * @return array
     */
    public function getTargets(): array
    {
        return $this->targets;
    }

    /**
     * @param array $targets
     */
    public function setTargets(array $targets)
    {
        $this->targets = $targets;
    }

    /**
     * @param array $target
     */
    public function addTarget(array $target)
    {
        $this->targets[] = $target;
    }

    /**
     * @return string
     */
    public function getResponse(): string
    {
        return \json_encode($this->getTargets());
    }
}