<?php


namespace BootstrapUI;

use Html;

class NavManager {
    private $nav = [];

    private $id = '';
    private $style = BootstrapUI::NAV_STYLE_PLAIN;

    private $htmlGenerated = false;
    private $navHtml = '';
    private $tabContentHtml = '';

    public function __construct( array $config = [] ) {
        if( isset( $config[ 'id' ] ) ) {
            $this->setId( $config[ 'id' ] );
        } else {
            $this->setId();
        }

        if( isset( $config[ 'style' ] ) ) {
            $this->setStyle( $config[ 'style' ] );
        } else {
            $this->setStyle();
        }
    }

    public function addDropdownDivider( string $navId ) {
        if( !isset( $this->nav[ $navId ] ) || !isset( $this->nav[ $navId ][ 'dropdownItems' ] ) ) {
            return false;
        }

        $this->nav[ $navId ][ 'dropdownItems' ][] = Html::rawElement( 'div', [
            'class' => 'dropdown-divider'
        ] );

        $this->htmlGenerated = false;

        return true;
    }

    public function addDropdownItem( string $navId, array $config, string $contents = '' ) {
        if( !isset( $this->nav[ $navId ] ) ) {
            return false;
        }

        if( !isset( $this->nav[ $navId ][ 'dropdownItems' ] ) ) {
            $this->nav[ $navId ][ 'dropdownItems' ] = [];
        }

        if( $contents ) {
            $config[ 'contents' ] = $contents;
        }

        $this->nav[ $navId ][ 'dropdownItems' ][] = $config;

        $this->htmlGenerated = false;

        return true;
    }

    public function addNavItem( string $navItemId, array $config, string $contents = '' ) {
        $config[ 'id' ] = 'nav-' . $navItemId;

        $this->nav[ $navItemId ] = $config;

        if( $contents ) {
            $this->nav[ $navItemId ][ 'contents' ] = $contents;
        }

        $this->htmlGenerated = false;

        return true;
    }

    public function addTabPane( string $navItemId, array $config, string $contents ) {
        if( !isset( $this->nav[ $navItemId ] ) ) {
            return false;
        }

        $this->nav[ $navItemId ][ 'pane' ] = $config;

        $this->nav[ $navItemId ][ 'pane' ][ 'contents' ] = $contents;

        $this->htmlGenerated = false;

        return true;
    }

    public function clearNav() {
        $this->nav = [];

        $this->htmlGenerated = false;
    }

