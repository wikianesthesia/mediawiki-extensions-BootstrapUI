<?php


namespace BootstrapUI\Hooks;

use Bootstrap\BootstrapManager;

class SetupAfterCache {
    public static function callback() {
        $bootstrapManager = BootstrapManager::getInstance();

        $bootstrapManager->addAllBootstrapModules();

        # TODO Convert this to use a Bootstrap\Definition\ModuleDefinition and then call $bootstrapManager->addBootstrapModule()?

        # This current approach just attaches to ext.bootstrap rather than creating our own resource module.

        $resourceModuleLocalBasePath = $GLOBALS[ 'wgExtensionDirectory' ] . '/BootstrapUI/resources';
        $resourceModuleRemoteBasePath = $GLOBALS[ 'wgExtensionAssetsPath' ] . '/BootstrapUI/resources';
        $resourceModuleScriptBasePath = '../../../../BootstrapUI/resources/';

        # Font Awesome
        # We have to take this particular approach with Font Awesome to preserve compatibility with the Chameleon skin
        # which is expecting fontawesome SCSS variables to be defined in the skin's scss.
        $bootstrapManager->addStyleFile(
            $resourceModuleLocalBasePath . '/fontawesome/scss/fontawesome.scss',
            'beforeMain'
        );

        $bootstrapManager->addStyleFile(
            $resourceModuleLocalBasePath . '/fontawesome/scss/brands.scss',
            'beforeMain'
        );

        $bootstrapManager->addStyleFile(
            $resourceModuleLocalBasePath . '/fontawesome/scss/regular.scss',
            'beforeMain'
        );

        $bootstrapManager->addStyleFile(
            $resourceModuleLocalBasePath . '/fontawesome/scss/solid.scss',
            'beforeMain'
        );

        self::addScriptFile( $resourceModuleScriptBasePath . '/fontawesome/js/all.min.js' );

        $bootstrapManager->setScssVariable( 'fa-font-path', $resourceModuleRemoteBasePath . '/fontawesome/webfonts' );

        # BootstrapUI
        $bootstrapManager->addStyleFile(
            $resourceModuleLocalBasePath . '/bootstrapui/scss/bootstrapui.scss',
            'afterMain'
        );

        self::addScriptFile( $resourceModuleScriptBasePath . '/bootstrapui/js/bootstrapui.js' );
        self::addScriptFile( $resourceModuleScriptBasePath . '/bootstrapui/js/bootstrapui-widgets.js' );
    }

    public static function addScriptFile( $file ) {
        # Why isn't there an $bootstrapManager->addScriptFile()?
        # I think because we declare the dependency on Bootstrap, we shouldnt have to worry about this being initialized

        $GLOBALS[ 'wgResourceModules' ][ 'ext.bootstrap.scripts' ][ 'scripts' ] =
            array_merge(
                $GLOBALS[ 'wgResourceModules' ][ 'ext.bootstrap.scripts' ][ 'scripts' ],
                (array) $file
            );
    }
}