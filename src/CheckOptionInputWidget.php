<?php


namespace BootstrapUI;

use Html;

class CheckOptionInputWidget extends InputWidget {

    /**
     * @inheritDoc
     */
    public const ID = 'checkOption';

    /**
     * @inheritDoc
     */
    protected const WIDGET_PARAMS = [
        'checked'
    ];

    protected $checked = null;

    /**
     * Initializes the widget
     * @param array $config
     * @param string $contents
     */
    public function __construct( array $config = [] ) {
        $this->attribs = [
            'class' => 'form-check-input'
        ];

        parent::__construct( $config );
    }

    /**
     * @inheritDoc
     */
    public function getHtml(): string {
        $html = '';

        $containerClass = 'form-check';

        if( $this->containerClass ) {
            $containerClass .= ' ' . $this->containerClass;
        }

        $html .= Html::openElement( 'div', [
            'class' => $containerClass
        ] );

        $this->labelClass = 'form-check-label' .
            ( $this->labelClass ? ' ' . $this->labelClass : '' );

        $validationHtml = $this->getValidationHtml();

        # This must be called before creating input tag since it may add set the id
        $labelHtml = $this->getLabelHtml();

        $html .= Html::openElement( 'input', $this->attribs );

        if( $this->checked ) {
            $html = substr( $html, 0, -1 ) . ' checked>';
        }

        if( $this->required ) {
            $html = substr( $html, 0 , -1) . ' required>';
        }

        if( $this->disabled ) {
            $html = substr( $html, 0, -1 ) . ' disabled>';
        }

        $html .= $labelHtml;
        $html .= $validationHtml;

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