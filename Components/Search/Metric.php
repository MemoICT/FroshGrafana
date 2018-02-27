<?php

namespace FroshGrafana\Components\Search;

use FroshGrafana\Components\Grafana\QueryRequest;

class Metric implements MetricInterface
{
    /** @var QueryRequest $request */
    protected $request;

    /**
     * @return QueryRequest
     */
    public function getRequest(): QueryRequest
    {
        return $this->request;
    }

    /**
     * @param QueryRequest $request
     */
    public function setRequest(QueryRequest $request)
    {
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return '';
    }

    /**
     * @return array
     */
    public function getDataPoints(): array
    {
        return [];
    }

}