<?php

namespace FroshGrafana\Components\Search;

class TestMetric extends Metric
{
    /**
     * Returns the id of this metric which is used as target in query requests.
     *
     * @return string
     */
    public function getId(): string
    {
        return 'test';
    }

    /**
     * Returns the name of this metric which is shown in the 'find metric' options on the query tab in panels.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'Test';
    }

    /**
     * @return array
     */
    public function getDataPoints(): array
    {
        $ret = [];

        foreach (\range(1, 200) as $item) {
            $ret[] = [\random_int(0, 999), \microtime(true) * 1000 - ($item * 1000 * 60)];
        }

        return \array_reverse($ret);
    }
}