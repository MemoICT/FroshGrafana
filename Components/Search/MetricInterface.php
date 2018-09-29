<?php

namespace FroshGrafana\Components\Search;

use FroshGrafana\Components\Grafana\QueryRequest;

interface MetricInterface
{
    /**
     * Returns the id of this metric which is used as target in query requests.
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Returns the name of the metric's column name in s_plugin_frosh_grafana_state_snapshots.
     *
     * @return string
     */
    public function getStateSnapshotColumnName(): string;

    /**
     * Returns the name of this metric which is shown in the 'find metric' options on the query tab in panels.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * @return array
     */
    public function getDataPoints(): array;

    /**
     * @return QueryRequest
     */
    public function getRequest(): QueryRequest;

    /**
     * @param QueryRequest $request
     *
     * @return void
     */
    public function setRequest(QueryRequest $request);
}