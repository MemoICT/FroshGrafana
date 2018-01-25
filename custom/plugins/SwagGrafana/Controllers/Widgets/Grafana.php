<?php

class Shopware_Controllers_Widgets_Grafana extends Enlight_Controller_Action
{
    const PLUGIN_NAME = 'SwagGrafana';
    const CONFIG_FIELD_ACCESS_TOKEN = 'accessToken';

    /**
     * @throws \Exception
     */
    public function preDispatch()
    {
        $this->container->get('front')->Plugins()->ViewRenderer()->setNoRender();
        $this->Response()->setHeader('Content-Type', 'application/json; charset=utf-8');

        if ($this->validateAccessToken()) {
            return;
        }

        http_response_code(500);
        exit;
    }

    /**
     * / should return 200 ok. Used for "Test connection" on the datasource config page.
     */
    public function indexAction()
    {
        $this->Response()->setBody(\json_encode(['asd']));
    }

    /**
     * /search used by the find metric options on the query tab in panels.
     */
    public function searchAction()
    {
        $this->Response()->setBody(\json_encode([])); // todo: gather valid data
    }

    /**
     * /query should return metrics based on input.
     */
    public function queryAction()
    {
        $this->Response()->setBody(\json_encode([])); // todo: gather valid data
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