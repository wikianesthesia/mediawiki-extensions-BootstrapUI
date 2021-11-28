<?php


namespace BootstrapUI;

use Html;

abstract class CheckInputWidget extends InputWidget {

    /**
     * @inheritDoc
     */
    public const ID = 'checkInput';

    /**
     * @inheritDoc
     */
    protected const WIDGET_PARAMS = [
        'inline',
        'options',
        'value'
    ];

    protected $inline = null;
    protected $options = null;
    protected $value = null;

    /**
     * Initializes the widget
     * @param array $config
     * @param string $contents
     */
    public function __construct( array $config = [] ) {
        parent::__construct( $config );
    }

    /**
     * @inheritDoc
     */
    public function getHtml(): string {
        $html = '';

        $containerClass = 'mb-3';

        if( $this->containerClass ) {
            $containerClass .= ' ' . $this->containerClass;
        }

        if( !isset( $this->attribs[ 'id' ] ) || !$this->attribs[ 'id' ] ) {
            $this->attribs[ 'id' ] = static::makeUniqueId();
        }

        $containerAttribs = [
            'class' => $containerClass,
            'id' => $this->attribs[ 'id' ]
        ];

        $helpHtml = $this->getHelpHtml();

        if( $this->attribs[ 'aria-describedby' ] ) {
            $containerAttribs[ 'aria-describedby' ] = $this->attribs[ 'aria-describedby' ];
        }

        $html .= Html::openElement( 'fieldset', $containerAttribs );

        # TODO Hacky. Incorporating table-based classes is not ideal here
        $this->labelClass = $this->labelClass ? $this->labelClass . ' col-form-label' : 'col-form-label';

        $html .= $this->getLabelHtml( 'legend' );

        $optionCount = 0;

        foreach( $this->options as $optionConfig ) {
            $optionCount++;

            $optionConfig[ 'type' ] = $this->getAttrib( 'type' );

            if( $this->getAttrib( 'class' ) ) {
                $optionConfig[ 'class' ] = isset( $optionConfig[ 'class' ] ) && $optionConfig[ 'class' ]
                    ? $this->getAttrib( 'class' ) . ' ' . $optionConfig[ 'class' ]
                    : $this->getAttrib( 'class' );
            }

            if( $optionConfig[ 'type' ] == 'radio' && $this->getAttrib( 'name' ) ) {
                $optionConfig[ 'name' ] = $this->getAttrib( 'name' );
            } elseif( !isset( $optionConfig[ 'name' ] ) && $this->getAttrib( 'name' ) ) {
                $optionConfig[ 'name' ] = $this->getAttrib( 'name' ) . '[' . $optionCount . ']';
            }

            if( !isset( $optionConfig[ 'id' ] ) || !$optionConfig[ 'id' ] ) {
                $optionConfig[ 'id' ] = $this->attribs[ 'id' ] . '-' . $optionCount;
            }

            if( $this->inline ) {
                $inlineClass = 'form-check-inline';

                $optionConfig[ 'containerClass' ] = isset( $optionConfig[ 'containerClass' ] ) && $optionConfig[ 'containerClass' ]
                    ? $optionConfig[ 'containerClass' ] . ' ' . $inlineClass : $inlineClass;
            }

            if( !isset( $optionConfig[ 'checked' ] ) && isset( $optionConfig[ 'value' ] ) ) {
                if( !is_null( $this->value ) ) {
                    $optionConfig[ 'checked' ] = (string) $this->value == (string) $optionConfig[ 'value' ];
                }
            }

            if( $this->validation && $optionCount == count( $this->options ) ) {
                $optionConfig[ 'validation' ] = true;
                $optionConfig[ 'validationId' ] = $this->attribs[ 'id' ];
            }

            if( $this->disabled ) {
                $optionConfig[ 'disabled' ] = true;
            }

            if( $this->required ) {
                $optionConfig[ 'required' ] = true;
            }

            $html .= new CheckOptionInputWidget( $optionConfig );
        }

        $html .= $helpHtml;

        $html .= Html::closeElement( 'fieldset' );

        return $html;
    }
}