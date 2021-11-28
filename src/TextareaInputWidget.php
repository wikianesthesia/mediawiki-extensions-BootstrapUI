<?php


namespace BootstrapUI;

use Html;

class TextareaInputWidget extends InputWidget {

    /**
     * @inheritDoc
     */
    public const ID = 'textareaInput';

    /**
     * @inheritDoc
     */
    protected const WIDGET_PARAMS = [
        'readonly',
        'value'
    ];

    /**
     * Stores the value of the textarea
     * @var string
     */
    protected $value = '';

    /**
     * Initializes the widget
     * @param array $config
     */
    public function __construct( array $config = [] ) {
        $this->attribs = [
            'class' => 'form-control'
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
            # TODO Testing required: It may be important for other bootstrap classes (e.g table cells) to appear before mb-3
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

        # This must be called before creating input tag since it may add to attribs
        $validationHtml = $this->getValidationHtml();
        $helpHtml = $this->getHelpHtml();

        $html .= Html::rawElement( 'textarea', $this->attribs, $this->value );

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