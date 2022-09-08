<?php

/**
 * LMSDowndetectorPlugin
 * 
 * @author Łukasz Kopiszka <lukasz@alfa-system.pl>
 */
class LMSDowndetectorPlugin extends LMSPlugin
{
    const PLUGIN_NAME = 'LMS Downdetector API plugin';
    const PLUGIN_DESCRIPTION = 'Integration with Downdetector API.';
    const PLUGIN_AUTHOR = 'Łukasz Kopiszka &lt;lukasz@alfa-system.pl&gt;';
    const PLUGIN_DIRECTORY_NAME = 'LMSDowndetectorPlugin';

    public function registerHandlers()
    {
        $this->handlers = array(
            'smarty_initialized' => array(
                'class' => 'DowndetectorHandler',
                'method' => 'smartyDowndetector'
            ),
            'modules_dir_initialized' => array(
                'class' => 'DowndetectorHandler',
                'method' => 'modulesDirDowndetector'
            ),
            'welcome_before_module_display' => array(
                'class' => 'DowndetectorHandler',
                'method' => 'welcomeDowndetector'
            ),
            'access_table_initialized' => array(
                'class' => 'DowndetectorHandler',
                'method' => 'accessTableInit'
            ),
        );
    }
}
