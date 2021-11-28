<?php


namespace BootstrapUI;

class CheckboxInputWidget extends CheckInputWidget {

    /**
     * @inheritDoc
     */
    public const ID = 'checkboxInput';

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
        $this->attribs = [
            'type' => 'checkbox'
        ];

        parent::__construct( $config );
    }

    /**
     * @inheritDoc
     */
    protected function getWidgetElementClass( string $element = self::ID ): string {
        return static::bsUiPrefix() . $element;
    }
}