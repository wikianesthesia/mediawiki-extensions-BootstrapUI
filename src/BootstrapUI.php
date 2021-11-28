<?php


namespace BootstrapUI;

class BootstrapUI {

    /*
     * General constants
     */
    public const TEXT_COLOR_PRIMARY = 'text-primary';
    public const TEXT_COLOR_SECONDARY = 'text-secondary';
    public const TEXT_COLOR_SUCCESS = 'text-success';
    public const TEXT_COLOR_DANGER = 'text-danger';
    public const TEXT_COLOR_WARNING = 'text-warning';
    public const TEXT_COLOR_INFO = 'text-info';
    public const TEXT_COLOR_LIGHT = 'text-light';
    public const TEXT_COLOR_DARK = 'text-dark';
    public const TEXT_COLOR_MUTED = 'text-muted';
    public const TEXT_COLOR_WHITE = 'text-white';

    public const VALID_TEXT_COLORS = [
        self::TEXT_COLOR_PRIMARY,
        self::TEXT_COLOR_SECONDARY,
        self::TEXT_COLOR_SUCCESS,
        self::TEXT_COLOR_DANGER,
        self::TEXT_COLOR_WARNING,
        self::TEXT_COLOR_INFO,
        self::TEXT_COLOR_LIGHT,
        self::TEXT_COLOR_DARK,
        self::TEXT_COLOR_MUTED,
        self::TEXT_COLOR_WHITE,
    ];


    /*
     * AlertWidget constants
     */
    public const ALERT_STYLE_PRIMARY = 'alert-primary';
    public const ALERT_STYLE_SECONDARY = 'alert-secondary';
    public const ALERT_STYLE_SUCCESS = 'alert-success';
    public const ALERT_STYLE_DANGER = 'alert-danger';
    public const ALERT_STYLE_WARNING = 'alert-warning';
    public const ALERT_STYLE_INFO = 'alert-info';
    public const ALERT_STYLE_LIGHT = 'alert-light';
    public const ALERT_STYLE_DARK = 'alert-dark';

    public const DEFAULT_ALERT_STYLE = self::ALERT_STYLE_PRIMARY;

    public const VALID_ALERT_STYLES = [
        self::ALERT_STYLE_PRIMARY,
        self::ALERT_STYLE_SECONDARY,
        self::ALERT_STYLE_SUCCESS,
        self::ALERT_STYLE_DANGER,
        self::ALERT_STYLE_WARNING,
        self::ALERT_STYLE_INFO,
        self::ALERT_STYLE_LIGHT,
        self::ALERT_STYLE_DARK,
    ];


    /*
     * ButtonWidget constants
     */
    public const BUTTON_SIZE_SMALL = 'btn-sm';
    public const BUTTON_SIZE_LARGE = 'btn-lg';

    public const VALID_BUTTON_SIZES = [
        self::BUTTON_SIZE_SMALL,
        self::BUTTON_SIZE_LARGE
    ];

    public const BUTTON_STYLE_PRIMARY = 'btn-primary';
    public const BUTTON_STYLE_SECONDARY = 'btn-secondary';
    public const BUTTON_STYLE_SUCCESS = 'btn-success';
    public const BUTTON_STYLE_DANGER = 'btn-danger';
    public const BUTTON_STYLE_WARNING = 'btn-warning';
    public const BUTTON_STYLE_INFO = 'btn-info';
    public const BUTTON_STYLE_LIGHT = 'btn-light';
    public const BUTTON_STYLE_DARK = 'btn-dark';
    public const BUTTON_STYLE_LINK = 'btn-link';
    public const BUTTON_STYLE_OUTLINE_PRIMARY = 'btn-outline-primary';
    public const BUTTON_STYLE_OUTLINE_SECONDARY = 'btn-outline-secondary';
    public const BUTTON_STYLE_OUTLINE_SUCCESS = 'btn-outline-success';
    public const BUTTON_STYLE_OUTLINE_DANGER = 'btn-outline-danger';
    public const BUTTON_STYLE_OUTLINE_WARNING = 'btn-outline-warning';
    public const BUTTON_STYLE_OUTLINE_INFO = 'btn-outline-info';
    public const BUTTON_STYLE_OUTLINE_LIGHT = 'btn-outline-light';
    public const BUTTON_STYLE_OUTLINE_DARK = 'btn-outline-dark';

