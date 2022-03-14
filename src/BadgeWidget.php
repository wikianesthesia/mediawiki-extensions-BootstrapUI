<?php

namespace BootstrapUI;

use Html;

class BadgeWidget extends Widget {

    public const ID = 'badge';

    public const BS_PREFIX = 'badge';

    /**
     * @inheritDoc
     */
    protected const WIDGET_PARAMS = [
        'badgeStyle',
        'pill',
        'size'
    ];

    /**
     * Stores the contents of the badge
     * @var string
     */
    protected $contents = null;

    protected $pill = null;
    protected $size = null;

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

        if( isset( $config[ 'pill' ] ) && $config[ 'pill' ] ) {
            $this->attribs[ 'class' ] .= ' badge-pill';
        }

        foreach( static::getWidgetParams() as $widgetParam ) {
            # Required parameters
            if( $widgetParam == 'badgeStyle' ) {
                if( isset( $config[ $widgetParam ] ) ) {
                    $this->addBadgeStyleClass( $config[ $widgetParam ] );
                } else {
                    $this->addBadgeStyleClass();
                }
            }
            elseif( $widgetParam === 'size' && isset( $config[ $widgetParam ] ) ) {
                if( intval( $config[ $widgetParam ] ) == $config[ $widgetParam ] &&
                    $config[ $widgetParam ] >= 1 && $config[ $widgetParam ] <= 6 ) {
                    $this->size = $config[ $widgetParam ];
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
        $html = Html::rawElement( 'div', $this->attribs, $this->contents );

        if( $this->size ) {
            $html = Html::rawElement( 'h' . $this->size, [], $html );
        }

        return $html;
    }

    /**
     * Adds the badge style class if applicable.
     * @param string $alertStyle
     * @return bool
     */
    protected function addBadgeStyleClass( string $badgeStyle = '' ) {
        $this->attribs[ 'class' ] .= ' ';

        if( in_array( $badgeStyle, BootstrapUI::VALID_BADGE_STYLES ) ) {
            $this->attribs[ 'class' ] .= $badgeStyle;
        } else {
            $this->attribs[ 'class' ] .= BootstrapUI::DEFAULT_BADGE_STYLE;
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