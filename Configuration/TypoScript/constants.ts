
plugin.tx_geoiphandler_geoiphandler {
    view {
        # cat=plugin.tx_geoiphandler_geoiphandler/file; type=string; label=Path to template root (FE)
        templateRootPath = EXT:geo_ip_handler/Resources/Private/Templates/
        # cat=plugin.tx_geoiphandler_geoiphandler/file; type=string; label=Path to template partials (FE)
        partialRootPath = EXT:geo_ip_handler/Resources/Private/Partials/
        # cat=plugin.tx_geoiphandler_geoiphandler/file; type=string; label=Path to template layouts (FE)
        layoutRootPath = EXT:geo_ip_handler/Resources/Private/Layouts/
    }
    persistence {
        # cat=plugin.tx_geoiphandler_geoiphandler//a; type=string; label=Default storage PID
        storagePid =
    }
}