    protected function generateHtml() {
        if( $this->htmlGenerated || !$this->hasNavItems() ) {
            return;
        }

        $navAttribs = [
            'class' => 'nav',
            'id' => 'nav-' . $this->id
        ];

        if( $this->style === BootstrapUI::NAV_STYLE_BUTTON ) {
            // Collapse all tabs and dropdowns into a single button with one dropdown
            $navAttribs[ 'class' ] .= ' nav-button';
            unset( $navAttribs[ 'id' ] );

            $oldNav = $this->nav;

            $this->clearNav();

            $navItemId = 'menu';

            $buttonContents = BootstrapUI::iconWidget( [ 'class' => 'fas fa-ellipsis-v fa-fw' ] ) .
                Html::rawElement( 'span', [
                    'class' => 'nav-label bs-ui-hideMobile'
                ], wfMessage( 'bootstrapui-menu' )->text() );

            $this->addNavItem( $navItemId, [], $buttonContents );

            foreach( $oldNav as $oldNavItem ) {
                if( isset( $oldNavItem[ 'dropdownItems' ] ) ) {
                    foreach( $oldNavItem[ 'dropdownItems' ] as $oldDropdownItem ) {
                        if( is_array( $oldDropdownItem ) ) {
                            $this->addDropdownItem( $navItemId, $oldDropdownItem );
                        } else {
                            $this->addDropdownDivider( $navItemId );
                        }
                    }
                } elseif( isset( $oldNavItem[ 'href' ] ) ) {
                    $this->addDropdownItem( $navItemId, $oldNavItem );
                }
            }
        } elseif( $this->style === BootstrapUI::NAV_STYLE_PILLS ) {
            $navAttribs[ 'class' ] .= ' nav-pills';
        } elseif( $this->style === BootstrapUI::NAV_STYLE_TABS ) {
            $navAttribs[ 'class' ] .= ' nav-tabs';
        }

        $navHtml = '';
        $tabContentHtml = '';

        foreach( $this->nav as $navItemId => $navItem ) {
            $dropdownItemsHtml = '';

            $navItemAttribs = [
                'class' => 'nav-item'
            ];

            $navLinkAttribs = [
                'href' => '#0',
                'id' => 'nav-link-' . $navItemId
            ];

            if( $this->style === BootstrapUI::NAV_STYLE_BUTTON ) {
                $navLinkAttribs[ 'class' ] = 'btn btn-outline-primary btn-sm';
            } else {
                $navLinkAttribs[ 'class' ] = 'nav-link';
            }

            $navLinkAttribs[ 'class' ] .= ' nav-link-' . $this->id;

            if( isset( $navItem[ 'active' ] ) && $navItem[ 'active' ] ) {
                $navLinkAttribs[ 'class' ] .= ' active';
            }

            if( isset( $navItem[ 'dropdownItems' ] ) && !empty( $navItem[ 'dropdownItems' ] ) ) {
                $navItemAttribs[ 'class' ] .= ' dropdown';

                $navLinkAttribs[ 'class' ] .= ' dropdown-toggle';
                $navLinkAttribs = array_merge( $navLinkAttribs, [
                    'data-toggle' => 'dropdown',
                    'role' => 'button',
                    'aria-haspopup' => 'true',
                    'aria-expanded' => 'false'
                ] );

                foreach( $navItem[ 'dropdownItems' ] as $dropdownItem ) {
                    if( is_array( $dropdownItem ) ) {
                        $dropdownItemAttribs = [
                            'class' => 'dropdown-item',
                            'href' => isset( $dropdownItem[ 'href' ] ) ? $dropdownItem[ 'href' ] : '#'
                        ];

                        if( isset( $dropdownItem[ 'id' ] ) ) {
                            $dropdownItemAttribs[ 'id' ] = $dropdownItem[ 'id' ];
                        }

                        $dropdownItemsHtml .= Html::rawElement( 'a', $dropdownItemAttribs, $dropdownItem[ 'contents' ] );
                    } else {
                        $dropdownItemsHtml .= $dropdownItem;
                    }
                }
            } elseif( isset( $navItem[ 'pane' ] ) && !empty( $navItem[ 'pane' ] ) ) {
                $navLinkAttribs = array_merge( $navLinkAttribs, [
                    'data-toggle' => $this->style === BootstrapUI::NAV_STYLE_PILLS ? 'pill' : 'tab',
                    'href' => '#' . $navItemId,
                    'role' => 'tab',
                    'aria-controls' => $navItemId,
                    'aria-selected' => isset( $navItem[ 'active' ] ) && $navItem[ 'active' ] ? 'true' : 'false'
                ] );

                $tabPaneAttribs = [
                    'class' => 'tab-pane',
                    'id' => $navItemId,
                    'role' => 'tabpanel',
                    'aria-labelledby' => $navLinkAttribs[ 'id' ]
                ];

                if( isset( $navItem[ 'pane' ][ 'fade' ] ) && $navItem[ 'pane' ][ 'fade' ] ) {
                    $tabPaneAttribs[ 'class' ] .= ' fade';
                }

                if( isset( $navItem[ 'active' ] ) && $navItem[ 'active' ] ) {
                    if( isset( $navItem[ 'pane' ][ 'fade' ] ) && $navItem[ 'pane' ][ 'fade' ] ) {
                        $tabPaneAttribs[ 'class' ] .= ' show';
                    }

                    $tabPaneAttribs[ 'class' ] .= ' active';
                }

                $tabContentHtml .= Html::rawElement( 'div', $tabPaneAttribs, $navItem[ 'pane' ][ 'contents' ] );
            } else {
                if( isset( $navItem[ 'href' ] ) ) {
                    $navLinkAttribs[ 'href' ] = $navItem[ 'href' ];
                }
            }

            $navItemHtml = Html::rawElement( 'a' , $navLinkAttribs, $navItem[ 'contents' ] );

            if( $dropdownItemsHtml ) {
                $dropdownAttribs = [
                    'class' => 'dropdown-menu'
                ];

                if( $navItemId == array_key_last( $this->nav ) ) {
                    $dropdownAttribs[ 'class' ] .= ' dropdown-menu-right';
                }

                $dropdownItemsHtml = Html::rawElement( 'div', $dropdownAttribs, $dropdownItemsHtml);
                $navItemHtml .= $dropdownItemsHtml;
            }

            $navHtml .= Html::rawElement( 'li', $navItemAttribs, $navItemHtml );
        }

        if( $tabContentHtml ) {
            $navAttribs[ 'role' ] = 'tablist';

            $tabContentHtml = Html::rawElement( 'div', [
                'class' => 'tab-content',
                'id' => 'nav-' . $this->id . '-tab-content'
            ], $tabContentHtml );
        }

        $this->navHtml = Html::rawElement( 'ul', $navAttribs, $navHtml );
        $this->tabContentHtml = $tabContentHtml;
    }

    public function getNavHtml(): string {
        $this->generateHtml();

        return $this->navHtml;
    }

    public function getNavItem( string $navId ) {
        return isset( $this->nav[ $navId ] ) ? $this->nav[ $navId ] : false;
    }

    public function getStyle( ): string {
        return $this->style;
    }

    public function getTabContentHtml() {
        $this->generateHtml();

        return $this->tabContentHtml;
    }

    public function hasNavItem( string $navId ) {
        return isset( $this->nav[ $navId ] );
    }

    public function hasNavItems() {
        return !empty( $this->nav );
    }

    public function positionNavItem( string $navId, string $position ) {
        if( !isset( $this->nav[ $navId ] ) ) {
            return false;
        }

        $navItem = $this->nav[ $navId ];
        unset( $this->nav[ $navId ] );

        if( $position === 'first' ) {
            $this->nav = [ $navId => $navItem ] + $this->nav;
        } elseif( $position === 'last' ) {
            $this->nav = $this->nav + [ $navId => $navItem ];
        }

        $this->htmlGenerated = false;

        return true;
    }

    public function removeNavItem( string $navId ) {
        unset( $this->nav[ $navId ] );

        $this->htmlGenerated = false;
    }

    public function setId( string $navid = '' ) {
        if( !$navid ) {
            $navid = 'main';
        }

        $this->id = $navid;

        $this->htmlGenerated = false;
    }

    public function setStyle( string $navStyle = '' ) {
        if( !in_array( $navStyle, BootstrapUI::VALID_NAV_STYLES ) ) {
            $navStyle = BootstrapUI::NAV_STYLE_TABS;
        }

        $this->style = $navStyle;

        $this->htmlGenerated = false;
    }

}