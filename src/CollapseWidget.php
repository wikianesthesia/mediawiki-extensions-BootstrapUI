<?php

namespace BootstrapUI;

use Html;

class CollapseWidget extends Widget {

    /**
     * String identifier for this widget to use when generating ids
     * @var string
     */
    public const ID = 'collapse';

    public const BS_PREFIX = 'collapse';

    /**
     * @inheritDoc
     */
    protected const WIDGET_PARAMS = [
        'button',
        'buttonClass',
        'buttonStyle',
        'buttonSize',
        'card',
        'contents',
        'linkClass',
        'linkContents',
        'linkId'
    ];

    protected $button = null;
    protected $buttonStyle = null;
    protected $buttonSize = null;
    protected $card = null;
    protected $contents = null;
    protected $linkClass = null;
    protected $linkContents = null;
    protected $linkId = null;

    /**
     * Initializes the widget
     * @param array $config
     * @param string $contents
     */
    public function __construct( array $config = [], string $contents = '' ) {
        parent::__construct( $config );

        $this->attribs = [
            'class' => static::BS_PREFIX
        ];

        # Handle button attrib first
        if( isset( $config[ 'button' ] ) && $config[ 'button' ] ) {
            $this->button = true;
            $this->linkClass = ButtonWidget::BS_PREFIX;

            unset( $config[ 'button' ] );
        }

        foreach( static::getWidgetParams() as $widgetParam ) {
            # Required params
            if( $widgetParam == 'buttonStyle' ) {
                if( isset( $config[ $widgetParam ] ) ) {
                    $this->addButtonStyleClass( $config[ $widgetParam ] );
                }
                else {
                    $this->addButtonStyleClass();
                }
            } elseif( isset( $config[ $widgetParam ] ) ) {
                if( $widgetParam == 'buttonSize' ) {
                    $this->addButtonSizeClass( $config[ $widgetParam ] );
                } else {
                    $this->$widgetParam = $config[ $widgetParam ];
                }
            }

            unset( $config[ $widgetParam ] );
        }

        # class
        $this->attribs[ 'class' ] .= ' ' . $this->getWidgetElementClass();

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
        $html = '';

        if( !$this->getAttrib( 'id' ) ) {
            $this->attribs[ 'id' ] = static::makeUniqueId();
        }

        $linkAttribs = [
            'data-toggle' => 'collapse',
            'href' => '#' . $this->getAttrib( 'id' ),
            'role' => 'button',
            'aria-expanded' => 'false',
            'aria-controls' => $this->getAttrib( 'id' )
        ];

        if( $this->linkClass ) {
            $linkAttribs[ 'class' ] = $this->linkClass;
        }

        $html .= Html::rawElement( 'a', $linkAttribs, $this->linkContents );

        if( $this->card ) {
            $this->contents = Html::rawElement( 'div', [
                'class' => 'card card-body',
            ], $this->contents );
        }

        $html .= Html::rawElement( 'div', $this->attribs, $this->contents );

        return $html;
    }

    /**
     * Adds the button size class if applicable.
     * @param string $buttonSize
     */
    protected function addButtonSizeClass( string $buttonSize = '' ) {
        if( !$this->button ) {
            return;
        }

        if( in_array( $buttonSize, BootstrapUI::VALID_BUTTON_SIZES ) ) {
            $this->linkClass .= ' ' . $buttonSize;
        }
    }

    /**
     * Adds the alert style class if applicable.
     * @param string $buttonStyle
     */
    protected function addButtonStyleClass( string $buttonStyle = '' ) {
        if( !$this->button ) {
            return;
        }

        $this->linkClass .=  ' ';

        if( in_array( $buttonStyle, BootstrapUI::VALID_BUTTON_STYLES ) ) {
            $this->linkClass .= $buttonStyle;
        } else {
            $this->linkClass .= BootstrapUI::DEFAULT_BUTTON_STYLE;
        }
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