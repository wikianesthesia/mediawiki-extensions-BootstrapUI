<?php

namespace BootstrapUI;

use Html;

class ButtonWidget extends Widget {

    public const ID = 'button';
    public const BS_PREFIX = 'btn';

    /**
     * @inheritdoc
     */
    protected const WIDGET_PARAMS = [
        'buttonStyle',
        'buttonSize',
        'disabled',
        'icon',
        'label',
        'labelClass',
        'labelId'
    ];

    protected $disabled = null;
    protected $icon = null;
    protected $label = null;
    protected $labelClass = null;
    protected $labelId = null;

    /**
     * Initializes the widget
     * @param array $config
     */
    public function __construct( array $config = [] ) {
        parent::__construct( $config );

        $this->attribs = [
            'class' => static::BS_PREFIX
        ];

        foreach( static::getWidgetParams() as $widgetParam ) {
            # Required parameters
            if( $widgetParam == 'buttonStyle' ) {
                if( isset( $config[ $widgetParam ] ) ) {
                    $this->addButtonStyleClass( $config[ $widgetParam ] );
                } else {
                    $this->addButtonStyleClass();
                }
            } elseif( isset( $config[ $widgetParam ] ) ) {
                # Optional parameters
                if( $widgetParam == 'buttonSize' ) {
                    $this->addButtonSizeClass( $config[ $widgetParam ] );
                } else {
                    $this->$widgetParam = $config[ $widgetParam ];
                }
            }

            unset( $config[ $widgetParam ] );
        }

        # href
        if( isset( $config[ 'href' ] ) && !$config[ 'href' ] ) {
            # If 'href' is set but empty, remove it
            unset( $config[ 'href' ] );
        }

        if( isset( $config[ 'href' ] ) ) {
            # Link button
            $this->attribs[ 'role' ] = 'button';

            if( $this->disabled ) {
                # Set attributes for a link button that should be disabled
                $this->attribs[ 'class' ] .= ' disabled';
                $this->attribs[ 'aria-disabled' ] = 'true';
            }
        } else {
            # Plain button
            $this->attribs[ 'type' ] = 'button';
        }

        # class
        $this->attribs[ 'class' ] .= ' ' . $this->getWidgetElementClass( 'button' );

        if( isset( $config[ 'class' ] ) ) {
            $this->attribs[ 'class' ] .= ' ' . $config[ 'class' ];

            unset( $config[ 'class' ] );
        }

        # label/title
        if( $this->label && !isset( $config[ 'title' ] ) ) {
            $config[ 'title' ] = $this->label;
        }

        $this->attribs = array_merge( $this->attribs, $config );
    }

    /**
     * @inheritDoc
     */
    public function getHtml(): string {
        $html = '';

        $buttonElement = isset( $this->attribs[ 'href' ] ) ? 'a' : 'button';

        $html .= Html::openElement( $buttonElement, $this->attribs );

        if( $this->disabled && $buttonElement == 'button' ) {
            $html = substr( $html, 0 , -1) . ' disabled>';
        }

        if( $this->icon ) {
            if( $this->icon instanceof IconWidget ) {
                $html .= $this->icon;
            } else {
                $html .= new IconWidget([
                    'class' => $this->icon
                ] );
            }
        }

        if( $this->label ) {
            $labelClass = $this->icon ? 'ml-2' : '';

            $labelClass .= $labelClass ? ' ' : '';
            $labelClass .= $this->getWidgetElementClass( 'label' );

            if( $this->labelClass ) {
                $labelClass .= $labelClass ? ' ' . $this->labelClass : $this->labelClass;
            }

            $labelAttribs = [
                'class' => $labelClass
            ];

            if( $this->labelId ) {
                $labelAttribs[ 'id' ] = $this->labelId;
            }

            $html .= Html::rawElement( 'span', $labelAttribs, $this->label );
        }

        $html .= Html::closeElement( $buttonElement );

        return $html;
    }

    /**
     * Adds the button size class if applicable.
     * @param string $buttonSize
     */
    protected function addButtonSizeClass( string $buttonSize = '' ) {
        if( in_array( $buttonSize, BootstrapUI::VALID_BUTTON_SIZES ) ) {
            $this->attribs[ 'class' ] .= ' ' . $buttonSize;
        }
    }

    /**
     * Adds the button style class if applicable.
     * @param string $buttonStyle
     */
    protected function addButtonStyleClass( string $buttonStyle = '' ) {
        $this->attribs[ 'class' ] .= ' ';

        if( in_array( $buttonStyle, BootstrapUI::VALID_BUTTON_STYLES ) ) {
            $this->attribs[ 'class' ] .= $buttonStyle;
        } else {
            $this->attribs[ 'class' ] .= BootstrapUI::DEFAULT_BUTTON_STYLE;
        }
    }

    /**
     * Gets BootstrapUI classes to allow for subsequent modification
     * @param string $element
     * @return string
     */
    protected function getWidgetElementClass( string $element ): string {
        $elementClass = '';

        if( $element == 'button' ) {
            $elementClass = static::bsUiPrefix() . 'button';

            if( $this->icon ) {
                $elementClass .= ' ' . static::bsUiPrefix() . 'buttonHasIcon';
            }

            if( $this->label ) {
                $elementClass .= ' ' . static::bsUiPrefix() . 'buttonHasLabel';
            }
        } elseif( $element == 'icon' ) {
            $elementClass = static::bsUiPrefix() . 'buttonIcon';
        } elseif( $element == 'label' ) {
            $elementClass = static::bsUiPrefix() . 'buttonLabel';
        }

        return $elementClass;
    }
}