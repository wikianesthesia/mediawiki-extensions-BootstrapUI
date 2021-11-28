<?php

namespace BootstrapUI;

use Html;

class ButtonGroupWidget extends Widget {

    public const ID = 'buttonGroup';

    public const BS_PREFIX = 'btn-group';

    /**
     * @inheritDoc
     */
    protected const WIDGET_PARAMS = [
        'buttonGroupVertical',
        'buttonGroupSize'
    ];

    /**
     * Stores the contents of the button group
     * @var string
     */
    protected $contents = null;

    /**
     * Initializes the widget
     * @param array $config
     * @param string $contents
     */
    public function __construct( array $config = [], string $contents = '' ) {
        parent::__construct( $config );

        $this->attribs = [
            'class' => '',
            'role' => 'group'
        ];

        foreach( static::getWidgetParams() as $widgetParam ) {
            # Required parameters
            if( $widgetParam == 'buttonGroupVertical' ) {
                $isVertical = isset( $config[ $widgetParam ] ) && $config[ $widgetParam ];

                $this->setButtonGroupClass( $isVertical );
            } elseif( isset( $config[ $widgetParam ] ) ) {
                # Optional parameters
                if( $widgetParam == 'buttonGroupSize' ) {
                    $this->addButtonGroupSizeClass( $config[ $widgetParam ] );
                } else {
                    $this->$widgetParam = $config[ $widgetParam ];
                }
            }

            unset( $config[ $widgetParam ] );
        }

        # class
        $this->attribs[ 'class' ] .= ' ' . $this->getWidgetElementClass( 'buttonGroup' );

        if( isset( $config[ 'class' ] ) ) {
            $this->attribs[ 'class' ] .= ' ' . $config[ 'class' ];

            unset( $config[ 'class' ] );
        }

        $this->attribs = array_merge( $this->attribs, $config );

        $this->contents = $contents;
    }

    /**
     * @inheritDoc
     */
    public function getHtml(): string {
        return Html::rawElement( 'div', $this->attribs, $this->contents );
    }

    /**
     * Adds the button group size class if applicable.
     * @param string $buttonGroupSize
     */
    protected function addButtonGroupSizeClass( string $buttonGroupSize = '' ) {
        if( in_array( $buttonGroupSize, BootstrapUI::VALID_BUTTONGROUP_SIZES ) ) {
            $this->attribs[ 'class' ] .= ' ' . $buttonGroupSize;
        }
    }

    /**
     * Gets BootstrapUI classes to allow for subsequent modification
     * @param string $element
     * @return string
     */
    protected function getWidgetElementClass( string $element ): string {
        $elementClass = '';

        if( $element == 'buttonGroup' ) {
            $elementClass = static::bsUiPrefix() . 'buttonGroup';
        }

        return $elementClass;
    }

    /**
     * Sets the primary button group class. This must be called before any other classes are added.
     * @param bool $isVertical
     * @return bool
     */
    protected function setButtonGroupClass( bool $isVertical = false ): bool {
        $buttonGroupClass = static::BS_PREFIX;

        if( $isVertical ) {
            $buttonGroupClass .= '-vertical';
        }

        $this->attribs[ 'class' ] = $buttonGroupClass;

        return true;
    }
}