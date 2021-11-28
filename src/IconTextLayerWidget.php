<?php

namespace BootstrapUI;

use Html;

class IconTextLayerWidget extends Widget {

    /**
     * String identifier for this widget to use when generating ids
     * @var string
     */
    public const ID = 'iconLayerText';

    /**
     * @inheritDoc
     */
    protected const WIDGET_PARAMS = [
        'contents'
    ];

    protected $contents = null;

    /**
     * Initializes the widget
     * @param array $config
     * @param string $contents
     */
    public function __construct( array $config = [], $contents = '' ) {
        parent::__construct( $config );

        $this->attribs = [
            'class' => $this->getWidgetElementClass()
        ];

        foreach( static::getWidgetParams() as $widgetParam ) {
            if( isset( $config[ $widgetParam ] ) ) {
                $this->$widgetParam = $config[ $widgetParam ];
            }

            unset( $config[ $widgetParam ] );
        }

        if( isset( $config[ 'class' ] ) ) {
            $this->attribs[ 'class' ] .= ' ' . $config[ 'class' ];

            unset( $config[ 'class' ] );
        } else {
            $config[ 'class' ] .= ' fa-layers-text fa-inverse';
        }

        $this->attribs = array_merge( $this->attribs, $config );

        $this->contents = $contents;
    }

    /**
     * @inheritDoc
     */
    public function getHtml(): string {
        $html = '';

        $html .= Html::rawElement( 'span', $this->attribs, $this->contents );

        return $html;
    }

    /**
     * Gets BootstrapUI classes to allow for subsequent modification
     * @param string $element
     * @return string
     */
    protected function getWidgetElementClass( string $element = self::ID ): string {
        return static::bsUiPrefix() . $element;
    }
}