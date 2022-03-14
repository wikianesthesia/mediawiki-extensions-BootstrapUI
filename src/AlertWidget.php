<?php

namespace BootstrapUI;

use Html;

class AlertWidget extends Widget {

    public const ID = 'alert';

    public const BS_PREFIX = 'alert';

    /**
     * @inheritDoc
     */
    protected const WIDGET_PARAMS = [
        'alertStyle',
        'contents',
        'dismissible',
        'heading',
        'headingClass',
        'headingId'
    ];

    /**
     * Stores the contents of the alert
     * @var string
     */
    protected $contents = null;

    protected $dismissible = null;
    protected $heading = null;
    protected $headingClass = null;
    protected $headingId = null;

    /**
     * Initializes the widget
     * @param array $config
     * @param string $contents
     */
    public function __construct( array $config = [], string $contents = '' ) {
        parent::__construct( $config );

        $this->attribs = [
            'class' => static::BS_PREFIX,
            'role' => 'alert'
        ];

        foreach( static::getWidgetParams() as $widgetParam ) {
            # Required parameters
            if( $widgetParam == 'alertStyle' ) {
                if( isset( $config[ $widgetParam ] ) ) {
                    $this->addAlertStyleClass( $config[ $widgetParam ] );
                } else {
                    $this->addAlertStyleClass();
                }
            } elseif( isset( $config[ $widgetParam ] ) ) {
                $this->$widgetParam = $config[ $widgetParam ];
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

        $dismissHtml = '';

        if( $this->dismissible ) {
            $this->attribs[ 'class' ] .= ' ' . static::BS_PREFIX . '-dismissible fade show';

            $dismissHtml .= Html::rawElement( 'button', [
                    'type' => 'button',
                    'class' => 'close',
                    'data-dismiss' => 'alert',
                    'aria-label' => wfMessage( 'bootstrapui-close' )->text()
                ], Html::rawElement( 'span', [
                        'aria-hidden' => 'true'
                    ], '&times;'
                )
            );
        }

        $html .= Html::openElement( 'div', $this->attribs );

        if( $this->heading ) {
            $headingClass = static::BS_PREFIX . '-heading';

            if( $this->headingClass ) {
                $headingClass .= ' ' . $this->headingClass;
            }

            $headingAttribs = [
                'class' => $headingClass
            ];

            if( $this->headingId ) {
                $headingAttribs[ 'id' ] = $this->headingId;
            }

            $html .= Html::rawElement( 'h4', $headingAttribs, $this->heading );
        }

        # TODO add 'alert-link' class to any link in contents
        $html .= $this->contents;

        $html .= $dismissHtml;

        $html .= Html::closeElement( 'div' );

        return $html;
    }

    /**
     * Adds the alert style class if applicable.
     * @param string $alertStyle
     * @return bool
     */
    protected function addAlertStyleClass( string $alertStyle = '' ) {
        $this->attribs[ 'class' ] .= ' ';

        if( in_array( $alertStyle, BootstrapUI::VALID_ALERT_STYLES ) ) {
            $this->attribs[ 'class' ] .= $alertStyle;
        } else {
            $this->attribs[ 'class' ] .= BootstrapUI::DEFAULT_ALERT_STYLE;
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