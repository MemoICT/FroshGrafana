<?php

use Shopware\Components\CSRFWhitelistAware;

class Shopware_Controllers_Widgets_Grafana extends Enlight_Controller_Action implements CSRFWhitelistAware
{
    const PLUGIN_NAME = 'FroshGrafana';
    const CONFIG_FIELD_ACCESS_TOKEN = 'accessToken';

    public function getWhitelistedCSRFActions()
    {
        return [
            'index',
            'search',
            'query',
            'annotations',
        ];
    }

    /**
     * @throws \Exception
     */
    public function preDispatch()
    {
        $this->container->get('front')->Plugins()->ViewRenderer()->setNoRender();
        $this->Response()->setHeader('Content-Type', 'application/json; charset=utf-8');

        /* @ToDo: Implement different authentication method. */
        /*if ($this->validateAccessToken()) {
            return;
        }

        die('Unauthorized.');*/
    }

    /**
     * / should return 200 ok. Used for "Test connection" on the datasource config page.
     */
    public function indexAction()
    {
        $this->Response()->setBody(\json_encode([]));
    }

    /**
     * /search used by the find metric options on the query tab in panels.
     */
    public function searchAction()
    {
        $this->Response()->setBody(
            \json_encode(
                [
                    ['text' => 'Anz. Bestellungen', 'value' => 'orders_count'],
                    ['text' => 'Kunden-Registrierungen', 'value' => 'customer_registrations'],
                    ['text' => 'Test', 'value' => 'test'],
                    ['text' => 'Umsatz', 'value' => 'turnover'],
                    ['text' => 'Besucher', 'value' => 'visitors'],
                ]
            )
        );
    }

    /**
     * /query should return metrics based on input.
     * @throws Exception
     */
    public function queryAction()
    {
        $queryResponse = $this->container->get('frosh_grafana.components.grafana.query_response');
        $queryRequest = $this->container->get('frosh_grafana.components.grafana.query_request');
        $queryRequest->setFromRequest($this->Request()->getRawBody());

        try {
            foreach ($queryRequest->getTargets() as $target) {
                /** @var \FroshGrafana\Components\Search\MetricInterface $metric */
                $metric = $this->container->get(
                    sprintf('frosh_grafana.components.search.%s_metric', $target->target)
                );

                $metric->setRequest($queryRequest);

                $queryResponse->addTarget(
                    [
                        'target'     => $metric->getId(),
                        'datapoints' => $metric->getDataPoints(),
                    ]
                );
            }

        } catch (\Exception $exception) {
            /** @var \Psr\Log\LoggerInterface $log */
            $this->container->get('corelogger')->critical(
                sprintf('Trying to get unknown metric "%s".', $target->target),
                [$target, $exception->getMessage()]
            );
            exit;
        }

        $this->Response()->setBody($queryResponse->getResponse());
    }

    /**
     * /annotations should return annotations.
     */
    public function annotationsAction()
    {
        $this->Response()->setBody(\json_encode([])); // todo: gather valid data
    }

    /**
     * @return bool
     * @throws Exception
     */
    private function validateAccessToken(): bool
    {
        $accessToken = $this->container->get('config')->getByNamespace(
            self::PLUGIN_NAME,
            self::CONFIG_FIELD_ACCESS_TOKEN
        );

        return $this->Request()->has(self::CONFIG_FIELD_ACCESS_TOKEN)
            && $this->Request()->get(self::CONFIG_FIELD_ACCESS_TOKEN) === $accessToken;
    }
}