    public const DEFAULT_BUTTON_STYLE = self::BUTTON_STYLE_PRIMARY;

    public const VALID_BUTTON_STYLES = [
        self::BUTTON_STYLE_PRIMARY,
        self::BUTTON_STYLE_SECONDARY,
        self::BUTTON_STYLE_SUCCESS,
        self::BUTTON_STYLE_DANGER,
        self::BUTTON_STYLE_WARNING,
        self::BUTTON_STYLE_INFO,
        self::BUTTON_STYLE_LIGHT,
        self::BUTTON_STYLE_DARK,
        self::BUTTON_STYLE_LINK,
        self::BUTTON_STYLE_OUTLINE_PRIMARY,
        self::BUTTON_STYLE_OUTLINE_SECONDARY,
        self::BUTTON_STYLE_OUTLINE_SUCCESS,
        self::BUTTON_STYLE_OUTLINE_DANGER,
        self::BUTTON_STYLE_OUTLINE_WARNING,
        self::BUTTON_STYLE_OUTLINE_INFO,
        self::BUTTON_STYLE_OUTLINE_LIGHT,
        self::BUTTON_STYLE_OUTLINE_DARK
    ];


    /*
     * ButtonGroupWidget constants
     */
    public const BUTTONGROUP_SIZE_SMALL = 'btn-group-sm';
    public const BUTTONGROUP_SIZE_LARGE = 'btn-group-lg';

    public const VALID_BUTTONGROUP_SIZES = [
        self::BUTTONGROUP_SIZE_SMALL,
        self::BUTTONGROUP_SIZE_LARGE
    ];

    /*
     * Nav constants
     */

    public const NAV_STYLE_BUTTON = 'button';
    public const NAV_STYLE_PLAIN = 'plain';
    public const NAV_STYLE_PILLS = 'pills';
    public const NAV_STYLE_TABS = 'tabs';

    public const VALID_NAV_STYLES = [
        self::NAV_STYLE_BUTTON,
        self::NAV_STYLE_PLAIN,
        self::NAV_STYLE_PILLS,
        self::NAV_STYLE_TABS
    ];

    /** @var NavManager|null */
    private static $navManagerInstance = null;





    public static function alertWidget( array $config = [], string $contents = '' ): AlertWidget {
        return new AlertWidget( $config, $contents );
    }

    public static function buttonGroupWidget( array $config = [], string $contents = '' ): ButtonGroupWidget {
        return new ButtonGroupWidget( $config, $contents );
    }

    public static function buttonWidget( array $config = [] ): ButtonWidget {
        return new ButtonWidget( $config );
    }

    public static function checkboxInputWidget( array $config = [] ): CheckboxInputWidget {
        return new CheckboxInputWidget( $config );
    }

    public static function collapseWidget( array $config = [], string $contents = '' ): CollapseWidget {
        return new CollapseWidget( $config, $contents );
    }

    public static function getNavManager(): NavManager {
        if ( self::$navManagerInstance === null ) {
            self::$navManagerInstance = new NavManager();
        }

        return self::$navManagerInstance;
    }

    public static function iconWidget( array $config = [] ): IconWidget {
        return new IconWidget( $config );
    }

    public static function iconLayersWidget( array $config = [], string $contents = '' ): IconLayersWidget {
        return new IconLayersWidget( $config, $contents );
    }

    public static function iconTextLayerWidget( array $config = [], string $contents = '' ): IconTextLayerWidget {
        return new IconTextLayerWidget( $config, $contents );
    }

    public static function radioInputWidget( array $config = [] ): RadioInputWidget {
        return new RadioInputWidget( $config );
    }

    public static function textareaInputWidget( array $config = [] ): TextareaInputWidget {
        return new TextareaInputWidget( $config );
    }

    public static function textInputWidget( array $config = [] ): TextInputWidget {
        return new TextInputWidget( $config );
    }
}