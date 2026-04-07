<?php namespace Pensoft\CitationTool;

use Backend;
use System\Classes\PluginBase;
use Pensoft\CitationTool\Components\Form;

/**
 * CitationTool Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     */
    public function pluginDetails(): array
    {
        return [
            'name'        => 'CitationTool',
            'description' => 'No description provided yet...',
            'author'      => 'Pensoft',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     */
    public function register(): void
    {

    }

    /**
     * Boot method, called right before the request route.
     */
    public function boot(): void
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     */
    public function registerComponents(): array
    {
        return [
            Form::class => 'AddCitationForm',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     */
    public function registerPermissions(): array
    {
        return [
            'pensoft.citationtool.access' => [
                'tab' => 'Citation Tool',
                'label' => 'Manage citation tool'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     */
    public function registerNavigation(): array
    {
        return [
            'main-menu-item' => [
                'label'       => 'Citation Tool',
                'url'         => Backend::url('pensoft/citationtool/citations'),
                'icon'        => 'icon-align-justify',
                'permissions' => ['pensoft.citationtool.*'],
                'order'       => 500,
            ],
        ];
    }
}
