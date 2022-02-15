<?php

namespace ElegantThemes\Admin;

/**
 * Admin Installer Class
 */
class Installer {

    /**
     * Add versioning
     *
     * @return void
     */
    public function add_version() {
        update_option( 'elegant_themes_version', ElegantThemes_VERSION );

        $installed = get_option( 'elegant_themes_installed' );

        if ( ! $installed ) {
            update_option( 'elegant_themes_installed', time() );
        }

    }
}
