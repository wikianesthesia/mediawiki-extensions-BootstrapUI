<?php


namespace BootstrapUI;

use Html;

abstract class InputWidget extends Widget {

    /**
     * @inheritDoc
     */
    public const ID = 'input';

    /**
     * @inheritDoc
     */
    protected const WIDGET_PARAMS = [
        'containerClass',
        'containerId',
        'disabled',
        'help',
        'label',
        'labelClass',
        'labelId',
        'required',
        'validation',
        'validationId'
    ];

    protected $containerClass = null;
    protected $containerId = null;
    protected $disabled = null;
    protected $help = null;
    protected $invalidFeedback = null;
    protected $label = null;
    protected $labelClass = null;
    protected $labelId = null;
    protected $required = null;
    protected $validation = null;
    protected $validationId = null;
    protected $validFeedback = null;

    /**
     * Initializes the widget
     * @param array $config
     * @param string $contents
     */
    public function __construct( array $config = [] ) {
        parent::__construct( $config );

        foreach( static::getWidgetParams() as $widgetParam ) {
            if( isset( $config[ $widgetParam ] ) ) {
                if( $widgetParam == 'containerClass' || $widgetParam == 'labelClass' ) {
                    $this->$widgetParam = $this->$widgetParam ? $this->$widgetParam . ' ' . $config[ $widgetParam ] : $config[ $widgetParam ];
                } else {
                    $this->$widgetParam = $config[ $widgetParam ];
                }
            }

            unset( $config[ $widgetParam ] );
        }

        # class
        $this->attribs[ 'class' ] = isset( $this->attribs[ 'class' ] ) && $this->attribs[ 'class' ]
            ? $this->attribs[ 'class' ] . ' ' . $this->getWidgetElementClass()
            : $this->getWidgetElementClass();

        if( isset( $config[ 'class' ] ) ) {
            $this->attribs[ 'class' ] .= ' ' . $config[ 'class' ];

            unset( $config[ 'class' ] );
        }

        $this->attribs = array_merge( $this->attribs, $config );
    }

    /**
     * @return string
     */
    protected function getHelpHtml( string $helpId = '' ): string {
        $html = '';

        if( $this->help ) {
            if( !$helpId ) {
                $helpId = $this->attribs[ 'id' ] ? $this->attribs[ 'id' ] . '-help' : static::makeUniqueId( 'help' );
            }

            $this->attribs[ 'aria-describedby' ] = $helpId;

            $html .= Html::rawElement( 'small', [
                'id' => $helpId,
                'class' => 'form-text text-muted'
            ], $this->help );
        }

        return $html;
    }

    /**
     * @return string
     */
    protected function getLabelHtml( string $labelElement = 'label' ): string {
        $html = '';

        if( $this->label ) {
            if( !isset( $this->attribs[ 'id' ] ) || !$this->attribs[ 'id' ] ) {
                $this->attribs[ 'id' ] = static::makeUniqueId();
            }

            $labelAttribs = [
                'for' => $this->attribs[ 'id' ]
            ];

            if( $this->labelClass ) {
                $labelAttribs[ 'class' ] = $this->labelClass;
            }

            if( $this->labelId ) {
                $labelAttribs[ 'id' ] = $this->labelId;
            }

            $html .= Html::rawElement( $labelElement, $labelAttribs, $this->label );
        }

        return $html;
    }

    /**
     * @param string $invalidFeedback
     * @param string $validFeedback
     * @return string
     */
    protected function getValidationHtml( string $invalidFeedback = '', string $validFeedback = '' ): string {
        $html = '';

        if( $this->validation ) {
            if( !isset( $this->attribs[ 'id' ] ) || !$this->attribs[ 'id' ] ) {
                $this->attribs[ 'id' ] = static::makeUniqueId();
            }

            $validationId = $this->validationId ? $this->validationId : $this->attribs[ 'id' ];

            $html .= Html::rawElement( 'div', [
                'class' => 'invalid-feedback',
                'id' => $validationId . '-invalid-feedback'
            ], $invalidFeedback );

            $html .= Html::rawElement( 'div', [
                'class' => 'valid-feedback',
                'id' => $validationId . '-valid-feedback'
            ], $validFeedback );
        }

        return $html;
    }

    abstract protected function getWidgetElementClass( string $element );
}