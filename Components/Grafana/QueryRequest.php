<?php

namespace FroshGrafana\Components\Grafana;

class QueryRequest
{
    /** @var array $range */
    private $range;
    /** @var string $interval */
    private $interval;
    /** @var float $intervalMilliseconds */
    private $intervalMilliseconds;
    /** @var array $targets */
    private $targets;
    /** @var string $format */
    private $format = 'json';
    /** @var int $maxDataPoints */
    private $maxDataPoints;

    /**
     * @return array
     */
    public function getRange(): array
    {
        return $this->range;
    }

    /**
     * @param array $range
     */
    public function setRange(array $range)
    {
        $this->range = $range;
    }

    /**
     * @return string
     */
    public function getInterval(): string
    {
        return $this->interval;
    }

    /**
     * @param string $interval
     */
    public function setInterval(string $interval)
    {
        $this->interval = $interval;
    }

    /**
     * @return float
     */
    public function getIntervalSeconds(): float
    {
        return $this->getIntervalMilliseconds() / 1000;
    }

    /**
     * @return float
     */
    public function getIntervalMilliseconds(): float
    {
        return $this->intervalMilliseconds;
    }

    /**
     * @param float $intervalMilliseconds
     */
    public function setIntervalMilliseconds(float $intervalMilliseconds)
    {
        $this->intervalMilliseconds = $intervalMilliseconds;
    }

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
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @param string $format
     */
    public function setFormat(string $format)
    {
        $this->format = $format;
    }

    /**
     * @return int
     */
    public function getMaxDataPoints(): int
    {
        return $this->maxDataPoints;
    }

    /**
     * @param int $maxDataPoints
     */
    public function setMaxDataPoints(int $maxDataPoints)
    {
        $this->maxDataPoints = $maxDataPoints;
    }

    /**
     * @param string $requestJsonPayload
     *
     * @return bool
     */
    public function setFromRequest(string $requestJsonPayload): bool
    {
        $payload = \json_decode($requestJsonPayload);

        if (!$payload) {
            return false;
        }

        $this->setRange($payload->range ? (array)$payload->range : []);
        $this->setInterval($payload->interval ?? '20s');
        $this->setIntervalMilliseconds($payload->intervalMs ?? 43200000);
        $this->setTargets($payload->targets ?? []);
        $this->setMaxDataPoints($payload->maxDataPoints ?? PHP_INT_MAX); // no risk, no fun :)

        return true;
    }
}