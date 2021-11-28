<?php

namespace BootstrapUI;

use Html;

class IconWidget extends Widget {

    /**
     * String identifier for this widget to use when generating ids
     * @var string
     */
    public const ID = 'icon';

    /**
     * @inheritDoc
     */
    protected const WIDGET_PARAMS = [];

    /**
     * Initializes the widget
     * @param array $config
     * @param string $contents
     */
    public function __construct( array $config = [] ) {
        parent::__construct( $config );

        $this->attribs = [
            'class' => $this->getWidgetElementClass()
        ];

        if( isset( $config[ 'class' ] ) ) {
            $this->attribs[ 'class' ] .= ' ' . $config[ 'class' ];

            unset( $config[ 'class' ] );
        }

        $this->attribs = array_merge( $this->attribs, $config );
    }

    /**
     * @inheritDoc
     */
    public function getHtml(): string {
        $html = '';

        $html .= Html::rawElement( 'i', $this->attribs );

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