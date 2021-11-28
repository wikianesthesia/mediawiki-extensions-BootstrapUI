<?php


namespace BootstrapUI;

use Html;

class TextInputWidget extends InputWidget {

    /**
     * @inheritDoc
     */
    public const ID = 'textInput';

    /**
     * @inheritDoc
     */
    protected const WIDGET_PARAMS = [
        'readonly'
    ];

    protected $readonly = null;

    /**
     * Initializes the widget
     * @param array $config
     * @param string $contents
     */
    public function __construct( array $config = [] ) {
        $this->attribs = [
            'class' => 'form-control',
            'type' => 'text'
        ];

        parent::__construct( $config );

        if( $this->readonly ) {
            $this->attribs[ 'class' ] = str_replace( 'form-control', 'form-control-plaintext', $this->attribs[ 'class' ] );
        }
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

        $containerAttribs = [
            'class' => $containerClass
        ];

        if( $this->containerId ) {
            $containerAttribs[ 'id' ] = $this->containerId;
        }

        $html .= Html::openElement( 'div', $containerAttribs );

        $html .= $this->getLabelHtml();

        # These must be called before creating input tag since it may add to attribs
        $validationHtml = $this->getValidationHtml();
        $helpHtml = $this->getHelpHtml();

        $html .= Html::openElement( 'input', $this->attribs );

        if( $this->disabled ) {
            $html = substr( $html, 0 , -1) . ' disabled>';
        }

        if( $this->readonly ) {
            $html = substr( $html, 0 , -1) . ' readonly>';
        }

        if( $this->required ) {
            $html = substr( $html, 0 , -1) . ' required>';
        }

        $html .= $validationHtml;
        $html .= $helpHtml;

        $html .= Html::closeElement( 'div' );

        return $html;
    }

    /**
     * @inheritDoc
     */
    protected function getWidgetElementClass( string $element = self::ID ): string {
        return static::bsUiPrefix() . $element;
    }
}