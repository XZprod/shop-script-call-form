<?php

class shopOrdercalllocBuildForm extends waViewAction
{
    public function execute()
    {
        $app_config = wa()->getConfig()->getAppConfig('shop');
        $pluginPath = $app_config->getPluginPath('ordercallloc');

        $this->setTemplate($pluginPath . '/templates/form.html');
//        $plugin_id = 'ordercallloc';

        $link = wa('shop')->getPlugin('ordercallloc')->getSettings('policyLink');
        $this->view->assign('link', $link);
        $this->view->display($pluginPath . '/templates/form.html');
    }
}