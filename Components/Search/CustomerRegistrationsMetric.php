<?php

namespace FroshGrafana\Components\Search;

use FroshGrafana\Components\Dbal\CustomersGateway;

class CustomerRegistrationsMetric extends Metric
{
    /** @var CustomersGateway $customersGateway */
    private $customersGateway;

    /**
     * CustomerRegistrationsMetric constructor.
     *
     * @param CustomersGateway $customersGateway
     */
    public function __construct(CustomersGateway $customersGateway)
    {
        $this->customersGateway = $customersGateway;
    }

    /**
     * Returns the id of this metric which is used as target in query requests.
     *
     * @return string
     */
    public function getId(): string
    {
        return 'customers';
    }

    /**
     * Returns the name of this metric which is shown in the 'find metric' options on the query tab in panels.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'Customers';
    }

    /**
     * @return array
     */
    public function getDataPoints(): array
    {
        $range = $this->getRequest()->getRange();
        $fromDate = new \DateTime($range['from']);
        $toDate = new \DateTime($range['to']);

        $fromDate->setTimezone(new \DateTimeZone(\date_default_timezone_get()));
        $toDate->setTimezone(new \DateTimeZone(\date_default_timezone_get()));

        return $this->customersGateway->getRegisterCount(
            $fromDate,
            $toDate,
            $this->getRequest()->getIntervalSeconds()
        );
    }
}