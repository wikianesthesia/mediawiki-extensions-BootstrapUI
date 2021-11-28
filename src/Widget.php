<?php


namespace BootstrapUI;

abstract class Widget {

    /**
     * Stores the tag attributes
     * @var array
     */
    protected $attribs = [];

    /**
     * String identifier for this widget to use when generating ids
     * @var string
     */
    public const ID = 'widget';

    /**
     * Parameters to $config which are not allowed
     * @var array
     */
    protected const RESTRICTED_PARAMS = [];

    /**
     * Parameters to $config which are handled by the widget and should not be included as attributes in the tag
     * @var array
     */
    protected const WIDGET_PARAMS = [];

    final protected static function bsUiPrefix(): string {
        return 'bs-ui-';
    }

    /**
     * Generates a unique id for an element
     * @return string
     */
    public static function makeUniqueId( $idNameSuffix = '' ): string {
        global $bootstrapUIIDRegistry;

        if( !isset( $bootstrapUIIDRegistry ) ) {
            $bootstrapUIIDRegistry = [];
        }

        $idName = static::ID;

        if( $idNameSuffix ) {
            $idName .= '-' . $idNameSuffix;
        }

        if( !isset( $bootstrapUIIDRegistry[ $idName ] ) ) {
            $bootstrapUIIDRegistry[ $idName ] = 0;
        }

        $bootstrapUIIDRegistry[ $idName ]++;

        return static::bsUiPrefix() . $idName . '-' . $bootstrapUIIDRegistry[ $idName ];
    }

    /**
     * Gets the widget parameters for $config
     * @return array
     */
    protected static function getWidgetParams(): array {
        $widgetParams = get_parent_class( static::class ) ? call_user_func( get_parent_class( static::class ) . '::getWidgetParams' ) : [];

        return array_unique( array_merge( $widgetParams, static::WIDGET_PARAMS ) );
    }

    /**
     * Widget constructor.
     *
     * Removes restricted parameters to $config
     *
     * @param array $config
     */
    public function __construct( array &$config ) {
        foreach( static::RESTRICTED_PARAMS as $restrictedParam ) {
            unset( $config[ $restrictedParam ] );
        }
    }

    /**
     * @return string
     */
    public function __toString(): string {
        return $this->getHtml();
    }

    public function getAttrib( string $attrib ) {
        if( isset( $this->attribs[ $attrib ] ) ) {
            return $this->attribs[ $attrib ];
        }
    }

    /**
     * Gets the widget HTML
     * @return string
     */
    abstract public function getHtml(): string;
}