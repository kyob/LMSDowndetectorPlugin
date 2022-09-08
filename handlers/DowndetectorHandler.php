<?php

class DowndetectorHandler
{
    public function smartyDowndetector(Smarty $hook_data)
    {
        $template_dirs = $hook_data->getTemplateDir();
        $plugin_templates = PLUGINS_DIR . DIRECTORY_SEPARATOR . LMSDowndetectorPlugin::PLUGIN_DIRECTORY_NAME . DIRECTORY_SEPARATOR . 'templates';
        array_unshift($template_dirs, $plugin_templates);
        $hook_data->setTemplateDir($template_dirs);
        return $hook_data;
    }

    public function modulesDirDowndetector(array $hook_data = array())
    {
        $plugin_modules = PLUGINS_DIR . DIRECTORY_SEPARATOR . LMSDowndetectorPlugin::PLUGIN_DIRECTORY_NAME . DIRECTORY_SEPARATOR . 'modules';
        array_unshift($hook_data, $plugin_modules);
        return $hook_data;
    }

    public function welcomeDowndetector(array $hook_data = array())
    {
        $SMARTY = LMSSmarty::getInstance();

        $urls = array(
            'PL' => array(
                'url' => 'https://downdetector.pl/',
                'xpath' => "(//div[contains(@class,'container')]/div[@class='row'])[2]",
            ),
        );

        $output = array();

        foreach ($urls as $key => $value) {
            $html = new DOMDocument();
            //echo $value['url'];
            @$html->loadHtmlFile($value['url']);
            $xpath = new DOMXPath($html);
            $query = $xpath->query($value['xpath']);
            foreach ($query as $n) {
                $list = $n->nodeValue;
            }
            $values = preg_split('/\r\n|\r|\n/', $list); // new line is separator
            $values = array_values(array_filter(array_map('trim', $values), 'strlen'));
            $values = array_slice($values, 0, 10);
            $output[$key] = $values;
        }

        $SMARTY->assign(
            array('downs' => $output)
        );

        return $hook_data;
    }


    public function accessTableInit()
    {
        $access = AccessRights::getInstance();
        $access->insertPermission(new Permission(
            'Downdetector_full_access',
            trans('Downdetector'),
            '^Downdetector$'
        ), AccessRights::FIRST_FORBIDDEN_PERMISSION);
    }
}
