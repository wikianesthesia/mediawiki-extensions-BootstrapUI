( function ( global ) {

    'use strict';

    /**
     * Namespace for all classes, static methods and static properties.
     *
     * @namespace BootstrapUI
     * @class
     * @singleton
     */
    var BootstrapUI = {};

    if ( typeof module !== 'undefined' && module.exports ) {
        module.exports = BootstrapUI;
    } else {
        global.BootstrapUI = BootstrapUI;
    }

}( this ) );

window.BootstrapUI = module.exports;